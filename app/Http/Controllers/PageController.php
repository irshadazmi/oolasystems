<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Inquiry;
use App\Models\User;
use App\Models\Visitor;
use App\Models\Career;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function services()
    {
        return view('pages.services');
    }

    public function portfolio()
    {
        return view('pages.portfolio');
    }

    public function industries()
    {
        return view('pages.industries');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function sitemap()
    {
        return view('pages.sitemap');
    }

    public function careers()
    {
        return view('pages.careers');
    }

    public function tutorial()
    {
        return view('tutorial.index');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function admin()
    {
        /*
        |--------------------------------------------------------------------------
        | Basic Statistics
        |--------------------------------------------------------------------------
        */

        $contactsCount = Contact::count();

        $careersCount = Career::count();

        $visitorsCount = Visitor::count();

        $usersCount = User::count();

        $inquiriesCount = Inquiry::count();


        /*
        |--------------------------------------------------------------------------
        | AI Analysis
        |--------------------------------------------------------------------------
        */

        $analyzedLeads = Inquiry::where(
            'ai_status',
            'Completed'
        )->count();

        $pendingLeads = Inquiry::whereIn(
            'ai_status',
            ['Pending', 'Processing']
        )->count();

        $failedLeads = Inquiry::where(
            'ai_status',
            'Failed'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | AI Qualified Leads
        |
        | A lead becomes an AI lead only after successful AI analysis.
        |--------------------------------------------------------------------------
        */

        $totalLeads = Inquiry::where(
            'ai_status',
            'Completed'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | AI Lead Temperature
        |
        | These values are based on AI analysis.
        |--------------------------------------------------------------------------
        */

        $hotLeads = Inquiry::where([
            ['ai_status', 'Completed'],
            ['lead_temperature', 'HOT'],
        ])->count();

        $warmLeads = Inquiry::where([
            ['ai_status', 'Completed'],
            ['lead_temperature', 'WARM'],
        ])->count();

        $aiQualifiedLeads = Inquiry::where([
            ['ai_status', 'Completed'],
            ['lead_temperature', 'QUALIFIED'],
        ])->count();


        /*
        |--------------------------------------------------------------------------
        | Lead Pipeline
        |
        | These values represent the sales/CRM pipeline status.
        |--------------------------------------------------------------------------
        */

        $newLeads = Inquiry::where(
            'lead_status',
            'New'
        )->count();

        $contactedLeads = Inquiry::where(
            'lead_status',
            'Contacted'
        )->count();

        $qualifiedPipelineLeads = Inquiry::where(
            'lead_status',
            'Qualified'
        )->count();

        $convertedLeads = Inquiry::where(
            'lead_status',
            'Converted'
        )->count();

        $lostLeads = Inquiry::where(
            'lead_status',
            'Lost'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Lead Score
        |--------------------------------------------------------------------------
        */

        $averageLeadScore = Inquiry::where(
            'ai_status',
            'Completed'
        )->avg('lead_score');

        $averageLeadScore = round(
            $averageLeadScore ?? 0
        );


        /*
        |--------------------------------------------------------------------------
        | AI Analysis Coverage
        |--------------------------------------------------------------------------
        */

        $aiAnalyzedPercentage = $inquiriesCount > 0
            ? round(
                ($analyzedLeads / $inquiriesCount) * 100
            )
            : 0;


        /*
        |--------------------------------------------------------------------------
        | Qualified Lead Rate
        |--------------------------------------------------------------------------
        */

        $qualifiedLeadPercentage = $analyzedLeads > 0
            ? round(
                ($aiQualifiedLeads / $analyzedLeads) * 100
            )
            : 0;


        /*
        |--------------------------------------------------------------------------
        | Conversion Rate
        |--------------------------------------------------------------------------
        */

        $conversionRate = $inquiriesCount > 0
            ? round(
                ($convertedLeads / $inquiriesCount) * 100
            )
            : 0;


        /*
        |--------------------------------------------------------------------------
        | Follow-up Statistics
        |--------------------------------------------------------------------------
        */

        $upcomingFollowUps = Inquiry::whereNotNull(
            'follow_up_date'
        )
            ->whereDate(
                'follow_up_date',
                '>=',
                today()
            )
            ->count();

        $overdueFollowUps = Inquiry::whereNotNull(
            'follow_up_date'
        )
            ->whereDate(
                'follow_up_date',
                '<',
                today()
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Priority Leads
        |--------------------------------------------------------------------------
        */

        $priorityLeads = Inquiry::where(
            'ai_status',
            'Completed'
        )
            ->whereNotNull('lead_score')
            ->orderByDesc('lead_score')
            ->limit(10)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        return view('admin.dashboard', [

            /*
            |--------------------------------------------------------------------------
            | Primary Statistics
            |--------------------------------------------------------------------------
            */

            'contactsCount' => $contactsCount,
            'careersCount' => $careersCount,
            'visitorsCount' => $visitorsCount,
            'usersCount' => $usersCount,
            'inquiriesCount' => $inquiriesCount,


            /*
            |--------------------------------------------------------------------------
            | AI Statistics
            |--------------------------------------------------------------------------
            */

            'totalLeads' => $totalLeads,
            'analyzedLeads' => $analyzedLeads,
            'pendingLeads' => $pendingLeads,
            'failedLeads' => $failedLeads,


            /*
            |--------------------------------------------------------------------------
            | AI Lead Temperature
            |--------------------------------------------------------------------------
            */

            'hotLeads' => $hotLeads,
            'warmLeads' => $warmLeads,
            'aiQualifiedLeads' => $aiQualifiedLeads,


            /*
            |--------------------------------------------------------------------------
            | Lead Pipeline
            |--------------------------------------------------------------------------
            */

            'newLeads' => $newLeads,
            'contactedLeads' => $contactedLeads,
            'qualifiedPipelineLeads' => $qualifiedPipelineLeads,
            'convertedLeads' => $convertedLeads,
            'lostLeads' => $lostLeads,


            /*
            |--------------------------------------------------------------------------
            | Performance
            |--------------------------------------------------------------------------
            */

            'averageLeadScore' => $averageLeadScore,
            'aiAnalyzedPercentage' => $aiAnalyzedPercentage,
            'qualifiedLeadPercentage' => $qualifiedLeadPercentage,
            'conversionRate' => $conversionRate,


            /*
            |--------------------------------------------------------------------------
            | Follow-ups
            |--------------------------------------------------------------------------
            */

            'upcomingFollowUps' => $upcomingFollowUps,
            'overdueFollowUps' => $overdueFollowUps,


            /*
            |--------------------------------------------------------------------------
            | Priority Leads
            |--------------------------------------------------------------------------
            */

            'priorityLeads' => $priorityLeads,
        ]);
    }
}
