<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\LeadInquiry;
use App\Services\AILeadService;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    /**
     * Display all inquiries (Admin use)
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
        | Inquiry Status Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $query->where('status', $request->status);

        }


        /*
        |--------------------------------------------------------------------------
        | Lead Filters
        |--------------------------------------------------------------------------
        */

        if ($request->filled('temperature')) {

            $leadEmails = LeadInquiry::where(
                'lead_temperature',
                $request->temperature
            )
                ->pluck('email');

            $query->whereIn('email', $leadEmails);

        }


        if ($request->filled('min_score')) {

            $leadEmails = LeadInquiry::where(
                'lead_score',
                '>=',
                (int) $request->min_score
            )
                ->pluck('email');

            $query->whereIn('email', $leadEmails);

        }


        if ($request->filled('max_score')) {

            $leadEmails = LeadInquiry::where(
                'lead_score',
                '<=',
                (int) $request->max_score
            )
                ->pluck('email');

            $query->whereIn('email', $leadEmails);

        }


        /*
        |--------------------------------------------------------------------------
        | AI Processing Status
        |--------------------------------------------------------------------------
        */

        if ($request->filled('ai_status')) {

            if ($request->ai_status === 'analyzed') {

                $leadEmails = LeadInquiry::whereNotNull('ai_processed_at')
                    ->pluck('email');

                $query->whereIn('email', $leadEmails);

            } elseif ($request->ai_status === 'pending') {

                $leadEmails = LeadInquiry::whereNull('ai_processed_at')
                    ->pluck('email');

                $query->whereIn('email', $leadEmails);

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Lead Priority / Sorting
        |--------------------------------------------------------------------------
        */

        $leadSort = $request->input('lead_sort', 'latest');

        $leadScoreSubquery = LeadInquiry::select('lead_score')
            ->whereColumn(
                'lead_inquiries.email',
                'inquiries.email'
            )
            ->latest('id')
            ->limit(1);


        if ($leadSort === 'highest') {

            $query->orderByDesc($leadScoreSubquery)
                ->latest('inquiries.created_at');

        } elseif ($leadSort === 'lowest') {

            $query->orderBy($leadScoreSubquery)
                ->latest('inquiries.created_at');

        } else {

            $query->latest('inquiries.created_at');

        }


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $inquiries = $query
            ->paginate(10)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Load AI Lead Information
        |--------------------------------------------------------------------------
        */

        $leadInquiries = LeadInquiry::whereIn(
            'email',
            $inquiries->pluck('email')
        )
            ->latest()
            ->get()
            ->keyBy('email');


        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $totalLeads = LeadInquiry::count();

        $hotLeads = LeadInquiry::where(
            'lead_temperature',
            'HOT'
        )->count();

        $warmLeads = LeadInquiry::where(
            'lead_temperature',
            'WARM'
        )->count();

        $qualifiedLeads = LeadInquiry::where(
            'lead_temperature',
            'QUALIFIED'
        )->count();


        return view('admin.inquiries.index', compact(
            'inquiries',
            'leadInquiries',
            'totalLeads',
            'hotLeads',
            'warmLeads',
            'qualifiedLeads'
        ));
    }

    /**
     * Store new inquiry (Public)
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validate Inquiry
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'project_type' => 'required|string|max:100',
            'message' => 'required|string|min:10',
        ], [], [], 'inquiry');

        Log::info('PUBLIC INQUIRY STORE REACHED', [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'project_type' => $validated['project_type'],
        ]);


        /*
        |--------------------------------------------------------------------------
        | CAPTCHA Validation
        |--------------------------------------------------------------------------
        */

        if (
            (int) $request->captcha !==
            (int) session('captcha_inquiry_answer')
        ) {

            return back()
                ->withErrors(
                    ['captcha' => 'Incorrect captcha answer'],
                    'inquiry'
                )
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | Clear CAPTCHA Session
        |--------------------------------------------------------------------------
        */

        session()->forget([
            'captcha_inquiry_answer',
            'captcha_inquiry_question'
        ]);


        /*
        |--------------------------------------------------------------------------
        | Create Original Inquiry
        |--------------------------------------------------------------------------
        */

        $validated['status'] = 'New';

        $inquiry = Inquiry::create($validated);


        /*
        |--------------------------------------------------------------------------
        | Create LeadInquiry for AI Lead Processing
        |--------------------------------------------------------------------------
        */

        try {

            $leadInquiry = LeadInquiry::create([
                'name' => $inquiry->name,
                'email' => $inquiry->email,
                'project_type' => $inquiry->project_type,
                'message' => $inquiry->message,

                'status' => 'new',
                'lead_status' => 'New',
            ]);


            /*
            |--------------------------------------------------------------------------
            | Run AI Lead Analysis
            |--------------------------------------------------------------------------
            */

            $aiLeadService = app(
                AILeadService::class
            );

            $aiLeadService->analyze(
                $leadInquiry
            );


        } catch (\Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | Do NOT fail the public inquiry if AI processing fails
            |--------------------------------------------------------------------------
            |
            | The inquiry has already been successfully stored.
            | The LeadInquiry remains available for later re-analysis
            | from the Admin UI.
            |
            */

            Log::error(
                'AI lead analysis failed for inquiry.',
                [
                    'inquiry_id' => $inquiry->id,
                    'email' => $inquiry->email,
                    'error' => $e->getMessage(),
                ]
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Success Response
        |--------------------------------------------------------------------------
        */

        return back()->with(
            'inquiry_success',
            'Inquiry submitted successfully!'
        );
    }

    /**
     * Display a single inquiry
     */
    public function show(Inquiry $inquiry)
    {
        $leadInquiry = \App\Models\LeadInquiry::where('email', $inquiry->email)
            ->where('message', $inquiry->message)
            ->latest()
            ->first();

        return view('admin.inquiries.show', compact(
            'inquiry',
            'leadInquiry'
        ));
    }

    /**
     * Show edit form
     */
    public function edit(Inquiry $inquiry)
    {
        return view('admin.inquiries.edit', compact('inquiry'));
    }

    /**
     * Update inquiry
     */
    public function update(Request $request, Inquiry $inquiry)
    {
        $request->validate([
            'status' => 'required|string'
        ]);

        $inquiry->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Inquiry updated successfully!');
    }

    /**
     * Delete inquiry
     */
    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();

        return redirect()
            ->route('admin.inquiries.index')
            ->with('success', 'Inquiry deleted successfully!');
    }

    /**
     * Submit a new inquiry from the public website.
     */
    public function submit(Request $request)
    {
        $validated = $request->validateWithBag('inquiry', [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'project_type' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'captcha' => ['required'],
        ]);

        // Existing inquiry
        $inquiry = Inquiry::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'project_type' => $validated['project_type'],
            'message' => $validated['message'],
            'status' => 'new',
        ]);

        // Create AI lead inquiry
        $leadInquiry = LeadInquiry::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'project_type' => $validated['project_type'],
            'message' => $validated['message'],
            'status' => 'new',
        ]);

        // AI analysis must never prevent inquiry submission
        try {

            app(AILeadService::class)->analyze($leadInquiry);

        } catch (\Throwable $e) {

            Log::error('AI lead analysis failed.', [
                'lead_inquiry_id' => $leadInquiry->id,
                'error' => $e->getMessage(),
            ]);
        }

        return redirect()
            ->back()
            ->with('inquiry_success', 'Thank you for your inquiry. Our team will get back to you shortly.');
    }

    /**
     * Re-run AI analysis for an inquiry.
     */
    public function reanalyze(Inquiry $inquiry)
    {
        $leadInquiry = LeadInquiry::where('email', $inquiry->email)
            ->where('message', $inquiry->message)
            ->latest()
            ->first();

        if (!$leadInquiry) {
            return back()->with('error', 'No AI lead record was found for this inquiry.');
        }

        try {

            app(AILeadService::class)->analyze($leadInquiry);

            return back()->with(
                'success',
                'AI lead analysis has been successfully refreshed.'
            );

        } catch (\Throwable $e) {

            Log::error('AI lead re-analysis failed.', [
                'inquiry_id' => $inquiry->id,
                'lead_inquiry_id' => $leadInquiry->id,
                'error' => $e->getMessage(),
            ]);

            return back()->with(
                'error',
                'AI re-analysis failed. Please try again.'
            );
        }
    }

    /**
     * Update lead status.
     */
    public function updateLeadStatus(Request $request, Inquiry $inquiry)
    {
        $validated = $request->validate([
            'lead_status' => [
                'required',
                'in:New,Contacted,Qualified,Converted,Lost',
            ],
        ]);

        $leadInquiry = LeadInquiry::where('email', $inquiry->email)
            ->where('message', $inquiry->message)
            ->latest()
            ->first();

        if (!$leadInquiry) {
            return back()->with(
                'error',
                'No AI lead record was found for this inquiry.'
            );
        }

        $leadInquiry->update([
            'lead_status' => $validated['lead_status'],
        ]);

        return back()->with(
            'success',
            'Lead status updated successfully.'
        );
    }


    /**
     * Update lead follow-up information.
     */
    public function updateFollowUp(Request $request, Inquiry $inquiry)
    {
        $validated = $request->validate([
            'follow_up_date' => [
                'nullable',
                'date',
            ],

            'follow_up_notes' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ]);

        $leadInquiry = LeadInquiry::where('email', $inquiry->email)
            ->where('message', $inquiry->message)
            ->latest()
            ->first();

        if (!$leadInquiry) {
            return back()->with(
                'error',
                'No AI lead record was found for this inquiry.'
            );
        }

        $leadInquiry->update([
            'follow_up_date' => $validated['follow_up_date'] ?? null,
            'follow_up_notes' => $validated['follow_up_notes'] ?? null,
        ]);

        return back()->with(
            'success',
            'Follow-up details updated successfully.'
        );
    }


    /**
     * Mark lead as contacted.
     */
    public function markContacted(Inquiry $inquiry)
    {
        $leadInquiry = LeadInquiry::where('email', $inquiry->email)
            ->where('message', $inquiry->message)
            ->latest()
            ->first();

        if (!$leadInquiry) {
            return back()->with(
                'error',
                'No AI lead record was found for this inquiry.'
            );
        }

        $leadInquiry->update([
            'lead_status' => 'Contacted',
            'last_contacted_at' => now(),
        ]);

        return back()->with(
            'success',
            'Lead marked as contacted.'
        );
    }

    public function reanalyzeLead(LeadInquiry $leadInquiry)
    {
        try {
            app(AILeadService::class)->analyze($leadInquiry);

            return back()->with(
                'success',
                'Lead successfully re-analyzed by AI.'
            );

        } catch (\Throwable $e) {

            Log::error('AI lead re-analysis failed.', [
                'lead_inquiry_id' => $leadInquiry->id,
                'error' => $e->getMessage(),
            ]);

            return back()->with(
                'error',
                'AI re-analysis failed. Please check Ollama/Qwen.'
            );
        }
    }
}
