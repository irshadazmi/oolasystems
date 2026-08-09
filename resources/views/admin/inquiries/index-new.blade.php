@extends('layouts.app')

@section('title', 'Manage Inquiries | Oola Systems')

@section('content')

<section class="section-block">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-5">

        <div>

            <div class="eyebrow">
                Administration
            </div>

            <h1 class="page-title text-start mb-2">
                Inquiry Management
            </h1>

            <p class="page-subtitle text-start ms-0">
                Review inquiries, qualify leads and monitor AI-generated lead intelligence.
            </p>

        </div>

        <div>

            <a href="{{ route('admin.dashboard') }}"
               class="btn btn-outline-light btn-lg">

                <i class="bi bi-arrow-left"></i>
                Dashboard

            </a>

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- Statistics --}}
    {{-- ====================================================== --}}

    <div class="row g-4 mb-5">

        <div class="col-lg-3 col-md-6">

            <div class="feature-card text-center">

                <i class="bi bi-chat-square-text fs-2 text-primary"></i>

                <h2 class="mt-3">
                    {{ $inquiries->total() }}
                </h2>

                <p>
                    Total Inquiries
                </p>

            </div>

        </div>


        <div class="col-lg-3 col-md-6">

            <div class="feature-card text-center">

                <i class="bi bi-fire fs-2 text-danger"></i>

                <h2 class="mt-3">
                    {{ $hotLeads }}
                </h2>

                <p>
                    Hot Leads
                </p>

            </div>

        </div>


        <div class="col-lg-3 col-md-6">

            <div class="feature-card text-center">

                <i class="bi bi-thermometer-half fs-2 text-warning"></i>

                <h2 class="mt-3">
                    {{ $warmLeads }}
                </h2>

                <p>
                    Warm Leads
                </p>

            </div>

        </div>


        <div class="col-lg-3 col-md-6">

            <div class="feature-card text-center">

                <i class="bi bi-person-check fs-2 text-success"></i>

                <h2 class="mt-3">
                    {{ $qualifiedLeads }}
                </h2>

                <p>
                    Qualified Leads
                </p>

            </div>

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- Search & Filters --}}
    {{-- ====================================================== --}}

    <div class="feature-card mb-4">

        <form method="GET">

            <div class="row g-3 align-items-end">

                {{-- Search --}}

                <div class="col-lg-4">

                    <label class="form-label">
                        Search
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Name, Email or Project Type">

                </div>


                {{-- Inquiry Status --}}

                <div class="col-lg-2">

                    <label class="form-label">
                        Status
                    </label>

                    <select class="form-select" name="status">

                        <option value="">
                            All
                        </option>

                        <option value="New"
                            @selected(request('status') == 'New')}>
                            New
                        </option>

                        <option value="Read"
                            @selected(request('status') == 'Read')}>
                            Read
                        </option>

                        <option value="Replied"
                            @selected(request('status') == 'Replied')}>
                            Replied
                        </option>

                        <option value="Closed"
                            @selected(request('status') == 'Closed')}>
                            Closed
                        </option>

                    </select>

                </div>


                {{-- Lead Temperature --}}

                <div class="col-lg-2">

                    <label class="form-label">
                        Lead Temperature
                    </label>

                    <select class="form-select" name="temperature">

                        <option value="">
                            All
                        </option>

                        <option value="HOT"
                            @selected(request('temperature') == 'HOT')}>
                            HOT
                        </option>

                        <option value="WARM"
                            @selected(request('temperature') == 'WARM')}>
                            WARM
                        </option>

                        <option value="QUALIFIED"
                            @selected(request('temperature') == 'QUALIFIED')}>
                            QUALIFIED
                        </option>

                        <option value="LOW"
                            @selected(request('temperature') == 'LOW')}>
                            LOW
                        </option>

                    </select>

                </div>


                {{-- Minimum Score --}}

                <div class="col-lg-2">

                    <label class="form-label">
                        Min Score
                    </label>

                    <select class="form-select" name="min_score">

                        <option value="">
                            Any
                        </option>

                        <option value="80"
                            @selected(request('min_score') == '80')}>
                            80+
                        </option>

                        <option value="60"
                            @selected(request('min_score') == '60')}>
                            60+
                        </option>

                        <option value="40"
                            @selected(request('min_score') == '40')}>
                            40+
                        </option>

                        <option value="20"
                            @selected(request('min_score') == '20')}>
                            20+
                        </option>

                    </select>

                </div>


                {{-- AI Status --}}

                <div class="col-lg-2">

                    <label class="form-label">
                        AI Status
                    </label>

                    <select class="form-select" name="ai_status">

                        <option value="">
                            All
                        </option>

                        <option value="analyzed"
                            @selected(request('ai_status') == 'analyzed')}>
                            Analyzed
                        </option>

                        <option value="pending"
                            @selected(request('ai_status') == 'pending')}>
                            Pending
                        </option>

                    </select>

                </div>


                {{-- Search Button --}}

                <div class="col-lg-2 d-grid">

                    <button class="btn btn-primary">

                        <i class="bi bi-search"></i>
                        Filter

                    </button>

                </div>

            </div>


            {{-- Clear Filters --}}

            @if(
                request()->filled('search') ||
                request()->filled('status') ||
                request()->filled('temperature') ||
                request()->filled('min_score') ||
                request()->filled('max_score') ||
                request()->filled('ai_status')
            )

                <div class="mt-3">

                    <a href="{{ route('admin.inquiries.index') }}"
                       class="btn btn-sm btn-outline-light">

                        <i class="bi bi-x-circle me-1"></i>
                        Clear Filters

                    </a>

                </div>

            @endif

        </form>

    </div>


    {{-- ====================================================== --}}
    {{-- Search & Filters --}}
    {{-- ====================================================== --}}

    <div class="feature-card mb-4">

        <form method="GET">

            <div class="row g-3 align-items-end">

                {{-- Search --}}

                <div class="col-lg-4">

                    <label class="form-label">
                        Search
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Name, Email or Project Type">

                </div>


                {{-- Inquiry Status --}}

                <div class="col-lg-2">

                    <label class="form-label">
                        Status
                    </label>

                    <select class="form-select" name="status">

                        <option value="">
                            All
                        </option>

                        <option value="New"
                            @selected(request('status') == 'New')>
                            New
                        </option>

                        <option value="Read"
                            @selected(request('status') == 'Read')>
                            Read
                        </option>

                        <option value="Replied"
                            @selected(request('status') == 'Replied')>
                            Replied
                        </option>

                        <option value="Closed"
                            @selected(request('status') == 'Closed')>
                            Closed
                        </option>

                    </select>

                </div>


                {{-- Lead Temperature --}}

                <div class="col-lg-2">

                    <label class="form-label">
                        Lead Temperature
                    </label>

                    <select class="form-select" name="temperature">

                        <option value="">
                            All
                        </option>

                        <option value="HOT"
                            @selected(request('temperature') == 'HOT')>
                            HOT
                        </option>

                        <option value="WARM"
                            @selected(request('temperature') == 'WARM')>
                            WARM
                        </option>

                        <option value="QUALIFIED"
                            @selected(request('temperature') == 'QUALIFIED')>
                            QUALIFIED
                        </option>

                        <option value="LOW"
                            @selected(request('temperature') == 'LOW')>
                            LOW
                        </option>

                    </select>

                </div>


                {{-- Minimum Score --}}

                <div class="col-lg-2">

                    <label class="form-label">
                        Min Score
                    </label>

                    <select class="form-select" name="min_score">

                        <option value="">
                            Any
                        </option>

                        <option value="80"
                            @selected(request('min_score') == '80')>
                            80+
                        </option>

                        <option value="60"
                            @selected(request('min_score') == '60')>
                            60+
                        </option>

                        <option value="40"
                            @selected(request('min_score') == '40')>
                            40+
                        </option>

                        <option value="20"
                            @selected(request('min_score') == '20')>
                            20+
                        </option>

                    </select>

                </div>


                {{-- Lead Priority --}}

                <div class="col-lg-2">

                    <label class="form-label">
                        Lead Priority
                    </label>

                    <select class="form-select" name="lead_sort">

                        <option value="latest"
                            @selected(request('lead_sort', 'latest') == 'latest')>
                            Latest
                        </option>

                        <option value="highest"
                            @selected(request('lead_sort') == 'highest')>
                            Highest Score
                        </option>

                        <option value="lowest"
                            @selected(request('lead_sort') == 'lowest')>
                            Lowest Score
                        </option>

                    </select>

                </div>


                {{-- AI Status --}}

                <div class="col-lg-2">

                    <label class="form-label">
                        AI Status
                    </label>

                    <select class="form-select" name="ai_status">

                        <option value="">
                            All
                        </option>

                        <option value="analyzed"
                            @selected(request('ai_status') == 'analyzed')>
                            Analyzed
                        </option>

                        <option value="pending"
                            @selected(request('ai_status') == 'pending')>
                            Pending
                        </option>

                    </select>

                </div>


                {{-- Filter Button --}}

                <div class="col-lg-2 d-grid">

                    <button class="btn btn-primary">

                        <i class="bi bi-search"></i>
                        Filter

                    </button>

                </div>

            </div>


            {{-- Clear Filters --}}

            @if(
                request()->filled('search') ||
                request()->filled('status') ||
                request()->filled('temperature') ||
                request()->filled('min_score') ||
                request()->filled('max_score') ||
                request()->filled('ai_status') ||
                request('lead_sort') !== null
            )

                <div class="mt-3">

                    <a
                        href="{{ route('admin.inquiries.index') }}"
                        class="btn btn-sm btn-outline-light">

                        <i class="bi bi-x-circle me-1"></i>
                        Clear Filters

                    </a>

                </div>

            @endif

        </form>

    </div>


    {{-- ====================================================== --}}
    {{-- Pagination --}}
    {{-- ====================================================== --}}

    <div class="mt-4 d-flex justify-content-center">

        {{ $inquiries->withQueryString()->links() }}

    </div>

</section>

@endsection
