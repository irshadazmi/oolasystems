<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    /**
     * Visitor Analytics
     */
    public function index(Request $request)
    {
        $query = Visitor::query();

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where('ip', 'like', "%{$search}%")
                  ->orWhere('page', 'like', "%{$search}%")
                  ->orWhere('user_agent', 'like', "%{$search}%");

            });

        }

        $visitors = $query
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $totalVisitors = Visitor::count();

        $uniqueVisitors = Visitor::distinct('ip')->count('ip');

        $todayVisitors = Visitor::whereDate('created_at', today())->count();

        $totalPages = Visitor::distinct('page')->count('page');

        return view('admin.visitors.index', compact(
            'visitors',
            'totalVisitors',
            'uniqueVisitors',
            'todayVisitors',
            'totalPages'
        ));
    }

    /**
     * Display visitor details
     */
    public function show(Visitor $visitor)
    {
        return view('admin.visitors.show', compact('visitor'));
    }

    /**
     * Delete visitor record (optional)
     */
    public function destroy(Visitor $visitor)
    {
        $visitor->delete();

        return redirect()
            ->route('admin.visitors.index')
            ->with('success', 'Visitor record deleted successfully.');
    }

    /**
     * Delete old visitor logs
     */
    public function clearOld(Request $request)
    {
        $days = (int) $request->input('days', 90);

        Visitor::where('created_at', '<', now()->subDays($days))->delete();

        return redirect()
            ->route('admin.visitors.index')
            ->with('success', "Visitor records older than {$days} days were deleted successfully.");
    }
}
