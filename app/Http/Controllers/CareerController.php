<?php

namespace App\Http\Controllers;

use App\Models\Career;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    /**
     * Display open career opportunities publicly.
     */
    public function publicIndex()
    {
        $careers = Career::where('status', 'Open')
            ->latest()
            ->get();

        return view('pages.careers', compact('careers'));
    }

    /**
     * Display all career positions.
     */
    public function index(Request $request)
    {
        $query = Career::query();

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");

            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('employment_type')) {
            $query->where('employment_type', $request->employment_type);
        }

        $careers = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.careers.index', compact('careers'));
    }

    /**
     * Show form for creating a new career position.
     */
    public function create()
    {
        return view('admin.careers.create');
    }

    /**
     * Store a new career position.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'department' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:150',
            'employment_type' => 'required|string|max:50',
            'experience' => 'nullable|string|max:100',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'status' => 'required|in:Open,Closed,Draft,On Hold',
        ]);

        Career::create($validated);

        return redirect()
            ->route('admin.careers.index')
            ->with('success', 'Career position created successfully.');
    }

    /**
     * Display career details.
     */
    public function show(Career $career)
    {
        return view('admin.careers.show', compact('career'));
    }

    /**
     * Show edit form.
     */
    public function edit(Career $career)
    {
        return view('admin.careers.edit', compact('career'));
    }

    /**
     * Update career position.
     */
    public function update(Request $request, Career $career)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'department' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:150',
            'employment_type' => 'required|string|max:50',
            'experience' => 'nullable|string|max:100',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'status' => 'required|in:Open,Closed,Draft,On Hold',
        ]);

        $career->update($validated);

        return redirect()
            ->route('admin.careers.index')
            ->with('success', 'Career position updated successfully.');
    }

    /**
     * Delete career position.
     */
    public function destroy(Career $career)
    {
        $career->delete();

        return redirect()
            ->route('admin.careers.index')
            ->with('success', 'Career position deleted successfully.');
    }
}
