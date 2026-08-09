<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Career;
use App\Models\Inquiry;
use App\Models\User;
use App\Models\Visitor;
use App\Models\LeadInquiry;

class AdminController extends Controller
{
    /**
     * Admin Dashboard
     */
    public function dashboard()
    {
        // ======================================================
        // Existing Website Statistics
        // ======================================================

        $contactsCount = Contact::count();
        $careersCount = Career::count();
        $visitorsCount = Visitor::count();
        $usersCount = User::count();
        $inquiriesCount = Inquiry::count();


        // ======================================================
        // Lead Management Statistics
        // ======================================================

        $totalLeads = LeadInquiry::count();

        $newLeads = LeadInquiry::where(
            'lead_status',
            'New'
        )->count();

        $contactedLeads = LeadInquiry::where(
            'lead_status',
            'Contacted'
        )->count();

        $qualifiedLeads = LeadInquiry::where(
            'lead_status',
            'Qualified'
        )->count();

        $convertedLeads = LeadInquiry::where(
            'lead_status',
            'Converted'
        )->count();

        $lostLeads = LeadInquiry::where(
            'lead_status',
            'Lost'
        )->count();


        // ======================================================
        // Lead Temperature
        // ======================================================

        $hotLeads = LeadInquiry::where(
            'lead_temperature',
            'HOT'
        )->count();

        $warmLeads = LeadInquiry::where(
            'lead_temperature',
            'WARM'
        )->count();

        $qualifiedTemperatureLeads = LeadInquiry::where(
            'lead_temperature',
            'QUALIFIED'
        )->count();


        // ======================================================
        // AI Processing
        // ======================================================

        $analyzedLeads = LeadInquiry::whereNotNull(
            'ai_processed_at'
        )->count();

        $pendingLeads = LeadInquiry::whereNull(
            'ai_processed_at'
        )->count();


        // ======================================================
        // AI Analytics
        // ======================================================

        $averageLeadScore = LeadInquiry::whereNotNull(
            'lead_score'
        )->avg('lead_score');

        $averageLeadScore = $averageLeadScore !== null
            ? round($averageLeadScore)
            : 0;

        $aiAnalyzedPercentage = $totalLeads > 0
            ? round(($analyzedLeads / $totalLeads) * 100)
            : 0;

        $hotLeadPercentage = $totalLeads > 0
            ? round(($hotLeads / $totalLeads) * 100)
            : 0;

        $qualifiedLeadPercentage = $totalLeads > 0
            ? round(($qualifiedLeads / $totalLeads) * 100)
            : 0;

        $conversionRate = $totalLeads > 0
            ? round(($convertedLeads / $totalLeads) * 100)
            : 0;


        // ======================================================
        // Follow-up
        // ======================================================

        $upcomingFollowUps = LeadInquiry::whereNotNull(
            'follow_up_date'
        )
            ->whereDate(
                'follow_up_date',
                '>=',
                today()
            )
            ->count();

        $overdueFollowUps = LeadInquiry::whereNotNull(
            'follow_up_date'
        )
            ->whereDate(
                'follow_up_date',
                '<',
                today()
            )
            ->count();


        // ======================================================
        // Recent / Priority Leads
        // ======================================================

        $priorityLeads = LeadInquiry::whereNotNull(
            'lead_score'
        )
            ->orderByDesc('lead_score')
            ->latest()
            ->take(5)
            ->get();


        // ======================================================
        // Dashboard
        // ======================================================

        return view('admin.dashboard', compact(

            // Existing statistics
            'contactsCount',
            'careersCount',
            'visitorsCount',
            'usersCount',
            'inquiriesCount',

            // Lead management
            'totalLeads',
            'newLeads',
            'contactedLeads',
            'qualifiedLeads',
            'convertedLeads',
            'lostLeads',

            // Lead temperature
            'hotLeads',
            'warmLeads',
            'qualifiedTemperatureLeads',

            // AI
            'analyzedLeads',
            'pendingLeads',
            'averageLeadScore',
            'aiAnalyzedPercentage',
            'hotLeadPercentage',
            'qualifiedLeadPercentage',
            'conversionRate',

            // Follow-up
            'upcomingFollowUps',
            'overdueFollowUps',

            // Priority leads
            'priorityLeads'
        ));
    }
}
