<?php

namespace App\Http\Controllers;

use App\Jobs\AnalyzeInquiryJob;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inquiry::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('project_type', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('temperature')) {
            $query->where('lead_temperature', $request->temperature);
        }

        if ($request->filled('min_score')) {
            $query->where('lead_score', '>=', (int) $request->min_score);
        }

        if ($request->filled('max_score')) {
            $query->where('lead_score', '<=', (int) $request->max_score);
        }

        if ($request->filled('ai_status')) {
            match ($request->ai_status) {
                'Analyzed' => $query->where('ai_status', 'Completed'),
                'Pending' => $query->whereIn('ai_status', ['Pending', 'Processing']),
                'Failed' => $query->where('ai_status', 'Failed'),
                default => null,
            };
        }

        match ($request->input('lead_sort', 'latest')) {
            'highest' => $query
                ->orderByDesc('lead_score')
                ->latest('created_at'),

            'lowest' => $query
                ->orderBy('lead_score')
                ->latest('created_at'),

            default => $query->latest('created_at'),
        };

        $inquiries = $query
            ->paginate(10)
            ->withQueryString();

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
                    ['captcha' => 'Incorrect captcha answer'],
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
            'status' => 'New',
            'lead_status' => 'New',
            'ai_status' => 'Pending',
        ]);

        AnalyzeInquiryJob::dispatch($inquiry->id);

        return back()->with(
            'inquiry_success',
            'Inquiry submitted successfully!'
        );
    }

    public function show(Inquiry $inquiry)
    {
        return view('admin.inquiries.show', [
            'inquiry' => $inquiry,
        ]);
    }

    public function edit(Inquiry $inquiry)
    {
        return view('admin.inquiries.edit', [
            'inquiry' => $inquiry,
        ]);
    }

    public function update(Request $request, Inquiry $inquiry)
    {
        $validated = $request->validate([
            'status' => 'required|string',
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

    public function reanalyze(Inquiry $inquiry)
    {
        $inquiry->update([
            'ai_status' => 'Pending',
        ]);

        AnalyzeInquiryJob::dispatch($inquiry->id);

        return back()->with(
            'success',
            'AI lead analysis has been queued for processing.'
        );
    }

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

        $inquiry->update([
            'lead_status' => $validated['lead_status'],
        ]);

        return back()->with(
            'success',
            'Lead status updated successfully.'
        );
    }

    public function updateFollowUp(
        Request $request,
        Inquiry $inquiry
    ) {
        $validated = $request->validate([
            'follow_up_date' => 'nullable|date',
            'follow_up_notes' => 'nullable|string|max:5000',
        ]);

        $inquiry->update([
            'follow_up_date' => $validated['follow_up_date'] ?? null,
            'follow_up_notes' => $validated['follow_up_notes'] ?? null,
        ]);

        return back()->with(
            'success',
            'Follow-up details updated successfully.'
        );
    }

    public function markContacted(Inquiry $inquiry)
    {
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
