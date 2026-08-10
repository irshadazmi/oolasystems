@extends('layouts.app')

@section('title', 'Admin Dashboard | Oola Systems')

@section('content')

<section class="section-block">

    {{-- ==========================================================
         HEADER
    =========================================================== --}}

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>

            <div class="eyebrow">
                Administration
            </div>

            <h1 class="page-title text-start mb-1">
                Admin Dashboard
            </h1>

            <p class="page-subtitle text-start ms-0 mb-0">
                Welcome back,
                <strong>{{ Auth::user()->name }}</strong>.
                Monitor website activity, inquiries and AI-qualified leads.
            </p>

        </div>

        <form method="POST" action="{{ route('admin.logout') }}">

            @csrf

            <button
                type="submit"
                class="btn btn-outline-light">

                <i class="bi bi-box-arrow-right me-1"></i>
                Logout

            </button>

        </form>

    </div>


    {{-- ==========================================================
         PRIMARY STATISTICS
    =========================================================== --}}

    <div class="row g-3 mb-4">

        {{-- Contacts --}}
        <div class="col-xl-2 col-lg-4 col-md-6">

            <div class="feature-card dashboard-kpi dashboard-kpi--primary h-100">

                <div class="dashboard-kpi__main">

                    <div>

                        <div class="dashboard-kpi__label">
                            Contacts
                        </div>

                        <div class="dashboard-kpi__value">
                            {{ $contactsCount ?? 0 }}
                        </div>

                        <div class="dashboard-kpi__description">
                            Customer enquiries
                        </div>

                    </div>

                    <div class="dashboard-kpi__icon dashboard-kpi__icon--primary">
                        <i class="bi bi-envelope-paper"></i>
                    </div>

                </div>

                <div class="dashboard-kpi__footer">

                    <a
                        href="{{ route('admin.contacts.index') }}"
                        class="dashboard-view-all">

                        View All
                        <i class="bi bi-arrow-right"></i>

                    </a>

                </div>

            </div>

        </div>


        {{-- Careers --}}
        <div class="col-xl-2 col-lg-4 col-md-6">

            <div class="feature-card dashboard-kpi dashboard-kpi--success h-100">

                <div class="dashboard-kpi__main">

                    <div>

                        <div class="dashboard-kpi__label">
                            Careers
                        </div>

                        <div class="dashboard-kpi__value">
                            {{ $careersCount ?? 0 }}
                        </div>

                        <div class="dashboard-kpi__description">
                            Job applications
                        </div>

                    </div>

                    <div class="dashboard-kpi__icon dashboard-kpi__icon--success">
                        <i class="bi bi-person-workspace"></i>
                    </div>

                </div>

                <div class="dashboard-kpi__footer">

                    <a
                        href="{{ route('admin.careers.index') }}"
                        class="dashboard-view-all">

                        View All
                        <i class="bi bi-arrow-right"></i>

                    </a>

                </div>

            </div>

        </div>


        {{-- Visitors --}}
        <div class="col-xl-2 col-lg-4 col-md-6">

            <div class="feature-card dashboard-kpi dashboard-kpi--info h-100">

                <div class="dashboard-kpi__main">

                    <div>

                        <div class="dashboard-kpi__label">
                            Visitors
                        </div>

                        <div class="dashboard-kpi__value">
                            {{ $visitorsCount ?? 0 }}
                        </div>

                        <div class="dashboard-kpi__description">
                            Website visitors
                        </div>

                    </div>

                    <div class="dashboard-kpi__icon dashboard-kpi__icon--info">
                        <i class="bi bi-people"></i>
                    </div>

                </div>

                <div class="dashboard-kpi__footer">

                    <a
                        href="{{ route('admin.visitors.index') }}"
                        class="dashboard-view-all">

                        View All
                        <i class="bi bi-arrow-right"></i>

                    </a>

                </div>

            </div>

        </div>


        {{-- Users --}}
        <div class="col-xl-2 col-lg-4 col-md-6">

            <div class="feature-card dashboard-kpi dashboard-kpi--warning h-100">

                <div class="dashboard-kpi__main">

                    <div>

                        <div class="dashboard-kpi__label">
                            Users
                        </div>

                        <div class="dashboard-kpi__value">
                            {{ $usersCount ?? 0 }}
                        </div>

                        <div class="dashboard-kpi__description">
                            System users
                        </div>

                    </div>

                    <div class="dashboard-kpi__icon dashboard-kpi__icon--warning">
                        <i class="bi bi-person-badge"></i>
                    </div>

                </div>

                <div class="dashboard-kpi__footer">

                    <a
                        href="{{ route('admin.users.index') }}"
                        class="dashboard-view-all">

                        View All
                        <i class="bi bi-arrow-right"></i>

                    </a>

                </div>

            </div>

        </div>


        {{-- Inquiries --}}
        <div class="col-xl-2 col-lg-4 col-md-6">

            <div class="feature-card dashboard-kpi dashboard-kpi--cyan h-100">

                <div class="dashboard-kpi__main">

                    <div>

                        <div class="dashboard-kpi__label">
                            Inquiries
                        </div>

                        <div class="dashboard-kpi__value">
                            {{ $inquiriesCount ?? 0 }}
                        </div>

                        <div class="dashboard-kpi__description">
                            Business enquiries
                        </div>

                    </div>

                    <div class="dashboard-kpi__icon dashboard-kpi__icon--cyan">
                        <i class="bi bi-briefcase"></i>
                    </div>

                </div>

                <div class="dashboard-kpi__footer">

                    <a
                        href="{{ route('admin.inquiries.index') }}"
                        class="dashboard-view-all">

                        View All
                        <i class="bi bi-arrow-right"></i>

                    </a>

                </div>

            </div>

        </div>


        {{-- AI Leads --}}
        <div class="col-xl-2 col-lg-4 col-md-6">

            <div class="feature-card dashboard-kpi dashboard-kpi--danger h-100">

                <div class="dashboard-kpi__main">

                    <div>

                        <div class="dashboard-kpi__label">
                            AI Leads
                        </div>

                        <div class="dashboard-kpi__value">
                            {{ $totalLeads ?? 0 }}
                        </div>

                        <div class="dashboard-kpi__description">
                            AI-qualified leads
                        </div>

                    </div>

                    <div class="dashboard-kpi__icon dashboard-kpi__icon--danger">
                        <i class="bi bi-person-lines-fill"></i>
                    </div>

                </div>

                <div class="dashboard-kpi__footer">

                    <a
                        href="{{ route('admin.inquiries.index') }}"
                        class="dashboard-view-all">

                        View All
                        <i class="bi bi-arrow-right"></i>

                    </a>

                </div>

            </div>

        </div>

    </div>


    {{-- ==========================================================
         AI LEAD OVERVIEW
    =========================================================== --}}

    <div class="feature-card mb-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">

            <div>

                <div class="eyebrow">
                    AI Lead Intelligence
                </div>

                <h3 class="mb-1">
                    Lead Overview
                </h3>

                <p class="text-secondary mb-0">
                    Current lead quality and AI qualification status.
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

            {{-- Hot --}}
            <div class="col-xl-3 col-md-6">

                <div class="border rounded p-3 h-100 dashboard-lead-summary dashboard-lead-summary--hot">

                    <div class="d-flex justify-content-between">

                        <span>
                            Hot Leads
                        </span>

                        <i class="bi bi-fire fs-4"></i>

                    </div>

                    <div class="fs-2 fw-bold mt-1">
                        {{ $hotLeads ?? 0 }}
                    </div>

                    <small>
                        High-priority prospects
                    </small>

                </div>

            </div>


            {{-- Warm --}}
            <div class="col-xl-3 col-md-6">

                <div class="border rounded p-3 h-100 dashboard-lead-summary dashboard-lead-summary--warm">

                    <div class="d-flex justify-content-between">

                        <span>
                            Warm Leads
                        </span>

                        <i class="bi bi-thermometer-half fs-4"></i>

                    </div>

                    <div class="fs-2 fw-bold mt-1">
                        {{ $warmLeads ?? 0 }}
                    </div>

                    <small>
                        Follow-up prospects
                    </small>

                </div>

            </div>


            {{-- Qualified --}}
            <div class="col-xl-3 col-md-6">

                <div class="border rounded p-3 h-100 dashboard-lead-summary dashboard-lead-summary--qualified">

                    <div class="d-flex justify-content-between">

                        <span>
                            Qualified
                        </span>

                        <i class="bi bi-patch-check fs-4"></i>

                    </div>

                    <div class="fs-2 fw-bold mt-1">
                        {{ $qualifiedLeads ?? 0 }}
                    </div>

                    <small>
                        Sales-ready prospects
                    </small>

                </div>

            </div>


            {{-- AI analyzed --}}
            <div class="col-xl-3 col-md-6">

                <div class="border rounded p-3 h-100 dashboard-lead-summary dashboard-lead-summary--ai">

                    <div class="d-flex justify-content-between">

                        <span>
                            AI Analyzed
                        </span>

                        <i class="bi bi-robot fs-4"></i>

                    </div>

                    <div class="fs-2 fw-bold mt-1">
                        {{ $analyzedLeads ?? 0 }}
                    </div>

                    <small>
                        Leads processed by AI
                    </small>

                </div>

            </div>

        </div>

    </div>


    {{-- ==========================================================
         VISUAL ANALYTICS
    =========================================================== --}}

    <div class="row g-4 mb-4">

        {{-- Lead Pipeline --}}
        <div class="col-lg-7">

            <div class="feature-card dashboard-chart-card h-100">

                <div class="dashboard-section-header">

                    <div>

                        <div class="eyebrow">
                            Sales Pipeline
                        </div>

                        <h3 class="mb-1">
                            Lead Distribution
                        </h3>

                        <p class="text-secondary mb-0">
                            Current leads by pipeline status.
                        </p>

                    </div>

                    <div class="dashboard-chart-icon dashboard-chart-icon--pipeline">
                        <i class="bi bi-bar-chart-fill"></i>
                    </div>

                </div>


                <div class="dashboard-chart-container">

                    <canvas id="leadPipelineChart"></canvas>

                </div>

            </div>

        </div>


        {{-- Lead Temperature --}}
        <div class="col-lg-5">

            <div class="feature-card dashboard-chart-card h-100">

                <div class="dashboard-section-header">

                    <div>

                        <div class="eyebrow">
                            AI Qualification
                        </div>

                        <h3 class="mb-1">
                            Lead Temperature
                        </h3>

                        <p class="text-secondary mb-0">
                            Distribution of AI-qualified prospects.
                        </p>

                    </div>

                    <div class="dashboard-chart-icon dashboard-chart-icon--temperature">
                        <i class="bi bi-thermometer-half"></i>
                    </div>

                </div>


                <div class="dashboard-chart-container dashboard-chart-container--doughnut">

                    <canvas id="leadTemperatureChart"></canvas>

                    <div class="dashboard-chart-center">

                        <strong>
                            {{ $totalLeads ?? 0 }}
                        </strong>

                        <span>
                            AI Leads
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ==========================================================
         AI PERFORMANCE
    =========================================================== --}}

    <div class="feature-card mb-4">

        <div class="mb-3">

            <div class="eyebrow">
                AI Performance
            </div>

            <h3 class="mb-1">
                Lead Performance Indicators
            </h3>

        </div>


        <div class="row g-3">

            {{-- Average Score --}}
            <div class="col-xl-3 col-md-6">

                <div class="border rounded p-3 dashboard-metric-card">

                    <span class="text-secondary small">
                        Average Lead Score
                    </span>

                    <div class="fs-3 fw-bold mt-1">
                        {{ $averageLeadScore ?? 0 }}
                        <small class="fs-6 text-secondary">/100</small>
                    </div>

                </div>

            </div>


            {{-- AI Coverage --}}
            <div class="col-xl-3 col-md-6">

                <div class="border rounded p-3 dashboard-metric-card">

                    <span class="text-secondary small">
                        AI Analysis Coverage
                    </span>

                    <div class="fs-3 fw-bold mt-1">
                        {{ $aiAnalyzedPercentage ?? 0 }}%
                    </div>

                </div>

            </div>


            {{-- Qualified Rate --}}
            <div class="col-xl-3 col-md-6">

                <div class="border rounded p-3 dashboard-metric-card">

                    <span class="text-secondary small">
                        Qualified Rate
                    </span>

                    <div class="fs-3 fw-bold mt-1">
                        {{ $qualifiedLeadPercentage ?? 0 }}%
                    </div>

                </div>

            </div>


            {{-- Conversion --}}
            <div class="col-xl-3 col-md-6">

                <div class="border rounded p-3 dashboard-metric-card">

                    <span class="text-secondary small">
                        Conversion Rate
                    </span>

                    <div class="fs-3 fw-bold mt-1">
                        {{ $conversionRate ?? 0 }}%
                    </div>

                </div>

            </div>


            {{-- Pending --}}
            <div class="col-xl-3 col-md-6">

                <div class="border rounded p-3 dashboard-metric-card">

                    <span class="text-secondary small">
                        AI Pending
                    </span>

                    <div class="fs-3 fw-bold mt-1">
                        {{ $pendingLeads ?? 0 }}
                    </div>

                </div>

            </div>


            {{-- Upcoming --}}
            <div class="col-xl-3 col-md-6">

                <div class="border rounded p-3 dashboard-metric-card">

                    <span class="text-secondary small">
                        Upcoming Follow-ups
                    </span>

                    <div class="fs-3 fw-bold mt-1">
                        {{ $upcomingFollowUps ?? 0 }}
                    </div>

                </div>

            </div>


            {{-- Overdue --}}
            <div class="col-xl-3 col-md-6">

                <div class="border rounded p-3 dashboard-metric-card">

                    <span class="text-secondary small">
                        Overdue Follow-ups
                    </span>

                    <div class="fs-3 fw-bold mt-1">
                        {{ $overdueFollowUps ?? 0 }}
                    </div>

                </div>

            </div>


            {{-- Total --}}
            <div class="col-xl-3 col-md-6">

                <div class="border rounded p-3 dashboard-metric-card">

                    <span class="text-secondary small">
                        Total AI Leads
                    </span>

                    <div class="fs-3 fw-bold mt-1">
                        {{ $totalLeads ?? 0 }}
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ==========================================================
         PRIORITY LEADS
    =========================================================== --}}

    <div class="feature-card mb-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">

            <div>

                <div class="eyebrow">
                    AI Prioritization
                </div>

                <h3 class="mb-1">
                    Priority Leads
                </h3>

                <p class="text-secondary mb-0">
                    Highest-scoring prospects requiring attention.
                </p>

            </div>

            <a
                href="{{ route('admin.inquiries.index') }}"
                class="btn btn-outline-light">

                <i class="bi bi-list-ul me-1"></i>
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

                            <th class="text-center">
                                Score
                            </th>

                            <th class="text-center">
                                Temperature
                            </th>

                            <th>Status</th>

                            <th>Follow-up</th>

                            <th class="text-end">
                                Action
                            </th>

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

                                    <span
                                        class="d-inline-block text-truncate"
                                        style="max-width:220px;">

                                        {{ $lead->service_interest ?: $lead->project_type }}

                                    </span>

                                </td>


                                <td class="text-center">

                                    <span class="badge bg-primary px-2">
                                        {{ $lead->lead_score ?? 0 }}
                                    </span>

                                </td>


                                <td class="text-center">

                                    @php
                                        $temperature = strtoupper(
                                            $lead->lead_temperature ?? ''
                                        );
                                    @endphp

                                    @if($temperature === 'HOT')

                                        <span class="badge bg-danger">
                                            HOT
                                        </span>

                                    @elseif($temperature === 'WARM')

                                        <span class="badge bg-warning text-dark">
                                            WARM
                                        </span>

                                    @elseif($temperature === 'QUALIFIED')

                                        <span class="badge bg-success">
                                            QUALIFIED
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            {{ $temperature ?: '—' }}
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


                                <td class="text-end">

                                    <a
                                        href="{{ route('admin.inquiries.show', $lead->id) }}"
                                        class="btn btn-sm btn-outline-light"
                                        title="View Inquiry">

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


    {{-- ==========================================================
         FOLLOW-UP ALERT
    =========================================================== --}}

    @if(($overdueFollowUps ?? 0) > 0)

        <div class="feature-card mb-4 border border-danger">

            <div class="d-flex align-items-center gap-3 flex-wrap">

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

</section>


{{-- ==========================================================
     DASHBOARD CHARTS
=========================================================== --}}

@push('scripts')

{{-- Load Chart.js only once for this dashboard --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard Chart Defaults
    |--------------------------------------------------------------------------
    */

    const chartTextColor = '#9aa4b2';
    const chartGridColor = 'rgba(255, 255, 255, 0.07)';


    /*
    |--------------------------------------------------------------------------
    | LEAD DISTRIBUTION
    |--------------------------------------------------------------------------
    */

    const pipelineCanvas =
        document.getElementById('leadPipelineChart');

    if (pipelineCanvas) {

        const pipelineValues = [
            {{ $newLeads ?? 0 }},
            {{ $contactedLeads ?? 0 }},
            {{ $qualifiedPipelineLeads ?? 0 }},
            {{ $convertedLeads ?? 0 }},
            {{ $lostLeads ?? 0 }}
        ];

        const pipelineTotal =
            pipelineValues.reduce(
                (total, value) => total + value,
                0
            );

        const pipelineMax =
            Math.max(...pipelineValues, 1);


        new Chart(pipelineCanvas, {

            type: 'bar',

            data: {

                labels: [
                    'New',
                    'Contacted',
                    'Qualified',
                    'Converted',
                    'Lost'
                ],

                datasets: [{

                    label: 'Leads',

                    data: pipelineValues,

                    backgroundColor: [
                        'rgba(56, 189, 248, 0.82)',
                        'rgba(168, 85, 247, 0.82)',
                        'rgba(34, 197, 94, 0.82)',
                        'rgba(250, 204, 21, 0.82)',
                        'rgba(239, 68, 68, 0.82)'
                    ],

                    borderColor: [
                        '#38bdf8',
                        '#a855f7',
                        '#22c55e',
                        '#facc15',
                        '#ef4444'
                    ],

                    borderWidth: 1,

                    borderRadius: 6,

                    borderSkipped: false,

                    barPercentage: 0.68,

                    categoryPercentage: 0.72

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                layout: {

                    padding: {
                        top: 25,
                        right: 10,
                        left: 5,
                        bottom: 5
                    }

                },

                plugins: {

                    legend: {
                        display: false
                    },

                    tooltip: {

                        callbacks: {

                            label: function (context) {

                                return ' ' +
                                    context.raw +
                                    ' lead' +
                                    (context.raw === 1 ? '' : 's');

                            }

                        }

                    }

                },

                scales: {

                    x: {

                        grid: {
                            display: false
                        },

                        ticks: {

                            color: chartTextColor,

                            font: {
                                size: 11,
                                weight: '500'
                            }

                        }

                    },

                    y: {

                        beginAtZero: true,

                        suggestedMax:
                            pipelineMax <= 3
                                ? pipelineMax + 2
                                : Math.ceil(pipelineMax * 1.25),

                        grid: {

                            color: chartGridColor

                        },

                        border: {
                            display: false
                        },

                        ticks: {

                            color: chartTextColor,

                            precision: 0,

                            stepSize: 1

                        }

                    }

                }

            },

            plugins: [

                {

                    id: 'pipelineDataLabels',

                    afterDatasetsDraw: function (chart) {

                        const ctx =
                            chart.ctx;

                        ctx.save();

                        ctx.font =
                            '600 12px Arial';

                        ctx.textAlign =
                            'center';

                        ctx.textBaseline =
                            'bottom';

                        chart
                            .getDatasetMeta(0)
                            .data
                            .forEach(function (
                                bar,
                                index
                            ) {

                                const value =
                                    pipelineValues[index];

                                if (value > 0) {

                                    ctx.fillStyle =
                                        '#f5f7fa';

                                    ctx.fillText(
                                        value,
                                        bar.x,
                                        bar.y - 6
                                    );

                                }

                            });

                        ctx.restore();

                    }

                }

            ]

        });

    }


    /*
    |--------------------------------------------------------------------------
    | LEAD TEMPERATURE
    |--------------------------------------------------------------------------
    */

    const temperatureCanvas =
        document.getElementById('leadTemperatureChart');

    if (temperatureCanvas) {

        const temperatureValues = [

            {{ $hotLeads ?? 0 }},
            {{ $warmLeads ?? 0 }},
            {{ $qualifiedLeads ?? 0 }},

            {{
                max(
                    ($totalLeads ?? 0)
                    - ($hotLeads ?? 0)
                    - ($warmLeads ?? 0)
                    - ($qualifiedLeads ?? 0),
                    0
                )
            }}

        ];

        const temperatureTotal =
            temperatureValues.reduce(
                (total, value) => total + value,
                0
            );


        new Chart(temperatureCanvas, {

            type: 'doughnut',

            data: {

                labels: [
                    'Hot',
                    'Warm',
                    'Qualified',
                    'Other'
                ],

                datasets: [{

                    data: temperatureValues,

                    backgroundColor: [

                        '#ef4444',
                        '#f59e0b',
                        '#22c55e',
                        '#64748b'

                    ],

                    borderColor:
                        '#171717',

                    borderWidth: 3,

                    hoverOffset: 6

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                cutout: '62%',

                layout: {

                    padding: 10

                },

                plugins: {

                    legend: {

                        position: 'bottom',

                        labels: {

                            color: chartTextColor,

                            usePointStyle: true,

                            pointStyle: 'rectRounded',

                            padding: 18,

                            font: {
                                size: 11,
                                weight: '500'
                            }

                        }

                    },

                    tooltip: {

                        callbacks: {

                            label: function (context) {

                                const value =
                                    context.raw;

                                const percentage =
                                    temperatureTotal > 0
                                        ? Math.round(
                                            (value /
                                                temperatureTotal) *
                                            100
                                        )
                                        : 0;

                                return ' ' +
                                    context.label +
                                    ': ' +
                                    value +
                                    ' (' +
                                    percentage +
                                    '%)';

                            }

                        }

                    }

                }

            }

        });

    }

});

</script>

@endpush


{{-- ==========================================================
     DASHBOARD-SPECIFIC STYLING
=========================================================== --}}

@push('styles')

<style>

    /*
    |--------------------------------------------------------------------------
    | KPI CARDS
    |--------------------------------------------------------------------------
    */

    .dashboard-kpi {

        transition:
            transform .18s ease,
            box-shadow .18s ease;

    }


    .dashboard-kpi:hover {

        transform: translateY(-3px);

        box-shadow:
            0 8px 25px rgba(0, 0, 0, .20);

    }


    .dashboard-kpi__value {

        line-height: 1;

    }


    .dashboard-kpi__description {

        font-size: .76rem;

        margin-top: .45rem;

    }


    .dashboard-kpi__footer {

        margin-top: 1rem;

        padding-top: .7rem;

        border-top:
            1px solid rgba(255, 255, 255, .08);

    }


    .dashboard-view-all {

        display: inline-flex;

        align-items: center;

        gap: .3rem;

        font-size: .72rem;

        font-weight: 600;

        text-decoration: none;

        color: rgba(255, 255, 255, .78);

        transition:
            color .15s ease,
            gap .15s ease;

    }


    .dashboard-view-all:hover {

        color: #ffffff;

        gap: .5rem;

    }


    /*
    |--------------------------------------------------------------------------
    | LEAD SUMMARY CARDS
    |--------------------------------------------------------------------------
    */

    .dashboard-lead-summary {

        background:
            rgba(255, 255, 255, .015);

        border-color:
            rgba(255, 255, 255, .16) !important;

        transition:
            transform .18s ease,
            border-color .18s ease,
            background .18s ease;

    }


    .dashboard-lead-summary:hover {

        transform: translateY(-2px);

        background:
            rgba(255, 255, 255, .035);

    }


    .dashboard-lead-summary small {

        color: #7f8a99;

    }


    .dashboard-lead-summary--hot {

        border-left:
            3px solid #ef4444 !important;

    }


    .dashboard-lead-summary--hot i {

        color: #ef4444;

    }


    .dashboard-lead-summary--warm {

        border-left:
            3px solid #f59e0b !important;

    }


    .dashboard-lead-summary--warm i {

        color: #f59e0b;

    }


    .dashboard-lead-summary--qualified {

        border-left:
            3px solid #22c55e !important;

    }


    .dashboard-lead-summary--qualified i {

        color: #22c55e;

    }


    .dashboard-lead-summary--ai {

        border-left:
            3px solid #22d3ee !important;

    }


    .dashboard-lead-summary--ai i {

        color: #22d3ee;

    }


    /*
    |--------------------------------------------------------------------------
    | CHART CARDS
    |--------------------------------------------------------------------------
    */

    .dashboard-chart-card {

        min-height: 390px;

    }


    .dashboard-section-header {

        display: flex;

        justify-content: space-between;

        align-items: flex-start;

        gap: 1rem;

        margin-bottom: .5rem;

    }


    .dashboard-chart-icon {

        width: 42px;

        height: 42px;

        flex: 0 0 42px;

        display: flex;

        align-items: center;

        justify-content: center;

        border-radius: 9px;

        color: #22d3c5;

        background:
            rgba(34, 211, 197, .08);

        border:
            1px solid rgba(34, 211, 197, .25);

    }


    .dashboard-chart-icon--temperature {

        color: #fbbf24;

        background:
            rgba(251, 191, 36, .08);

        border-color:
            rgba(251, 191, 36, .25);

    }


    .dashboard-chart-container {

        position: relative;

        width: 100%;

        height: 285px;

        margin-top: .5rem;

    }


    .dashboard-chart-container--doughnut {

        height: 285px;

        display: flex;

        align-items: center;

        justify-content: center;

    }


    .dashboard-chart-container--doughnut canvas {

        max-width: 100%;

        max-height: 100%;

    }


    .dashboard-chart-center {

        position: absolute;

        top: 46%;

        left: 50%;

        transform:
            translate(-50%, -50%);

        display: flex;

        flex-direction: column;

        align-items: center;

        justify-content: center;

        pointer-events: none;

        text-align: center;

    }


    .dashboard-chart-center strong {

        font-size: 1.65rem;

        line-height: 1;

        color: #ffffff;

    }


    .dashboard-chart-center span {

        margin-top: .3rem;

        font-size: .68rem;

        color: #7f8a99;

        text-transform: uppercase;

        letter-spacing: .06em;

    }


    /*
    |--------------------------------------------------------------------------
    | PERFORMANCE METRICS
    |--------------------------------------------------------------------------
    */

    .dashboard-metric-card {

        min-height: 95px;

        background:
            rgba(255, 255, 255, .015);

        border-color:
            rgba(255, 255, 255, .12) !important;

        transition:
            border-color .18s ease,
            background .18s ease;

    }


    .dashboard-metric-card:hover {

        background:
            rgba(255, 255, 255, .03);

        border-color:
            rgba(34, 211, 197, .28) !important;

    }


    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */

    .table-responsive {

        border-radius: .5rem;

    }


    /*
    |--------------------------------------------------------------------------
    | RESPONSIVE
    |--------------------------------------------------------------------------
    */

    @media (max-width: 991px) {

        .dashboard-chart-card {

            min-height: 360px;

        }

        .dashboard-chart-container {

            height: 260px;

        }

    }


    @media (max-width: 767px) {

        .dashboard-kpi {

            min-height: 130px;

        }


        .dashboard-chart-card {

            min-height: 350px;

        }


        .dashboard-chart-container {

            height: 250px;

        }


        .dashboard-section-header {

            align-items: center;

        }

    }

</style>

@endpush

@endsection
