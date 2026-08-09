@extends('layouts.app')

@section('title', 'Admin Dashboard | Oola Systems')

@section('content')

<section class="section-block">

    {{-- ====================================================== --}}
    {{-- Header --}}
    {{-- ====================================================== --}}

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-5">

        <div>

            <div class="eyebrow">
                Administration
            </div>

            <h1 class="page-title text-start mb-2">
                Admin Dashboard
            </h1>

            <p class="page-subtitle text-start ms-0">
                Welcome back,
                <strong>{{ Auth::user()->name }}</strong>.
                Manage contacts, careers, visitors, inquiries, leads and users from one place.
            </p>

        </div>

        <form method="POST" action="{{ route('admin.logout') }}">

            @csrf

            <button
                type="submit"
                class="btn btn-outline-light btn-lg">

                <i class="bi bi-box-arrow-right"></i>
                Logout

            </button>

        </form>

    </div>


    {{-- ====================================================== --}}
    {{-- Overall Statistics --}}
    {{-- ====================================================== --}}

    <div class="row g-1 mb-5">

        {{-- Contacts --}}

        <div class="col-lg-2 col-md-6">

            <div class="feature-card text-center h-100">

                <i class="bi bi-envelope-paper fs-1 text-primary"></i>

                <h2 class="mt-3">
                    {{ $contactsCount }}
                </h2>

                <h5>Contacts</h5>

                <p class="text-secondary">
                    Customer Enquiries
                </p>

                <a
                    href="{{ route('admin.contacts.index') }}"
                    class="btn btn-outline-light btn-lg justify-content-center">

                    View All

                </a>

            </div>

        </div>


        {{-- Careers --}}

        <div class="col-lg-2 col-md-6">

            <div class="feature-card text-center h-100">

                <i class="bi bi-person-workspace fs-1 text-success"></i>

                <h2 class="mt-3">
                    {{ $careersCount }}
                </h2>

                <h5>Careers</h5>

                <p class="text-secondary">
                    Job Opportunities
                </p>

                <a
                    href="{{ route('admin.careers.index') }}"
                    class="btn btn-outline-light btn-lg justify-content-center">

                    View All

                </a>

            </div>

        </div>


        {{-- Visitors --}}

        <div class="col-lg-2 col-md-6">

            <div class="feature-card text-center h-100">

                <i class="bi bi-people fs-1 text-info"></i>

                <h2 class="mt-3">
                    {{ $visitorsCount }}
                </h2>

                <h5>Visitors</h5>

                <p class="text-secondary">
                    Website Visitors
                </p>

                <a
                    href="{{ route('admin.visitors.index') }}"
                    class="btn btn-outline-light btn-lg justify-content-center">

                    View All

                </a>

            </div>

        </div>


        {{-- Users --}}

        <div class="col-lg-2 col-md-6">

            <div class="feature-card text-center h-100">

                <i class="bi bi-person-badge fs-1 text-warning"></i>

                <h2 class="mt-3">
                    {{ $usersCount }}
                </h2>

                <h5>Users</h5>

                <p class="text-secondary">
                    System Users
                </p>

                <a
                    href="{{ route('admin.users.index') }}"
                    class="btn btn-outline-light btn-lg justify-content-center">

                    View All

                </a>

            </div>

        </div>


        {{-- Inquiries --}}

        <div class="col-lg-2 col-md-6">

            <div class="feature-card text-center h-100">

                <i class="bi bi-briefcase fs-1 text-info"></i>

                <h2 class="mt-3">
                    {{ $inquiriesCount }}
                </h2>

                <h5>Inquiries</h5>

                <p class="text-secondary">
                    Business Enquiries
                </p>

                <a
                    href="{{ route('admin.inquiries.index') }}"
                    class="btn btn-outline-light btn-lg justify-content-center">

                    View All

                </a>

            </div>

        </div>


        {{-- Leads --}}

        <div class="col-lg-2 col-md-6">

            <div class="feature-card text-center h-100">

                <i class="bi bi-person-lines-fill fs-1 text-danger"></i>

                <h2 class="mt-3">
                    {{ $totalLeads ?? 0 }}
                </h2>

                <h5>Leads</h5>

                <p class="text-secondary">
                    AI Qualified Leads
                </p>

                <a
                    href="{{ route('admin.inquiries.index') }}"
                    class="btn btn-outline-light btn-lg justify-content-center">

                    Manage

                </a>

            </div>

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- Lead Management & AI Analytics --}}
    {{-- ====================================================== --}}

    <div class="feature-card mb-5">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

            <div>

                <div class="eyebrow">
                    AI Lead Management
                </div>

                <h3 class="mb-1">
                    Lead Overview
                </h3>

                <p class="text-secondary mb-0">
                    Monitor lead quality, AI qualification and conversion readiness.
                </p>

            </div>

            <a
                href="{{ route('admin.inquiries.index') }}"
                class="btn btn-outline-light">

                <i class="bi bi-kanban me-1"></i>
                Manage Leads

            </a>

        </div>


        <div class="row g-3">

            {{-- Hot Leads --}}

            <div class="col-lg-3 col-md-6">

                <div class="border rounded p-3 h-100">

                    <div class="d-flex justify-content-between align-items-center">

                        <span class="text-secondary">
                            Hot Leads
                        </span>

                        <i class="bi bi-fire text-danger fs-4"></i>

                    </div>

                    <h2 class="mt-2 mb-0">
                        {{ $hotLeads ?? 0 }}
                    </h2>

                    <small class="text-secondary">
                        High-priority prospects
                    </small>

                </div>

            </div>


            {{-- Warm Leads --}}

            <div class="col-lg-3 col-md-6">

                <div class="border rounded p-3 h-100">

                    <div class="d-flex justify-content-between align-items-center">

                        <span class="text-secondary">
                            Warm Leads
                        </span>

                        <i class="bi bi-thermometer-half text-warning fs-4"></i>

                    </div>

                    <h2 class="mt-2 mb-0">
                        {{ $warmLeads ?? 0 }}
                    </h2>

                    <small class="text-secondary">
                        Prospects requiring follow-up
                    </small>

                </div>

            </div>


            {{-- Qualified Leads --}}

            <div class="col-lg-3 col-md-6">

                <div class="border rounded p-3 h-100">

                    <div class="d-flex justify-content-between align-items-center">

                        <span class="text-secondary">
                            Qualified Leads
                        </span>

                        <i class="bi bi-patch-check text-success fs-4"></i>

                    </div>

                    <h2 class="mt-2 mb-0">
                        {{ $qualifiedLeads ?? 0 }}
                    </h2>

                    <small class="text-secondary">
                        Sales-ready prospects
                    </small>

                </div>

            </div>


            {{-- AI Analyzed --}}

            <div class="col-lg-3 col-md-6">

                <div class="border rounded p-3 h-100">

                    <div class="d-flex justify-content-between align-items-center">

                        <span class="text-secondary">
                            AI Analyzed
                        </span>

                        <i class="bi bi-robot text-primary fs-4"></i>

                    </div>

                    <h2 class="mt-2 mb-0">
                        {{ $analyzedLeads ?? 0 }}
                    </h2>

                    <small class="text-secondary">
                        Leads processed by AI
                    </small>

                </div>

            </div>

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- AI Analytics --}}
    {{-- ====================================================== --}}

    <div class="feature-card mb-5">

        <div class="mb-4">

            <div class="eyebrow">
                AI Analytics
            </div>

            <h3 class="mb-1">
                Lead Performance
            </h3>

            <p class="text-secondary mb-0">
                AI-driven indicators for lead quality and sales performance.
            </p>

        </div>


        <div class="row g-3">

            {{-- Average Score --}}

            <div class="col-lg-3 col-md-6">

                <div class="border rounded p-3 h-100">

                    <span class="text-secondary">
                        Average Lead Score
                    </span>

                    <h2 class="mt-2 mb-0">
                        {{ $averageLeadScore ?? 0 }}
                        <small class="fs-6 text-secondary">/100</small>
                    </h2>

                </div>

            </div>


            {{-- AI Analyzed % --}}

            <div class="col-lg-3 col-md-6">

                <div class="border rounded p-3 h-100">

                    <span class="text-secondary">
                        AI Analyzed
                    </span>

                    <h2 class="mt-2 mb-0">
                        {{ $aiAnalyzedPercentage ?? 0 }}%
                    </h2>

                </div>

            </div>


            {{-- Hot Lead % --}}

            <div class="col-lg-3 col-md-6">

                <div class="border rounded p-3 h-100">

                    <span class="text-secondary">
                        Hot Lead Rate
                    </span>

                    <h2 class="mt-2 mb-0">
                        {{ $hotLeadPercentage ?? 0 }}%
                    </h2>

                </div>

            </div>


            {{-- Qualified % --}}

            <div class="col-lg-3 col-md-6">

                <div class="border rounded p-3 h-100">

                    <span class="text-secondary">
                        Qualified Rate
                    </span>

                    <h2 class="mt-2 mb-0">
                        {{ $qualifiedLeadPercentage ?? 0 }}%
                    </h2>

                </div>

            </div>


            {{-- Conversion Rate --}}

            <div class="col-lg-3 col-md-6">

                <div class="border rounded p-3 h-100">

                    <span class="text-secondary">
                        Conversion Rate
                    </span>

                    <h2 class="mt-2 mb-0">
                        {{ $conversionRate ?? 0 }}%
                    </h2>

                </div>

            </div>


            {{-- Pending AI --}}

            <div class="col-lg-3 col-md-6">

                <div class="border rounded p-3 h-100">

                    <span class="text-secondary">
                        AI Pending
                    </span>

                    <h2 class="mt-2 mb-0">
                        {{ $pendingLeads ?? 0 }}
                    </h2>

                </div>

            </div>


            {{-- Upcoming Follow-ups --}}

            <div class="col-lg-3 col-md-6">

                <div class="border rounded p-3 h-100">

                    <span class="text-secondary">
                        Upcoming Follow-ups
                    </span>

                    <h2 class="mt-2 mb-0">
                        {{ $upcomingFollowUps ?? 0 }}
                    </h2>

                </div>

            </div>


            {{-- Overdue Follow-ups --}}

            <div class="col-lg-3 col-md-6">

                <div class="border rounded p-3 h-100">

                    <span class="text-secondary">
                        Overdue Follow-ups
                    </span>

                    <h2 class="mt-2 mb-0">
                        {{ $overdueFollowUps ?? 0 }}
                    </h2>

                </div>

            </div>

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- Lead Pipeline --}}
    {{-- ====================================================== --}}

    <div class="feature-card mb-5">

        <div class="mb-4">

            <h3 class="mb-1">
                Lead Pipeline
            </h3>

            <p class="text-secondary mb-0">
                Current distribution of leads across the sales pipeline.
            </p>

        </div>


        <div class="row g-3">

            <div class="col-lg col-md-4 col-6">
                <div class="text-center">
                    <div class="fs-2 text-primary">
                        {{ $newLeads ?? 0 }}
                    </div>
                    <small class="text-secondary">
                        New
                    </small>
                </div>
            </div>


            <div class="col-lg col-md-4 col-6">
                <div class="text-center">
                    <div class="fs-2 text-info">
                        {{ $contactedLeads ?? 0 }}
                    </div>
                    <small class="text-secondary">
                        Contacted
                    </small>
                </div>
            </div>


            <div class="col-lg col-md-4 col-6">
                <div class="text-center">
                    <div class="fs-2 text-success">
                        {{ $qualifiedLeads ?? 0 }}
                    </div>
                    <small class="text-secondary">
                        Qualified
                    </small>
                </div>
            </div>


            <div class="col-lg col-md-4 col-6">
                <div class="text-center">
                    <div class="fs-2 text-success">
                        {{ $convertedLeads ?? 0 }}
                    </div>
                    <small class="text-secondary">
                        Converted
                    </small>
                </div>
            </div>


            <div class="col-lg col-md-4 col-6">
                <div class="text-center">
                    <div class="fs-2 text-danger">
                        {{ $lostLeads ?? 0 }}
                    </div>
                    <small class="text-secondary">
                        Lost
                    </small>
                </div>
            </div>


            <div class="col-lg col-md-4 col-6">
                <div class="text-center">
                    <div class="fs-2 text-warning">
                        {{ $upcomingFollowUps ?? 0 }}
                    </div>
                    <small class="text-secondary">
                        Follow-ups
                    </small>
                </div>
            </div>

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- Priority Leads --}}
    {{-- ====================================================== --}}

    <div class="feature-card mb-5">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

            <div>

                <div class="eyebrow">
                    AI Prioritization
                </div>

                <h3 class="mb-1">
                    Priority Leads
                </h3>

                <p class="text-secondary mb-0">
                    Highest-scoring leads requiring attention.
                </p>

            </div>

            <a
                href="{{ route('admin.inquiries.index') }}"
                class="btn btn-outline-light">

                View All Leads

            </a>

        </div>


        @if(isset($priorityLeads) && $priorityLeads->count())

            <div class="table-responsive">

                <table class="table table-dark table-hover align-middle mb-0">

                    <thead>

                        <tr>

                            <th>Lead</th>
                            <th>Service</th>
                            <th>Score</th>
                            <th>Temperature</th>
                            <th>Status</th>
                            <th>Follow-up</th>
                            <th></th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($priorityLeads as $lead)

                            <tr>

                                <td>

                                    <div class="fw-semibold">
                                        {{ $lead->name }}
                                    </div>

                                    <small class="text-secondary">
                                        {{ $lead->email }}
                                    </small>

                                </td>


                                <td>

                                    {{ $lead->service_interest ?: $lead->project_type }}

                                </td>


                                <td>

                                    <span class="badge bg-primary">
                                        {{ $lead->lead_score ?? 0 }}
                                    </span>

                                </td>


                                <td>

                                    @if($lead->lead_temperature === 'HOT')

                                        <span class="badge bg-danger">
                                            HOT
                                        </span>

                                    @elseif($lead->lead_temperature === 'WARM')

                                        <span class="badge bg-warning text-dark">
                                            WARM
                                        </span>

                                    @elseif($lead->lead_temperature === 'QUALIFIED')

                                        <span class="badge bg-success">
                                            QUALIFIED
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            {{ $lead->lead_temperature ?: '—' }}
                                        </span>

                                    @endif

                                </td>


                                <td>

                                    <span class="badge bg-secondary">

                                        {{ $lead->lead_status ?: 'New' }}

                                    </span>

                                </td>


                                <td>

                                    @if($lead->follow_up_date)

                                        {{ $lead->follow_up_date->format('d M Y') }}

                                    @else

                                        <span class="text-secondary">
                                            —
                                        </span>

                                    @endif

                                </td>


                                <td>

                                    <a
                                        href="{{ route('admin.inquiries.show', $lead->id) }}"
                                        class="btn btn-sm btn-outline-light"
                                        title="View Lead">

                                        <i class="bi bi-eye"></i>

                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="text-center py-4">

                <i class="bi bi-person-lines-fill display-6 text-secondary"></i>

                <p class="text-secondary mt-3 mb-0">
                    No prioritized leads available yet.
                </p>

            </div>

        @endif

    </div>


    {{-- ====================================================== --}}
    {{-- Follow-up Alerts --}}
    {{-- ====================================================== --}}

    @if(($overdueFollowUps ?? 0) > 0)

        <div class="feature-card mb-5 border border-danger">

            <div class="d-flex align-items-center gap-3">

                <i class="bi bi-exclamation-triangle-fill text-danger fs-2"></i>

                <div>

                    <h5 class="mb-1">
                        Follow-up Attention Required
                    </h5>

                    <p class="text-secondary mb-0">

                        {{ $overdueFollowUps }}
                        lead{{ $overdueFollowUps == 1 ? '' : 's' }}
                        {{ $overdueFollowUps == 1 ? 'has' : 'have' }}
                        overdue follow-up{{ $overdueFollowUps == 1 ? '' : 's' }}.

                    </p>

                </div>

                <div class="ms-auto">

                    <a
                        href="{{ route('admin.inquiries.index') }}"
                        class="btn btn-outline-danger">

                        Review Leads

                    </a>

                </div>

            </div>

        </div>

    @endif


    {{-- ====================================================== --}}
    {{-- Quick Actions --}}
    {{-- ====================================================== --}}

    <div class="feature-card">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

            <div>

                <h3 class="mb-1">
                    Quick Actions
                </h3>

                <p class="text-secondary mb-0">
                    Frequently used administration tasks.
                </p>

            </div>

        </div>


        <div class="row g-1">

            <div class="col-lg-2 col-md-6">

                <a
                    href="{{ route('admin.contacts.index') }}"
                    class="btn btn-primary w-100">

                    <i class="bi bi-envelope-paper"></i>
                    Manage Contact

                </a>

            </div>


            <div class="col-lg-2 col-md-6">

                <a
                    href="{{ route('admin.careers.index') }}"
                    class="btn btn-primary w-100">

                    <i class="bi bi-person-workspace"></i>
                    Manage Career

                </a>

            </div>


            <div class="col-lg-2 col-md-6">

                <a
                    href="{{ route('admin.inquiries.index') }}"
                    class="btn btn-primary w-100">

                    <i class="bi bi-person-lines-fill"></i>
                    Manage Leads

                </a>

            </div>


            <div class="col-lg-2 col-md-6">

                <a
                    href="{{ route('admin.visitors.index') }}"
                    class="btn btn-primary w-100">

                    <i class="bi bi-people"></i>
                    Visitor Analytics

                </a>

            </div>


            <div class="col-lg-2 col-md-6">

                <a
                    href="{{ route('admin.users.index') }}"
                    class="btn btn-primary w-100">

                    <i class="bi bi-person-gear"></i>
                    Manage User

                </a>

            </div>


            <div class="col-lg-2 col-md-6">

                <a
                    href="{{ route('admin.inquiries.index') }}"
                    class="btn btn-primary w-100">

                    <i class="bi bi-chat-square-text"></i>
                    Manage Inquiry

                </a>

            </div>

        </div>

    </div>

</section>

@endsection
