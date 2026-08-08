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

        $inquiries = $query->latest()->paginate(10);

        return view('admin.inquiries.index', compact('inquiries'));
    }

    /**
     * Store new inquiry (Public)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'project_type' => 'required|string|max:100',
            'message' => 'required|string|min:10',
        ], [], [], 'inquiry');

        if ((int) $request->captcha !== (int) session('captcha_inquiry_answer')) {
            return back()
                ->withErrors(['captcha' => 'Incorrect captcha answer'], 'inquiry')
                ->withInput();
        }

        session()->forget([
            'captcha_inquiry_answer',
            'captcha_inquiry_question'
        ]);

        $validated['status'] = 'New';

        Inquiry::create($validated);

        return back()->with('inquiry_success', 'Inquiry submitted successfully!');
    }

    /**
     * Display a single inquiry
     */
    public function show(Inquiry $inquiry)
    {
        if ($inquiry->status === 'New') {
            $inquiry->update([
                'status' => 'Read'
            ]);
        }

        return view('admin.inquiries.show', compact('inquiry'));
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
}
