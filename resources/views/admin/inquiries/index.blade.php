@extends('layouts.app')

@section('title', 'Manage Inquiries | Oola Systems')

@section('content')

    <section class="section-block">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-5">
            <div>
                <div class="eyebrow">Administration</div>
                <h1 class="page-title text-start mb-2">Inquiry Management</h1>
                <p class="page-subtitle text-start ms-0">
                    Review and manage project inquiries received through the Oola Systems website.
                </p>
            </div>

            <div>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light btn-lg">
                    <i class="bi bi-arrow-left"></i>
                    Dashboard
                </a>
            </div>
        </div>

        {{-- Statistics --}}

        <div class="row g-4 mb-5">

            <div class="col-lg-3 col-md-6">
                <div class="feature-card text-center">
                    <i class="bi bi-chat-square-text fs-2 text-primary"></i>
                    <h2 class="mt-3">{{ $inquiries->total() }}</h2>
                    <p>Total Inquiries</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="feature-card text-center">
                    <i class="bi bi-chat-left fs-2 text-warning"></i>
                    <h2 class="mt-3">{{ \App\Models\Inquiry::where('status', 'New')->count() }}</h2>
                    <p>New</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="feature-card text-center">
                    <i class="bi bi-chat-left-text fs-2 text-info"></i>
                    <h2 class="mt-3">{{ \App\Models\Inquiry::where('status', 'Read')->count() }}</h2>
                    <p>Read</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="feature-card text-center">
                    <i class="bi bi-check-circle fs-2 text-success"></i>
                    <h2 class="mt-3">{{ \App\Models\Inquiry::where('status', 'Closed')->count() }}</h2>
                    <p>Closed</p>
                </div>
            </div>

        </div>

        {{-- Search --}}

        <div class="feature-card mb-4">
            <form method="GET">
                <div class="row g-3 align-items-end">

                    <div class="col-lg-6">
                        <label class="form-label">Search</label>
                        <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                            placeholder="Name, Email or Project Type">
                    </div>

                    <div class="col-lg-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option value="">All</option>
                            <option value="New" @selected(request('status') == 'New')>New</option>
                            <option value="Read" @selected(request('status') == 'Read')>Read</option>
                            <option value="Replied" @selected(request('status') == 'Replied')>Replied</option>
                            <option value="Closed" @selected(request('status') == 'Closed')>Closed</option>
                        </select>
                    </div>

                    <div class="col-lg-3 d-grid">
                        <button class="btn btn-primary">
                            <i class="bi bi-search"></i>
                            Search
                        </button>
                    </div>

                </div>
            </form>
        </div>

        {{-- Inquiry Table --}}

        <div class="feature-card p-0 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0">

                    <thead>
                        <tr>
                            <th width="70">ID</th>
                            <th>Inquiry</th>
                            <th>Project Type</th>
                            <th>Message</th>
                            <th width="120">Status</th>
                            <th width="140">Received</th>
                            <th width="170" class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($inquiries as $inquiry)
                            <tr>

                                <td>#{{ $inquiry->id }}</td>

                                <td>
                                    <div class="fw-semibold">{{ $inquiry->name }}</div>
                                    <small class="text-secondary">{{ $inquiry->email }}</small>
                                </td>

                                <td>{{ $inquiry->project_type ?: '—' }}</td>

                                <td>
                                    <small class="text-secondary">
                                        {{ \Illuminate\Support\Str::limit($inquiry->message, 80) }}
                                    </small>
                                </td>

                                <td>

                                    @switch($inquiry->status)
                                        @case('New')
                                            <span class="badge bg-primary">New</span>
                                        @break

                                        @case('Read')
                                            <span class="badge bg-warning text-dark">Read</span>
                                        @break

                                        @case('Replied')
                                            <span class="badge bg-info text-dark">Replied</span>
                                        @break

                                        @case('Closed')
                                            <span class="badge bg-success">Closed</span>
                                        @break

                                        @default
                                            <span class="badge bg-secondary">{{ $inquiry->status }}</span>
                                    @endswitch

                                </td>

                                <td>
                                    {{ $inquiry->created_at->format('d M Y') }}
                                    <br>
                                    <small class="text-secondary">{{ $inquiry->created_at->format('h:i A') }}</small>
                                </td>

                                <td>

                                    <div class="d-flex justify-content-center gap-2">

                                        <a href="{{ route('admin.inquiries.show', $inquiry) }}"
                                            class="btn btn-sm btn-outline-light" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="{{ route('admin.inquiries.edit', $inquiry) }}"
                                            class="btn btn-sm btn-outline-warning"
                                            title="Edit">

                                                <i class="bi bi-pencil"></i>

                                        </a>

                                        <form method="POST" action="{{ route('admin.inquiries.destroy', $inquiry) }}"
                                            onsubmit="return confirm('Delete this inquiry permanently?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                            @empty

                                <tr>

                                    <td colspan="7" class="text-center py-5">

                                        <i class="bi bi-chat-left-text display-5 text-secondary"></i>

                                        <h5 class="mt-3">

                                            No Inquiries Found

                                        </h5>

                                        <p class="text-secondary mb-0">

                                            No project inquiries match the current search criteria.

                                        </p>

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

            <div class="mt-4 d-flex justify-content-center">

                {{ $inquiries->withQueryString()->links() }}

            </div>
        </div>

    </section>

@endsection
@extends('layouts.app')

@section('title', 'Manage Inquiries | Oola Systems')

@section('content')

<section class="section-block">

    {{-- ====================================================== --}}
    {{-- Page Header --}}
    {{-- ====================================================== --}}

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

                <i class="bi bi-arrow-left me-1"></i>
                Dashboard

            </a>

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- Statistics --}}
    {{-- ====================================================== --}}

    <div class="row g-4 mb-5">

        {{-- Total Inquiries --}}

        <div class="col-lg-3 col-md-6">

            <div class="feature-card text-center h-100">

                <i class="bi bi-chat-square-text fs-2 text-primary"></i>

                <h2 class="mt-3">
                    {{ $inquiries->total() }}
                </h2>

                <p class="mb-0">
                    Total Inquiries
                </p>

            </div>

        </div>


        {{-- Hot Leads --}}

        <div class="col-lg-3 col-md-6">

            <div class="feature-card text-center h-100">

                <i class="bi bi-fire fs-2 text-danger"></i>

                <h2 class="mt-3">
                    {{ $hotLeads ?? 0 }}
                </h2>

                <p class="mb-0">
                    Hot Leads
                </p>

            </div>

        </div>


        {{-- Warm Leads --}}

        <div class="col-lg-3 col-md-6">

            <div class="feature-card text-center h-100">

                <i class="bi bi-thermometer-half fs-2 text-warning"></i>

                <h2 class="mt-3">
                    {{ $warmLeads ?? 0 }}
                </h2>

                <p class="mb-0">
                    Warm Leads
                </p>

            </div>

        </div>


        {{-- Qualified Leads --}}

        <div class="col-lg-3 col-md-6">

            <div class="feature-card text-center h-100">

                <i class="bi bi-person-check fs-2 text-success"></i>

                <h2 class="mt-3">
                    {{ $qualifiedLeads ?? 0 }}
                </h2>

                <p class="mb-0">
                    Qualified Leads
                </p>

            </div>

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- Search & Filters --}}
    {{-- ====================================================== --}}

    <div class="feature-card mb-4">

        <form method="GET"
              action="{{ route('admin.inquiries.index') }}">

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

                    <select
                        class="form-select"
                        name="status">

                        <option value="">
                            All
                        </option>

                        <option value="New"
                            @selected(request('status') === 'New')}>
                            New
                        </option>

                        <option value="Read"
                            @selected(request('status') === 'Read')}>
                            Read
                        </option>

                        <option value="Replied"
                            @selected(request('status') === 'Replied')}>
                            Replied
                        </option>

                        <option value="Closed"
                            @selected(request('status') === 'Closed')}>
                            Closed
                        </option>

                    </select>

                </div>


                {{-- Lead Temperature --}}

                <div class="col-lg-2">

                    <label class="form-label">
                        Lead Temperature
                    </label>

                    <select
                        class="form-select"
                        name="temperature">

                        <option value="">
                            All
                        </option>

                        <option value="HOT"
                            @selected(request('temperature') === 'HOT')}>
                            HOT
                        </option>

                        <option value="WARM"
                            @selected(request('temperature') === 'WARM')}>
                            WARM
                        </option>

                        <option value="QUALIFIED"
                            @selected(request('temperature') === 'QUALIFIED')}>
                            QUALIFIED
                        </option>

                        <option value="LOW"
                            @selected(request('temperature') === 'LOW')}>
                            LOW
                        </option>

                    </select>

                </div>


                {{-- Minimum Score --}}

                <div class="col-lg-2">

                    <label class="form-label">
                        Min Score
                    </label>

                    <select
                        class="form-select"
                        name="min_score">

                        <option value="">
                            Any
                        </option>

                        <option value="80"
                            @selected(request('min_score') === '80')}>
                            80+
                        </option>

                        <option value="60"
                            @selected(request('min_score') === '60')}>
                            60+
                        </option>

                        <option value="40"
                            @selected(request('min_score') === '40')}>
                            40+
                        </option>

                        <option value="20"
                            @selected(request('min_score') === '20')}>
                            20+
                        </option>

                    </select>

                </div>


                {{-- Lead Priority --}}

                <div class="col-lg-2">

                    <label class="form-label">
                        Lead Priority
                    </label>

                    <select
                        class="form-select"
                        name="priority">

                        <option value="">
                            Latest
                        </option>

                        <option value="highest_score"
                            @selected(request('priority') === 'highest_score')}>
                            Highest Score
                        </option>

                        <option value="hot"
                            @selected(request('priority') === 'hot')}>
                            Hot Leads
                        </option>

                        <option value="warm"
                            @selected(request('priority') === 'warm')}>
                            Warm Leads
                        </option>

                        <option value="oldest"
                            @selected(request('priority') === 'oldest')}>
                            Oldest
                        </option>

                    </select>

                </div>


                {{-- AI Status --}}

                <div class="col-lg-2">

                    <label class="form-label">
                        AI Status
                    </label>

                    <select
                        class="form-select"
                        name="ai_status">

                        <option value="">
                            All
                        </option>

                        <option value="analyzed"
                            @selected(request('ai_status') === 'analyzed')}>
                            Analyzed
                        </option>

                        <option value="pending"
                            @selected(request('ai_status') === 'pending')}>
                            Pending
                        </option>

                    </select>

                </div>


                {{-- Filter Button --}}

                <div class="col-lg-2 d-grid">

                    <button
                        type="submit"
                        class="btn btn-primary">

                        <i class="bi bi-search me-1"></i>
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
                request()->filled('priority') ||
                request()->filled('ai_status')
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
    {{-- Inquiry Table --}}
    {{-- ====================================================== --}}

    <div class="feature-card p-0 overflow-hidden">

        <div class="table-responsive">

            <table class="table table-dark table-hover align-middle mb-0">

                <thead>

                    <tr>

                        <th width="60">
                            ID
                        </th>

                        <th>
                            Inquiry
                        </th>

                        <th>
                            Project Type
                        </th>

                        <th>
                            Message
                        </th>

                        <th width="100">
                            Lead Score
                        </th>

                        <th width="120">
                            Temperature
                        </th>

                        <th width="110">
                            AI Status
                        </th>

                        <th width="120">
                            Lead Status
                        </th>

                        <th width="120">
                            Status
                        </th>

                        <th width="140">
                            Received
                        </th>

                        <th width="180"
                            class="text-center">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($inquiries as $inquiry)

                        <tr>

                            {{-- ID --}}

                            <td>
                                #{{ $inquiry->id }}
                            </td>


                            {{-- Inquiry --}}

                            <td>

                                <div class="fw-semibold">
                                    {{ $inquiry->name }}
                                </div>

                                <small class="text-secondary">
                                    {{ $inquiry->email }}
                                </small>

                            </td>


                            {{-- Project Type --}}

                            <td>

                                {{ $inquiry->project_type ?: '—' }}

                            </td>


                            {{-- Message --}}

                            <td>

                                <small class="text-secondary">

                                    {{ \Illuminate\Support\Str::limit(
                                        $inquiry->message,
                                        70
                                    ) }}

                                </small>

                            </td>


                            {{-- Lead Score --}}

                            <td>

                                @if($inquiry->lead_score !== null)

                                    <span class="fw-semibold">
                                        {{ $inquiry->lead_score }}/100
                                    </span>

                                @else

                                    <span class="text-secondary">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- Temperature --}}

                            <td>

                                @if($inquiry->lead_temperature)

                                    @php

                                        $temperatureClass = match(
                                            strtoupper(
                                                $inquiry->lead_temperature
                                            )
                                        ) {

                                            'HOT'
                                                => 'bg-danger',

                                            'WARM'
                                                => 'bg-warning text-dark',

                                            'QUALIFIED'
                                                => 'bg-success',

                                            default
                                                => 'bg-secondary',

                                        };

                                    @endphp

                                    <span
                                        class="badge {{ $temperatureClass }}">

                                        {{ strtoupper(
                                            $inquiry->lead_temperature
                                        ) }}

                                    </span>

                                @else

                                    <span class="text-secondary">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- AI Status --}}

                            <td>

                                @if($inquiry->ai_processed_at)

                                    <span
                                        class="badge bg-success"
                                        title="AI analysis completed">

                                        <i class="bi bi-check-circle me-1"></i>
                                        Ready

                                    </span>

                                @else

                                    <span
                                        class="badge bg-warning text-dark"
                                        title="AI analysis pending">

                                        <i class="bi bi-clock me-1"></i>
                                        Pending

                                    </span>

                                @endif

                            </td>


                            {{-- Lead Status --}}

                            <td>

                                @if($inquiry->lead_status)

                                    @php

                                        $leadStatusClass = match(
                                            strtolower(
                                                $inquiry->lead_status
                                            )
                                        ) {

                                            'new'
                                                => 'bg-primary',

                                            'contacted'
                                                => 'bg-info text-dark',

                                            'qualified'
                                                => 'bg-success',

                                            'converted'
                                                => 'bg-success',

                                            'lost'
                                                => 'bg-danger',

                                            default
                                                => 'bg-secondary',

                                        };

                                    @endphp

                                    <span
                                        class="badge {{ $leadStatusClass }}">

                                        {{ $inquiry->lead_status }}

                                    </span>

                                @else

                                    <span class="text-secondary">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- Inquiry Status --}}

                            <td>

                                @switch(strtolower($inquiry->status))

                                    @case('new')

                                        <span class="badge bg-primary">
                                            New
                                        </span>

                                    @break

                                    @case('read')

                                        <span class="badge bg-warning text-dark">
                                            Read
                                        </span>

                                    @break

                                    @case('replied')

                                        <span class="badge bg-info text-dark">
                                            Replied
                                        </span>

                                    @break

                                    @case('closed')

                                        <span class="badge bg-success">
                                            Closed
                                        </span>

                                    @break

                                    @default

                                        <span class="badge bg-secondary">
                                            {{ $inquiry->status }}
                                        </span>

                                @endswitch

                            </td>


                            {{-- Received --}}

                            <td>

                                {{ $inquiry->created_at->format('d M Y') }}

                                <br>

                                <small class="text-secondary">
                                    {{ $inquiry->created_at->format('h:i A') }}
                                </small>

                            </td>


                            {{-- Actions --}}

                            <td>

                                <div
                                    class="d-flex justify-content-center align-items-center gap-2">

                                    {{-- View --}}

                                    <a
                                        href="{{ route(
                                            'admin.inquiries.show',
                                            $inquiry
                                        ) }}"
                                        class="btn btn-sm btn-outline-light"
                                        title="View Inquiry"
                                        aria-label="View Inquiry">

                                        <i class="bi bi-eye"></i>

                                    </a>


                                    {{-- Edit --}}

                                    <a
                                        href="{{ route(
                                            'admin.inquiries.edit',
                                            $inquiry
                                        ) }}"
                                        class="btn btn-sm btn-outline-warning"
                                        title="Edit Inquiry"
                                        aria-label="Edit Inquiry">

                                        <i class="bi bi-pencil"></i>

                                    </a>


                                    {{-- Delete --}}

                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'admin.inquiries.destroy',
                                            $inquiry
                                        ) }}"
                                        onsubmit="return confirm(
                                            'Delete this inquiry permanently?'
                                        )">

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            title="Delete Inquiry"
                                            aria-label="Delete Inquiry">

                                            <i class="bi bi-trash"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="11"
                                class="text-center py-5">

                                <i
                                    class="bi bi-chat-left-text display-5 text-secondary">
                                </i>

                                <h5 class="mt-3">
                                    No Inquiries Found
                                </h5>

                                <p class="text-secondary mb-0">

                                    No project inquiries match the
                                    current search criteria.

                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- Pagination --}}
    {{-- ====================================================== --}}

    <div class="mt-4 d-flex justify-content-center">

        {{ $inquiries->withQueryString()->links() }}

    </div>

</section>

@endsection
