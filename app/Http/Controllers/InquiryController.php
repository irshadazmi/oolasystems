<?php

namespace App\Http\Controllers;

use App\Jobs\AnalyzeInquiryJob;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    /**
     * Display inquiries.
     */
    public function index(Request $request)
    {
        $query = Inquiry::query();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('project_type', 'like', "%{$search}%");
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Overall Inquiry Status
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        /*
        |--------------------------------------------------------------------------
        | Lead Temperature
        |--------------------------------------------------------------------------
        */

        if ($request->filled('temperature')) {
            $query->where(
                'lead_temperature',
                $request->temperature
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Lead Score
        |--------------------------------------------------------------------------
        */

        if ($request->filled('min_score')) {
            $query->where(
                'lead_score',
                '>=',
                (int) $request->min_score
            );
        }

        if ($request->filled('max_score')) {
            $query->where(
                'lead_score',
                '<=',
                (int) $request->max_score
            );
        }

        /*
        |--------------------------------------------------------------------------
        | AI Status
        |--------------------------------------------------------------------------
        */

        if ($request->filled('ai_status')) {
            match ($request->ai_status) {
                'Analyzed' => $query->where(
                    'ai_status',
                    'Completed'
                ),

                'Pending' => $query->whereIn(
                    'ai_status',
                    ['Pending', 'Processing']
                ),

                'Failed' => $query->where(
                    'ai_status',
                    'Failed'
                ),

                default => null,
            };
        }

        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        |
        | The view uses "priority", so keep the controller consistent
        | with that parameter.
        |
        */

        match ($request->input('priority', 'latest')) {
            'highest_score' => $query
                ->orderByDesc('lead_score')
                ->latest('created_at'),

            'hot' => $query
                ->orderByDesc('lead_temperature')
                ->orderByDesc('lead_score')
                ->latest('created_at'),

            'warm' => $query
                ->where('lead_temperature', 'WARM')
                ->orderByDesc('lead_score')
                ->latest('created_at'),

            'oldest' => $query
                ->oldest('created_at'),

            default => $query
                ->latest('created_at'),
        };

        $inquiries = $query
            ->paginate(10)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Lead Statistics
        |--------------------------------------------------------------------------
        */

        $totalLeads = Inquiry::whereNotNull('lead_score')->count();

        $hotLeads = Inquiry::where(
            'lead_temperature',
            'HOT'
        )->count();

        $warmLeads = Inquiry::where(
            'lead_temperature',
            'WARM'
        )->count();

        $qualifiedLeads = Inquiry::where(
            'lead_temperature',
            'QUALIFIED'
        )->count();

        return view('admin.inquiries.index', [
            'inquiries' => $inquiries,
            'totalLeads' => $totalLeads,
            'hotLeads' => $hotLeads,
            'warmLeads' => $warmLeads,
            'qualifiedLeads' => $qualifiedLeads,
        ]);
    }

    /**
     * Store a new inquiry.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required|string|max:100',
                'email' => 'required|email|max:150',
                'project_type' => 'required|string|max:100',
                'message' => 'required|string|min:10',
                'captcha' => 'required',
            ],
            [],
            [],
            'inquiry'
        );

        if (
            (int) $request->captcha !==
            (int) session('captcha_inquiry_answer')
        ) {
            return back()
                ->withErrors(
                    [
                        'captcha' => 'Incorrect captcha answer',
                    ],
                    'inquiry'
                )
                ->withInput();
        }

        session()->forget([
            'captcha_inquiry_answer',
            'captcha_inquiry_question',
        ]);

        $inquiry = Inquiry::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'project_type' => $validated['project_type'],
            'message' => $validated['message'],

            // Overall inquiry state
            'status' => 'New',

            // Sales lifecycle
            'lead_status' => 'New',

            // AI processing state
            'ai_status' => 'Pending',
        ]);

        AnalyzeInquiryJob::dispatch($inquiry->id);

        return back()->with(
            'inquiry_success',
            'Inquiry submitted successfully!'
        );
    }

    /**
     * Show inquiry details.
     */
    public function show(Inquiry $inquiry)
    {
        return view('admin.inquiries.show', [
            'inquiry' => $inquiry,
        ]);
    }

    /**
     * Edit inquiry.
     */
    public function edit(Inquiry $inquiry)
    {
        return view('admin.inquiries.edit', [
            'inquiry' => $inquiry,
        ]);
    }

    /**
     * Update overall inquiry state / response.
     */
    public function update(
        Request $request,
        Inquiry $inquiry
    ) {
        $validated = $request->validate([
            'status' => [
                'required',
                'in:New,Read,Replied,Closed',
            ],
            'response' => 'nullable|string',
        ]);

        $inquiry->update([
            'status' => $validated['status'],
            'response' => $validated['response'] ?? null,
        ]);

        return back()->with(
            'success',
            'Inquiry updated successfully!'
        );
    }

    /**
     * Delete inquiry.
     */
    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();

        return redirect()
            ->route('admin.inquiries.index')
            ->with(
                'success',
                'Inquiry deleted successfully!'
            );
    }

    /**
     * Re-analyze inquiry using AI.
     */
    public function reanalyze(Inquiry $inquiry)
    {
        /*
        |--------------------------------------------------------------------------
        | Do not re-analyze closed lead lifecycles.
        |--------------------------------------------------------------------------
        */

        if (
            in_array(
                $inquiry->lead_status,
                ['Converted', 'Lost'],
                true
            )
        ) {
            return back()->with(
                'error',
                'AI re-analysis is disabled for Converted or Lost leads.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Do not queue duplicate AI jobs.
        |--------------------------------------------------------------------------
        */

        if (
            in_array(
                $inquiry->ai_status,
                ['Pending', 'Processing'],
                true
            )
        ) {
            return back()->with(
                'error',
                'AI analysis is already pending or processing.'
            );
        }

        $inquiry->update([
            'ai_status' => 'Pending',
        ]);

        AnalyzeInquiryJob::dispatch($inquiry->id);

        return back()->with(
            'success',
            'AI lead analysis has been queued for processing.'
        );
    }

    /**
     * Update lead lifecycle status.
     */
    public function updateLeadStatus(
        Request $request,
        Inquiry $inquiry
    ) {
        $validated = $request->validate([
            'lead_status' => [
                'required',
                'in:New,Contacted,Qualified,Converted,Lost',
            ],
        ]);

        $currentStatus = $inquiry->lead_status ?? 'New';
        $newStatus = $validated['lead_status'];

        /*
        |--------------------------------------------------------------------------
        | No change
        |--------------------------------------------------------------------------
        */

        if ($currentStatus === $newStatus) {
            return back()->with(
                'success',
                'Lead status remains unchanged.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Terminal states cannot be changed.
        |--------------------------------------------------------------------------
        */

        if (
            in_array(
                $currentStatus,
                ['Converted', 'Lost'],
                true
            )
        ) {
            return back()->with(
                'error',
                "Lead status '{$currentStatus}' is closed and cannot be changed."
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Allowed lifecycle transitions
        |--------------------------------------------------------------------------
        */

        $allowedTransitions = [
            'New' => [
                'Contacted',
                'Lost',
            ],

            'Contacted' => [
                'Qualified',
                'Lost',
            ],

            'Qualified' => [
                'Converted',
                'Lost',
            ],
        ];

        if (
            ! in_array(
                $newStatus,
                $allowedTransitions[$currentStatus] ?? [],
                true
            )
        ) {
            return back()->with(
                'error',
                "Invalid lead transition: {$currentStatus} → {$newStatus}."
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Update lead lifecycle
        |--------------------------------------------------------------------------
        */

        $updateData = [
            'lead_status' => $newStatus,
        ];

        /*
        |--------------------------------------------------------------------------
        | Contact timestamp
        |--------------------------------------------------------------------------
        |
        | Contacted is now the single UI path for recording contact.
        |
        */

        if (
            $newStatus === 'Contacted' &&
            $currentStatus !== 'Contacted'
        ) {
            $updateData['last_contacted_at'] = now();
        }

        $inquiry->update($updateData);

        return back()->with(
            'success',
            "Lead status updated to {$newStatus}."
        );
    }

    /**
     * Update follow-up information.
     */
    public function updateFollowUp(
        Request $request,
        Inquiry $inquiry
    ) {
        $validated = $request->validate([
            'follow_up_date' => 'nullable|date',
            'follow_up_notes' => 'nullable|string|max:5000',
        ]);

        $inquiry->update([
            'follow_up_date' =>
                $validated['follow_up_date'] ?? null,

            'follow_up_notes' =>
                $validated['follow_up_notes'] ?? null,
        ]);

        return back()->with(
            'success',
            'Follow-up details updated successfully.'
        );
    }

    /**
     * Legacy endpoint retained for route compatibility.
     *
     * The UI no longer uses this action.
     */
    public function markContacted(Inquiry $inquiry)
    {
        if (
            in_array(
                $inquiry->lead_status,
                ['Converted', 'Lost'],
                true
            )
        ) {
            return back()->with(
                'error',
                'This lead is already closed.'
            );
        }

        if ($inquiry->lead_status === 'Contacted') {
            return back()->with(
                'success',
                'Lead is already marked as contacted.'
            );
        }

        if ($inquiry->lead_status !== 'New') {
            return back()->with(
                'error',
                'Lead must be New before it can be marked as Contacted.'
            );
        }

        $inquiry->update([
            'lead_status' => 'Contacted',
            'last_contacted_at' => now(),
        ]);

        return back()->with(
            'success',
            'Lead marked as contacted.'
        );
    }
}