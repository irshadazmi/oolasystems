@extends('layouts.app')

@section('title', 'Edit Inquiry | Oola Systems')

@section('content')

<section class="section-block">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-5">

        <div>
            <div class="eyebrow">Administration</div>

            <h1 class="page-title text-start mb-2">
                Reply to Inquiry
            </h1>

            <p class="page-subtitle text-start ms-0 mb-0">
                Review the inquiry, AI lead intelligence and customer response.
            </p>
        </div>


        <div class="d-flex gap-2 flex-wrap">

            {{-- Re-analyze AI --}}

            <form class="d-flex justify-content-end" method="POST"
                action="{{ route('admin.inquiries.reanalyze', $inquiry) }}"
                onsubmit="return confirm('Re-analyze this inquiry using AI?')">

                @csrf

                <button
                    type="submit"
                    class="btn btn-outline-primary">

                    <i class="bi bi-stars me-2"></i>
                    Re-analyze AI

                </button>

            </form>


            {{-- Back --}}

            <a
                href="{{ route('admin.inquiries.index') }}"
                class="btn btn-outline-light">

                <i class="bi bi-arrow-left me-2"></i>
                Back to Inquiries

            </a>

        </div>

    </div>


    {{-- ========================================================== --}}
    {{-- Flash Messages --}}
    {{-- ========================================================== --}}

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


    @if($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif



    {{-- ========================================================== --}}
    {{-- Customer Inquiry --}}
    {{-- ========================================================== --}}

    <div class="feature-card mb-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

            <div>

                <div class="eyebrow">
                    Customer Inquiry
                </div>

                <h3 class="mb-1">
                    {{ $inquiry->name }}
                </h3>

                <div class="text-secondary">
                    Inquiry #{{ $inquiry->id }}
                </div>

            </div>


            <div class="d-flex gap-2 flex-wrap">

                {{-- Inquiry Status --}}

                @php

                    $status = $inquiry->status ?? 'New';

                    $statusClass = match(strtolower($status)) {

                        'new'
                            => 'bg-primary',

                        'read'
                            => 'bg-info',

                        'replied'
                            => 'bg-success',

                        'closed'
                            => 'bg-secondary',

                        default
                            => 'bg-dark',

                    };

                @endphp


                <span class="badge {{ $statusClass }} px-3 py-2">

                    {{ $status }}

                </span>


                {{-- Lead Status --}}

                @php

                    $leadStatus = $inquiry->lead_status ?? 'New';

                    $leadStatusClass = match($leadStatus) {

                        'New'
                            => 'bg-primary',

                        'Contacted'
                            => 'bg-info',

                        'Qualified'
                            => 'bg-success',

                        'Converted'
                            => 'bg-success',

                        'Lost'
                            => 'bg-danger',

                        default
                            => 'bg-secondary',

                    };

                @endphp


                <span class="badge {{ $leadStatusClass }} px-3 py-2">

                    Lead: {{ $leadStatus }}

                </span>

            </div>

        </div>


        <form
            method="POST"
            action="{{ route('admin.inquiries.update', $inquiry) }}">

            @csrf

            @method('PATCH')


            <div class="row g-4">

                {{-- Name --}}

                <div class="col-lg-3 col-md-6">

                    <label class="form-label">
                        Name
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ $inquiry->name }}"
                        readonly>

                </div>


                {{-- Email --}}

                <div class="col-lg-3 col-md-6">

                    <label class="form-label">
                        Email Address
                    </label>

                    <input
                        type="email"
                        class="form-control"
                        value="{{ $inquiry->email }}"
                        readonly>

                </div>


                {{-- Project Type --}}

                <div class="col-lg-3 col-md-6">

                    <label class="form-label">
                        Project Type
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ $inquiry->project_type }}"
                        readonly>

                </div>


                {{-- Inquiry Status --}}

                <div class="col-lg-3 col-md-6">

                    <label class="form-label">
                        Inquiry Status
                    </label>

                    <select
                        name="status"
                        class="form-select">

                        <option
                            value="New"
                            @selected($inquiry->status === 'New')>
                            New
                        </option>

                        <option
                            value="Read"
                            @selected($inquiry->status === 'Read')>
                            Read
                        </option>

                        <option
                            value="Replied"
                            @selected($inquiry->status === 'Replied')>
                            Replied
                        </option>

                        <option
                            value="Closed"
                            @selected($inquiry->status === 'Closed')>
                            Closed
                        </option>

                    </select>

                </div>


                {{-- Customer Message --}}

                <div class="col-12">

                    <label class="form-label">
                        Customer Message
                    </label>

                    <textarea
                        class="form-control"
                        rows="6"
                        readonly>{{ $inquiry->message }}</textarea>

                </div>


                {{-- Customer Response --}}

                <div class="col-12">

                    <label class="form-label">

                        Your Response

                    </label>

                    <textarea
                        name="response"
                        rows="8"
                        class="form-control"
                        placeholder="Type your response to the customer...">{{ old('response', $inquiry->response) }}</textarea>

                    <div class="form-text">

                        This response will be stored against the inquiry.

                    </div>

                </div>

            </div>


            {{-- Save Response --}}

            <div class="d-flex justify-content-end gap-3 mt-4">

                <a
                    href="{{ route('admin.inquiries.show', $inquiry) }}"
                    class="btn btn-outline-light d-inline-flex align-items-center">

                    <i class="bi bi-eye me-2"></i>
                    View Inquiry

                </a>


                <button
                    type="submit"
                    class="btn btn-primary">

                    <i class="bi bi-send me-2"></i>
                    Save Response

                </button>

            </div>

        </form>

    </div>



    {{-- ========================================================== --}}
    {{-- AI LEAD INTELLIGENCE --}}
    {{-- ========================================================== --}}

    <div class="feature-card mb-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

            <div>

                <div class="eyebrow">
                    AI Lead Intelligence
                </div>

                <h2 class="mb-1">
                    AI Analysis
                </h2>

                <p class="text-secondary mb-0">
                    AI-generated qualification and sales intelligence.
                </p>

            </div>


            @if($inquiry->ai_processed_at)

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


        @php

            $score = min(
                max((int) ($inquiry->lead_score ?? 0), 0),
                100
            );


            $temperature =
                strtoupper($inquiry->lead_temperature ?? 'UNKNOWN');


            $scoreLabel = match(true) {

                $score >= 80
                    => 'Very High',

                $score >= 60
                    => 'High',

                $score >= 40
                    => 'Moderate',

                default
                    => 'Low',

            };


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



        {{-- ====================================================== --}}
        {{-- AI KPI Cards --}}
        {{-- ====================================================== --}}

        <div class="row g-3">

            {{-- Lead Score --}}

            <div class="col-xl-3 col-md-6">

                <div class="feature-card h-100">

                    <div class="text-secondary small mb-2">
                        Lead Score
                    </div>

                    <div class="d-flex align-items-end gap-2">

                        <span class="display-6 fw-bold">
                            {{ $score }}
                        </span>

                        <span class="text-secondary mb-2">
                            / 100
                        </span>

                    </div>

                    <div
                        class="progress mt-3"
                        style="height:8px;">

                        <div
                            class="progress-bar"
                            role="progressbar"
                            style="width:{{ $score }}%;">

                        </div>

                    </div>

                    <div class="small text-secondary mt-2">

                        {{ $scoreLabel }} potential

                    </div>

                </div>

            </div>


            {{-- Temperature --}}

            <div class="col-xl-3 col-md-6">

                <div class="feature-card h-100">

                    <div class="text-secondary small mb-2">
                        Lead Temperature
                    </div>

                    <div class="d-flex align-items-center gap-3">

                        <i
                            class="bi {{ $temperatureIcon }}"
                            style="font-size:2rem;">
                        </i>

                        <span
                            class="badge {{ $temperatureClass }} px-3 py-2">

                            {{ $temperature }}

                        </span>

                    </div>

                </div>

            </div>


            {{-- Timeline --}}

            <div class="col-xl-3 col-md-6">

                <div class="feature-card h-100">

                    <div class="text-secondary small mb-2">
                        Expected Timeline
                    </div>

                    <div class="fw-semibold">

                        {{ $inquiry->timeline ?: 'Not specified' }}

                    </div>

                </div>

            </div>


            {{-- Budget --}}

            <div class="col-xl-3 col-md-6">

                <div class="feature-card h-100">

                    <div class="text-secondary small mb-2">
                        Budget Range
                    </div>

                    <div class="fw-semibold">

                        {{ $inquiry->budget_range ?: 'Not specified' }}

                    </div>

                </div>

            </div>

        </div>



        {{-- ====================================================== --}}
        {{-- AI Profile --}}
        {{-- ====================================================== --}}

        <div class="row g-3 mt-1">

            {{-- Service Interest --}}

            <div class="col-lg-4">

                <div class="feature-card h-100">

                    <div class="text-secondary small mb-2">
                        Service Interest
                    </div>

                    <div class="fw-semibold">

                        {{ $inquiry->service_interest ?: 'Not specified' }}

                    </div>

                </div>

            </div>


            {{-- AI Processed At --}}

            <div class="col-lg-4">

                <div class="feature-card h-100">

                    <div class="text-secondary small mb-2">
                        AI Processed
                    </div>

                    <div class="fw-semibold">

                        @if($inquiry->ai_processed_at)

                            {{ $inquiry->ai_processed_at->format('d M Y, h:i A') }}

                        @else

                            Not processed

                        @endif

                    </div>

                </div>

            </div>


            {{-- Follow-up --}}

            <div class="col-lg-4">

                <div class="feature-card h-100">

                    <div class="text-secondary small mb-2">
                        Next Follow-up
                    </div>

                    <div class="fw-semibold">

                        @if($inquiry->follow_up_date)

                            {{ $inquiry->follow_up_date->format('d M Y') }}

                        @else

                            Not scheduled

                        @endif

                    </div>

                </div>

            </div>

        </div>



        {{-- ====================================================== --}}
        {{-- AI Summary & Recommendation --}}
        {{-- ====================================================== --}}

        <div class="row g-3 mt-1">

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

                        {{ $inquiry->ai_summary ?: 'AI summary is not available.' }}

                    </div>

                </div>

            </div>


            <div class="col-lg-5">

                <div class="feature-card h-100">

                    <div class="d-flex align-items-center gap-2 mb-3">

                        <i class="bi bi-lightbulb text-warning"></i>

                        <h5 class="mb-0">
                            AI Recommendation
                        </h5>

                    </div>


                    <div
                        class="text-secondary"
                        style="
                            line-height:1.7;
                            white-space:pre-wrap;
                        ">

                        {{ $inquiry->ai_recommendation ?: 'No recommendation is available.' }}

                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- ========================================================== --}}
    {{-- LEAD MANAGEMENT --}}
    {{-- ========================================================== --}}

    <div class="feature-card mb-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

            <div>

                <div class="eyebrow">
                    Lead Management
                </div>

                <h2 class="mb-1">
                    Qualification & Follow-up
                </h2>

                <p class="text-secondary mb-0">
                    Manage lead status, follow-up and contact activity.
                </p>

            </div>

        </div>


        <div class="row g-3">

            {{-- Lead Status --}}

            <div class="col-lg-4">

                <div class="feature-card h-100">

                    <form
                        method="POST"
                        action="{{ route('admin.inquiries.lead-status', $inquiry) }}">

                        @csrf

                        <label class="form-label">
                            Lead Status
                        </label>

                        <select
                            name="lead_status"
                            class="form-select mb-3">

                            @foreach([
                                'New',
                                'Contacted',
                                'Qualified',
                                'Converted',
                                'Lost'
                            ] as $option)

                                <option
                                    value="{{ $option }}"
                                    @selected(
                                        ($inquiry->lead_status ?? 'New') === $option
                                    )>

                                    {{ $option }}

                                </option>

                            @endforeach

                        </select>


                        <button
                            type="submit"
                            class="btn btn-primary w-100">

                            <i class="bi bi-check2-circle me-2"></i>

                            Update Lead Status

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


                        <label class="form-label">
                            Follow-up Date
                        </label>

                        <input
                            type="date"
                            name="follow_up_date"
                            class="form-control mb-3"
                            value="{{ old(
                                'follow_up_date',
                                optional($inquiry->follow_up_date)->format('Y-m-d')
                            ) }}">


                        <label class="form-label">
                            Follow-up Notes
                        </label>

                        <textarea
                            name="follow_up_notes"
                            rows="3"
                            class="form-control mb-3"
                            placeholder="Add follow-up notes...">{{ old(
                                'follow_up_notes',
                                $inquiry->follow_up_notes
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


                    @if($inquiry->last_contacted_at)

                        <div class="fw-semibold mb-1">
                            Last Contacted
                        </div>

                        <div class="text-secondary mb-3">

                            {{ $inquiry->last_contacted_at->format('d M Y, h:i A') }}

                        </div>

                    @else

                        <div class="text-secondary mb-3">

                            This lead has not been contacted yet.

                        </div>

                    @endif


                    <form
                        method="POST"
                        action="{{ route('admin.inquiries.mark-contacted', $inquiry) }}"
                        onsubmit="return confirm('Mark this inquiry as contacted?')">

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



    {{-- ========================================================== --}}
    {{-- FOOTER ACTIONS --}}
    {{-- ========================================================== --}}

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <a
            href="{{ route('admin.inquiries.show', $inquiry) }}"
            class="btn btn-outline-light">

            <i class="bi bi-eye me-2"></i>

            View Full Inquiry

        </a>


        <div class="d-flex gap-2">

            <form class="d-flex justify-content-end" method="POST"
                action="{{ route('admin.inquiries.destroy', $inquiry) }}"
                onsubmit="return confirm('Delete this inquiry permanently?')">

                @csrf

                @method('DELETE')

                <button
                    type="submit"
                    class="btn btn-outline-danger d-inline-flex align-items-center">

                    <i class="bi bi-trash me-2"></i>

                    Delete Inquiry

                </button>

            </form>


            <button
                type="submit"
                form="response-form"
                class="btn btn-primary">

                <i class="bi bi-send me-2"></i>

                Save Response

            </button>

        </div>

    </div>
</section>

@endsection
