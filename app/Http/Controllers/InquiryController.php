<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    /**
     * Display all inquiries (Admin use)
     */
    public function index()
    {
        $inquiries = Inquiry::latest()->paginate(10);
        return view('admin.visitors.index', compact('inquiries'));
    }

    /**
     * Store new inquiry (from form)
     */
    public function store(Request $request)
    {
        // ✅ Validation
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'project_type' => 'required|string|max:100',
        ], [], [], 'inquiry');

        if ((int)$request->captcha !== session('captcha_inquiry_answer')) {
            return back()
                ->withErrors(['captcha' => 'Incorrect captcha answer'], 'inquiry')
                ->withInput();
        }

        session()->forget([
            'captcha_inquiry_answer',
            'captcha_inquiry_question'
        ]);

        // ✅ Save
        Inquiry::create($validated);

        // ✅ Redirect
        return back()->with('inquiry_success', 'Inquiry submitted successfully!');
    }

    /**
     * Show single inquiry (Admin)
     */
    public function show(Inquiry $inquiry)
    {
        return view('admin.visitors.show', compact('inquiry'));
    }

    /**
     * Update inquiry (e.g. mark as responded)
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

        return back()->with('success', 'Inquiry deleted successfully!');
    }
}
