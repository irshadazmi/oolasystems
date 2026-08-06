<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display all contacts (Admin use)
     */
    public function index(Request $request)
    {
        $query = Contact::query();

        // Search
        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%");

            });

        }

        // Status Filter
        if ($request->filled('status')) {

            $query->where('status', $request->status);

        }

        $contacts = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.contacts.index', [

            'contacts' => $contacts,

            'totalContacts' => Contact::count(),

            'newContacts' => Contact::where('status', 'New')->count(),

            'readContacts' => Contact::where('status', 'Read')->count(),

            'closedContacts' => Contact::where('status', 'Closed')->count(),

        ]);
    }

    /**
     * Store new contact (from form)
     */
    public function store(Request $request)
    {
        // ✅ Validation
        $validated = validator(
            $request->all(),
            [
                'first_name' => 'required|string|max:100',
                'last_name'  => 'nullable|string|max:100',
                'email'      => 'required|email|max:150',
                'company'    => 'nullable|string|max:150',
                'subject'    => 'nullable|string|max:200',
                'message'    => 'required|string|min:10',
            ]
        )->validate();

        if ((int) $request->captcha !== (int) session('captcha_contact_answer')) {
            return back()
                ->withErrors(['captcha' => 'Incorrect captcha answer'], 'contact')
                ->withInput();
        }

        session()->forget([
            'captcha_contact_answer',
            'captcha_contact_question',
        ]);

        // ✅ Save
        $validated['status'] = 'New';
        Contact::create($validated);

        // ✅ Redirect
        return back()->with('contact_success', 'Message sent successfully!');
    }

    /**
     * Show single contact (Admin)
     */
    public function show(Contact $contact)
    {
        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Update contact (e.g. mark as responded)
     */
    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $contact->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Contact updated successfully!');
    }

    /**
     * Delete contact
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return back()->with('success', 'Contact deleted successfully!');
    }
}
