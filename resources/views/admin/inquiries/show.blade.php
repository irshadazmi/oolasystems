@extends('layouts.app')

@section('title', 'Inquiry Details | Oola Systems')

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        <i class="bi bi-exclamation-triangle me-2"></i>
        {{ session('error') }}
    </div>
@endif


<section class="section-block">

    {{-- ====================================================== --}}
    {{-- Page Header --}}
    {{-- ====================================================== --}}

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>

            <div class="eyebrow">
                Administration
            </div>

            <h1 class="page-title text-start mb-1">
                Inquiry Details
            </h1>

            <p class="page-subtitle text-start ms-0 mb-0">
                Review inquiry, AI lead intelligence and follow-up activity.
            </p>

        </div>


        <div class="d-flex gap-2 flex-wrap">

            {{-- Re-analyze --}}
            @if($leadInquiry)

                <form class="d-flex justify-content-end"
                    method="POST"
                    action="{{ route('admin.inquiries.reanalyze', $leadInquiry) }}"
                    class="d-inline">

                    @csrf

                    <button
                        type="submit"
                        class="btn btn-outline-primary align-items-center"
                        onclick="return confirm('Re-analyze this lead using AI?')">

                        <i class="bi bi-stars me-2"></i>
                        Re-analyze with AI

                    </button>

                </form>

            @endif


            {{-- Reply --}}
            <a
                href="{{ route('admin.inquiries.edit', $inquiry) }}"
                class="btn btn-primary">

                <i class="bi bi-reply-fill me-2"></i>
                Reply

            </a>


            {{-- Back --}}
            <a
                href="{{ route('admin.inquiries.index') }}"
                class="btn btn-outline-light d-inline-flex align-items-center">

                <i class="bi bi-arrow-left d-inline-flex align-items-center me-2"></i>
                Back

            </a>

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- Inquiry Overview --}}
    {{-- ====================================================== --}}

    <div class="feature-card mb-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">

            <div>

                <div class="eyebrow">
                    Customer Inquiry
                </div>

                <h3 class="mb-1">
                    {{ $inquiry->name }}
                </h3>

                <div class="text-secondary">
                    {{ $inquiry->email }}
                </div>

            </div>


            <div class="d-flex gap-2 flex-wrap">

                <span class="badge bg-dark">
                    Inquiry #{{ $inquiry->id }}
                </span>

                @php
                    $status = $inquiry->status ?? 'New';

                    $statusClass = match(strtolower($status)) {
                        'new' => 'bg-primary',
                        'read' => 'bg-info',
                        'replied' => 'bg-success',
                        'closed' => 'bg-secondary',
                        default => 'bg-dark',
                    };
                @endphp

                <span class="badge {{ $statusClass }}">
                    {{ $status }}
                </span>

            </div>

        </div>


        <div class="row g-3">

            <div class="col-lg-3 col-md-6">

                <label class="form-label text-secondary mb-1">
                    Project Type
                </label>

                <div class="form-control">
                    {{ $inquiry->project_type ?: 'Not specified' }}
                </div>

            </div>


            <div class="col-lg-3 col-md-6">

                <label class="form-label text-secondary mb-1">
                    Submitted
                </label>

                <div class="form-control">
                    {{ $inquiry->created_at->format('d M Y, h:i A') }}
                </div>

            </div>


            <div class="col-lg-3 col-md-6">

                <label class="form-label text-secondary mb-1">
                    Last Updated
                </label>

                <div class="form-control">
                    {{ $inquiry->updated_at->format('d M Y, h:i A') }}
                </div>

            </div>


            <div class="col-lg-3 col-md-6">

                <label class="form-label text-secondary mb-1">
                    Lead Status
                </label>

                <div class="form-control">

                    @if($leadInquiry)

                        @php
                            $leadStatusClass = match($leadInquiry->lead_status) {
                                'New' => 'bg-primary',
                                'Contacted' => 'bg-info',
                                'Qualified' => 'bg-success',
                                'Converted' => 'bg-success',
                                'Lost' => 'bg-danger',
                                default => 'bg-secondary',
                            };
                        @endphp

                        <span class="badge {{ $leadStatusClass }}">
                            {{ $leadInquiry->lead_status ?? 'New' }}
                        </span>

                    @else

                        <span class="text-secondary">
                            Not available
                        </span>

                    @endif

                </div>

            </div>


            {{-- Requirements --}}
            <div class="col-lg-6">

                <label class="form-label text-secondary mb-1">
                    Project Requirements
                </label>

                <div
                    class="form-control"
                    style="min-height:110px; height:auto; white-space:pre-wrap;">

                    {{ $inquiry->message }}

                </div>

            </div>


            {{-- Response --}}
            <div class="col-lg-6">

                <label class="form-label text-secondary mb-1">
                    Response
                </label>

                <div
                    class="form-control"
                    style="min-height:110px; height:auto; white-space:pre-wrap;">

                    {{ $inquiry->response ?: 'No response has been provided yet.' }}

                </div>

            </div>

        </div>

    </div>



    {{-- ====================================================== --}}
    {{-- AI Lead Intelligence --}}
    {{-- ====================================================== --}}

    @if($leadInquiry)

        <div class="feature-card mb-4">

            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

                <div>

                    <div class="eyebrow">
                        AI Lead Intelligence
                    </div>

                    <h2 class="mb-1">
                        Lead Analysis
                    </h2>

                    <p class="text-secondary mb-0">
                        AI-generated qualification and sales intelligence.
                    </p>

                </div>


                <div>

                    @if($leadInquiry->ai_processed_at)

                        <span class="badge bg-success px-3 py-2">

                            <i class="bi bi-check-circle me-1"></i>
                            AI Analyzed

                        </span>

                    @else

                        <span class="badge bg-warning text-dark px-3 py-2">

                            <i class="bi bi-clock me-1"></i>
                            Analysis Pending

                        </span>

                    @endif

                </div>

            </div>


            {{-- ================================================== --}}
            {{-- Visual Analytics --}}
            {{-- ================================================== --}}

            <div class="row g-3 mb-4">

                {{-- Lead Score Chart --}}
                <div class="col-lg-4">

                    <div class="feature-card h-100 text-center">

                        <div class="text-secondary small mb-2">
                            Lead Score
                        </div>

                        <div
                            style="
                                position:relative;
                                width:170px;
                                height:170px;
                                margin:0 auto;
                            ">

                            <canvas id="leadScoreChart"></canvas>

                            <div
                                style="
                                    position:absolute;
                                    inset:0;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    flex-direction:column;
                                    pointer-events:none;
                                ">

                                <div class="display-5 fw-bold">
                                    {{ $leadInquiry->lead_score ?? 0 }}
                                </div>

                                <small class="text-secondary">
                                    / 100
                                </small>

                            </div>

                        </div>


                        <div class="mt-3">

                            @php
                                $score = (int) ($leadInquiry->lead_score ?? 0);

                                if ($score >= 80) {
                                    $scoreLabel = 'Very High';
                                    $scoreClass = 'text-success';
                                } elseif ($score >= 60) {
                                    $scoreLabel = 'High';
                                    $scoreClass = 'text-info';
                                } elseif ($score >= 40) {
                                    $scoreLabel = 'Moderate';
                                    $scoreClass = 'text-warning';
                                } else {
                                    $scoreLabel = 'Low';
                                    $scoreClass = 'text-secondary';
                                }
                            @endphp

                            <span class="{{ $scoreClass }} fw-semibold">
                                {{ $scoreLabel }} Lead Potential
                            </span>

                        </div>

                    </div>

                </div>


                {{-- Temperature --}}
                <div class="col-lg-4">

                    <div class="feature-card h-100">

                        <div class="text-secondary small mb-3">
                            Lead Temperature
                        </div>

                        <div class="text-center py-2">

                            @php

                                $temperature =
                                    strtoupper(
                                        $leadInquiry->lead_temperature ?? 'UNKNOWN'
                                    );

                                $temperatureClass = match($temperature) {

                                    'HOT'
                                        => 'bg-danger',

                                    'WARM'
                                        => 'bg-warning text-dark',

                                    'QUALIFIED'
                                        => 'bg-success',

                                    'LOW'
                                        => 'bg-secondary',

                                    default
                                        => 'bg-dark',

                                };

                                $temperatureIcon = match($temperature) {

                                    'HOT'
                                        => 'bi-fire',

                                    'WARM'
                                        => 'bi-thermometer-half',

                                    'QUALIFIED'
                                        => 'bi-check-circle',

                                    default
                                        => 'bi-thermometer',

                                };

                            @endphp


                            <i
                                class="bi {{ $temperatureIcon }}"
                                style="font-size:3rem;">
                            </i>


                            <div class="mt-3">

                                <span
                                    class="badge {{ $temperatureClass }}"
                                    style="font-size:1rem; padding:.6rem 1rem;">

                                    {{ $temperature }}

                                </span>

                            </div>

                        </div>


                        <div class="mt-3">

                            <div class="d-flex justify-content-between small mb-1">

                                <span>
                                    Conversion Priority
                                </span>

                                <strong>
                                    {{ $score }}%
                                </strong>

                            </div>

                            <div class="progress" style="height:8px;">

                                <div
                                    class="progress-bar"
                                    role="progressbar"
                                    style="width:{{ min($score, 100) }}%;">

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- AI Processing --}}
                <div class="col-lg-4">

                    <div class="feature-card h-100">

                        <div class="text-secondary small mb-3">
                            AI Processing
                        </div>

                        <div class="text-center py-2">

                            <i
                                class="bi bi-robot text-info"
                                style="font-size:3rem;">
                            </i>

                            @if($leadInquiry->ai_processed_at)

                                <h4 class="mt-3 mb-1">
                                    Completed
                                </h4>

                                <div class="text-secondary small">

                                    {{ $leadInquiry->ai_processed_at->format('d M Y') }}

                                    <br>

                                    {{ $leadInquiry->ai_processed_at->format('h:i A') }}

                                </div>

                            @else

                                <h4 class="mt-3 mb-1">
                                    Pending
                                </h4>

                                <div class="text-secondary small">
                                    AI analysis has not been completed.
                                </div>

                            @endif

                        </div>

                    </div>

                </div>

            </div>



            {{-- ================================================== --}}
            {{-- AI Lead Profile --}}
            {{-- ================================================== --}}

            <div class="row g-3 mb-4">

                <div class="col-lg-4">

                    <div class="feature-card h-100">

                        <div class="text-secondary small mb-2">
                            Service Interest
                        </div>

                        <div class="fw-semibold">
                            {{ $leadInquiry->service_interest ?: 'Not specified' }}
                        </div>

                    </div>

                </div>


                <div class="col-lg-4">

                    <div class="feature-card h-100">

                        <div class="text-secondary small mb-2">
                            Expected Timeline
                        </div>

                        <div class="fw-semibold">
                            {{ $leadInquiry->timeline ?: 'Not specified' }}
                        </div>

                    </div>

                </div>


                <div class="col-lg-4">

                    <div class="feature-card h-100">

                        <div class="text-secondary small mb-2">
                            Budget Range
                        </div>

                        <div class="fw-semibold">
                            {{ $leadInquiry->budget_range ?: 'Not specified' }}
                        </div>

                    </div>

                </div>

            </div>



            {{-- ================================================== --}}
            {{-- AI Summary + Recommendation --}}
            {{-- ================================================== --}}

            <div class="row g-3">

                <div class="col-lg-7">

                    <div class="feature-card h-100">

                        <div class="d-flex align-items-center gap-2 mb-3">

                            <i class="bi bi-file-earmark-text text-primary"></i>

                            <h5 class="mb-0">
                                AI Summary
                            </h5>

                        </div>

                        <div
                            class="text-secondary"
                            style="
                                line-height:1.7;
                                white-space:pre-wrap;
                            ">

                            {{ $leadInquiry->ai_summary ?: 'AI summary is not available.' }}

                        </div>

                    </div>

                </div>


                <div class="col-lg-5">

                    <div class="feature-card h-100">

                        <div class="d-flex align-items-center gap-2 mb-3">

                            <i class="bi bi-lightbulb text-warning"></i>

                            <h5 class="mb-0">
                                Recommended Action
                            </h5>

                        </div>

                        <div
                            class="text-secondary"
                            style="
                                line-height:1.7;
                                white-space:pre-wrap;
                            ">

                            {{ $leadInquiry->ai_recommendation ?: 'No recommendation is available.' }}

                        </div>

                    </div>

                </div>

            </div>

        </div>



        {{-- ====================================================== --}}
        {{-- Lead Management --}}
        {{-- ====================================================== --}}

        <div class="feature-card mb-4">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

                <div>

                    <div class="eyebrow">
                        Lead Management
                    </div>

                    <h2 class="mb-1">
                        Follow-up & Qualification
                    </h2>

                    <p class="text-secondary mb-0">
                        Manage sales status and follow-up activities.
                    </p>

                </div>


                @if($leadInquiry->last_contacted_at)

                    <span class="badge bg-info px-3 py-2">

                        <i class="bi bi-telephone me-1"></i>

                        Last contacted:
                        {{ $leadInquiry->last_contacted_at->format('d M Y, h:i A') }}

                    </span>

                @endif

            </div>


            {{-- ================================================== --}}
            {{-- Status + Follow-up + Contact --}}
            {{-- ================================================== --}}

            <div class="row g-3">

                {{-- Lead Status --}}
                <div class="col-lg-4">

                    <div class="feature-card h-100">

                        <label class="form-label text-secondary">
                            Lead Status
                        </label>

                        <form
                            method="POST"
                            action="{{ route('admin.inquiries.lead-status', $inquiry) }}">

                            @csrf

                            <select
                                name="lead_status"
                                class="form-select mb-3">

                                @foreach([
                                    'New',
                                    'Contacted',
                                    'Qualified',
                                    'Converted',
                                    'Lost'
                                ] as $leadStatus)

                                    <option
                                        value="{{ $leadStatus }}"
                                        @selected($leadInquiry->lead_status === $leadStatus)>

                                        {{ $leadStatus }}

                                    </option>

                                @endforeach

                            </select>


                            <button
                                type="submit"
                                class="btn btn-primary w-100">

                                <i class="bi bi-check2-circle me-2"></i>
                                Update Status

                            </button>

                        </form>

                    </div>

                </div>


                {{-- Follow-up --}}
                <div class="col-lg-4">

                    <div class="feature-card h-100">

                        <form
                            method="POST"
                            action="{{ route('admin.inquiries.follow-up', $inquiry) }}">

                            @csrf

                            <label class="form-label text-secondary">
                                Follow-up Date
                            </label>

                            <input
                                type="date"
                                name="follow_up_date"
                                class="form-control mb-3"
                                value="{{ old(
                                    'follow_up_date',
                                    optional($leadInquiry->follow_up_date)->format('Y-m-d')
                                ) }}">


                            <label class="form-label text-secondary">
                                Follow-up Notes
                            </label>

                            <textarea
                                name="follow_up_notes"
                                class="form-control mb-3"
                                rows="3"
                                placeholder="Next discussion, requirements or action...">{{ old(
                                    'follow_up_notes',
                                    $leadInquiry->follow_up_notes
                                ) }}</textarea>


                            <button
                                type="submit"
                                class="btn btn-primary w-100">

                                <i class="bi bi-save me-2"></i>
                                Save Follow-up

                            </button>

                        </form>

                    </div>

                </div>


                {{-- Contact Activity --}}
                <div class="col-lg-4">

                    <div class="feature-card h-100">

                        <div class="text-secondary small mb-2">
                            Contact Activity
                        </div>


                        @if($leadInquiry->last_contacted_at)

                            <div class="fw-semibold mb-1">
                                Last Contacted
                            </div>

                            <div class="text-secondary mb-4">

                                {{ $leadInquiry->last_contacted_at->format('d M Y') }}

                                <br>

                                {{ $leadInquiry->last_contacted_at->format('h:i A') }}

                            </div>

                        @else

                            <div class="text-secondary mb-4">
                                This lead has not been contacted yet.
                            </div>

                        @endif


                        <form
                            method="POST"
                            action="{{ route('admin.inquiries.mark-contacted', $inquiry) }}"
                            onsubmit="return confirm('Mark this lead as contacted?')">

                            @csrf

                            <button
                                type="submit"
                                class="btn btn-outline-info w-100">

                                <i class="bi bi-telephone-check me-2"></i>

                                Mark as Contacted

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>


    @else

        {{-- ================================================== --}}
        {{-- No AI Analysis --}}
        {{-- ================================================== --}}

        <div class="feature-card mb-4 text-center py-5">

            <i
                class="bi bi-robot text-secondary"
                style="font-size:4rem;">
            </i>

            <h4 class="mt-3">
                AI Lead Analysis Not Available
            </h4>

            <p class="text-secondary mb-0">
                No AI lead analysis is associated with this inquiry.
            </p>

        </div>

    @endif



    {{-- ====================================================== --}}
    {{-- Bottom Actions --}}
    {{-- ====================================================== --}}

    <div class="feature-card">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>

                <div class="text-secondary small">
                    Inquiry Actions
                </div>

                <div class="fw-semibold">
                    Manage this inquiry
                </div>

            </div>


            <div class="d-flex gap-2 flex-wrap">

                {{-- Delete --}}
                <form class="d-flex justify-content-end"
                    method="POST"
                    action="{{ route('admin.inquiries.destroy', $inquiry) }}"
                    onsubmit="return confirm('Delete this inquiry permanently?')">

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="btn btn-outline-danger">

                        <i class="bi bi-trash me-2"></i>
                        Delete Inquiry

                    </button>

                </form>


                {{-- Reply --}}
                <a
                    href="{{ route('admin.inquiries.edit', $inquiry) }}"
                    class="btn btn-primary">

                    <i class="bi bi-reply-fill me-2"></i>
                    Reply to Inquiry

                </a>

            </div>

        </div>

    </div>

</section>



{{-- ====================================================== --}}
{{-- Chart.js --}}
{{-- ====================================================== --}}

@if($leadInquiry)

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    const canvas = document.getElementById('leadScoreChart');

    if (!canvas) {
        return;
    }

    const score = {{ (int) ($leadInquiry->lead_score ?? 0) }};

    new Chart(canvas, {

        type: 'doughnut',

        data: {

            labels: [
                'Lead Score',
                'Remaining'
            ],

            datasets: [{

                data: [
                    score,
                    Math.max(100 - score, 0)
                ],

                borderWidth: 0,

                backgroundColor: [
                    '#20c997',
                    'rgba(255,255,255,0.08)'
                ]

            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            cutout: '72%',

            plugins: {

                legend: {
                    display: false
                },

                tooltip: {
                    enabled: false
                }

            }

        }

    });

});

</script>

@endif

@endsection
