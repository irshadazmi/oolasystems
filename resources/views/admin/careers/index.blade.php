@extends('layouts.app')

@section('title', 'Career Management | Oola Systems')

@section('content')

<section class="section-block">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-5">

        <div>
            <div class="eyebrow">Administration</div>

            <h1 class="page-title text-start mb-2">
                Career Management
            </h1>

            <p class="page-subtitle text-start ms-0">
                Manage job openings, positions, requirements, and recruitment status.
            </p>
        </div>

        <div class="d-flex gap-2">

            <a href="{{ route('admin.dashboard') }}"
                class="btn btn-outline-light d-inline-flex align-items-center justify-content-center">

                <i class="bi bi-arrow-left me-2"></i>
                Dashboard

            </a>

            <a href="{{ route('admin.careers.create') }}"
                class="btn btn-primary d-inline-flex align-items-center justify-content-center">

                <i class="bi bi-plus-circle me-2"></i>
                Add Career

            </a>

        </div>

    </div>

    {{-- Success Message --}}

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    {{-- Search --}}

    <div class="feature-card mb-4">

        <form method="GET" action="{{ route('admin.careers.index') }}">

            <div class="row g-3 align-items-end">

                <div class="col-lg-5">

                    <label class="form-label">
                        Search
                    </label>

                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        value="{{ request('search') }}"
                        placeholder="Search by job title, department or location">

                </div>

                <div class="col-lg-3">

                    <label class="form-label">
                        Status
                    </label>

                    <select name="status" class="form-select">

                        <option value="">
                            All Statuses
                        </option>

                        <option value="Open" @selected(request('status') === 'Open')>
                            Open
                        </option>

                        <option value="Closed" @selected(request('status') === 'Closed')>
                            Closed
                        </option>

                        <option value="Draft" @selected(request('status') === 'Draft')>
                            Draft
                        </option>

                        <option value="On Hold" @selected(request('status') === 'On Hold')>
                            On Hold
                        </option>

                    </select>

                </div>

                <div class="col-lg-2">

                    <label class="form-label">
                        Employment Type
                    </label>

                    <select name="employment_type" class="form-select">

                        <option value="">
                            All Types
                        </option>

                        <option value="Full-Time" @selected(request('employment_type') === 'Full-Time')>
                            Full-Time
                        </option>

                        <option value="Part-Time" @selected(request('employment_type') === 'Part-Time')>
                            Part-Time
                        </option>

                        <option value="Contract" @selected(request('employment_type') === 'Contract')>
                            Contract
                        </option>

                        <option value="Internship" @selected(request('employment_type') === 'Internship')>
                            Internship
                        </option>

                        <option value="Freelance" @selected(request('employment_type') === 'Freelance')>
                            Freelance
                        </option>

                    </select>

                </div>

                <div class="col-lg-2 d-flex gap-2">

                    <button type="submit"
                        class="btn btn-primary flex-grow-1 d-inline-flex align-items-center justify-content-center">

                        <i class="bi bi-search me-2"></i>
                        Search

                    </button>

                    @if(request()->hasAny(['search', 'status', 'employment_type']))

                        <a href="{{ route('admin.careers.index') }}"
                            class="btn btn-outline-light d-inline-flex align-items-center justify-content-center"
                            title="Clear Filters">

                            <i class="bi bi-x-lg"></i>

                        </a>

                    @endif

                </div>

            </div>

        </form>

    </div>

    {{-- Career Statistics --}}

    <div class="row g-4 mb-4">

        <div class="col-md-6 col-lg-3">

            <div class="feature-card text-center">

                <i class="bi bi-briefcase-fill fs-2 text-primary"></i>

                <h2 class="mt-3">
                    {{ $careers->total() }}
                </h2>

                <p class="mb-0">
                    Total Positions
                </p>

            </div>

        </div>

        <div class="col-md-6 col-lg-3">

            <div class="feature-card text-center">

                <i class="bi bi-megaphone fs-2 text-success"></i>

                <h2 class="mt-3">
                    {{ \App\Models\Career::where('status', 'Open')->count() }}
                </h2>

                <p class="mb-0">
                    Open Positions
                </p>

            </div>

        </div>

        <div class="col-md-6 col-lg-3">

            <div class="feature-card text-center">

                <i class="bi bi-pencil-square fs-2 text-warning"></i>

                <h2 class="mt-3">
                    {{ \App\Models\Career::where('status', 'Draft')->count() }}
                </h2>

                <p class="mb-0">
                    Draft Positions
                </p>

            </div>

        </div>

        <div class="col-md-6 col-lg-3">

            <div class="feature-card text-center">

                <i class="bi bi-pause-circle fs-2 text-info"></i>

                <h2 class="mt-3">
                    {{ \App\Models\Career::where('status', 'On Hold')->count() }}
                </h2>

                <p class="mb-0">
                    On Hold
                </p>

            </div>

        </div>

    </div>

    {{-- Career List --}}

    <div class="feature-card p-0 overflow-hidden">

        <div class="px-4 py-3 border-bottom">

            <h5 class="mb-0">

                <i class="bi bi-list-ul text-primary me-2"></i>

                Career Opportunities

            </h5>

        </div>

        <div class="table-responsive">

            <table class="table table-dark table-hover align-middle mb-0">

                <thead>

                    <tr>

                        <th width="70">
                            #
                        </th>

                        <th>
                            Position
                        </th>

                        <th>
                            Department
                        </th>

                        <th>
                            Location
                        </th>

                        <th>
                            Employment
                        </th>

                        <th>
                            Experience
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Created
                        </th>

                        <th width="150" class="text-center">
                            Actions
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($careers as $career)

                        <tr>

                            <td>
                                #{{ $career->id }}
                            </td>

                            <td>

                                <div class="fw-semibold">
                                    {{ $career->title }}
                                </div>

                                @if($career->description)

                                    <small class="text-secondary">
                                        {{ \Illuminate\Support\Str::limit($career->description, 55) }}
                                    </small>

                                @endif

                            </td>

                            <td>

                                {{ $career->department ?: '—' }}

                            </td>

                            <td>

                                @if($career->location)

                                    <i class="bi bi-geo-alt text-primary me-1"></i>

                                    {{ $career->location }}

                                @else

                                    —

                                @endif

                            </td>

                            <td>

                                @if($career->employment_type)

                                    <span class="badge bg-secondary">
                                        {{ $career->employment_type }}
                                    </span>

                                @else

                                    —

                                @endif

                            </td>

                            <td>

                                {{ $career->experience ?: '—' }}

                            </td>

                            <td>

                                @switch($career->status)

                                    @case('Open')

                                        <span class="badge bg-success">
                                            Open
                                        </span>

                                    @break

                                    @case('Closed')

                                        <span class="badge bg-secondary">
                                            Closed
                                        </span>

                                    @break

                                    @case('Draft')

                                        <span class="badge bg-warning text-dark">
                                            Draft
                                        </span>

                                    @break

                                    @case('On Hold')

                                        <span class="badge bg-info text-dark">
                                            On Hold
                                        </span>

                                    @break

                                    @default

                                        <span class="badge bg-secondary">
                                            {{ $career->status }}
                                        </span>

                                @endswitch

                            </td>

                            <td>

                                {{ $career->created_at->format('d M Y') }}

                                <br>

                                <small class="text-secondary">

                                    {{ $career->created_at->format('h:i A') }}

                                </small>

                            </td>

                            <td>

                                <div class="d-flex justify-content-center gap-2">

                                    <a
                                        href="{{ route('admin.careers.show', $career) }}"
                                        class="btn btn-sm btn-outline-light"
                                        title="View">

                                        <i class="bi bi-eye"></i>

                                    </a>

                                    <a
                                        href="{{ route('admin.careers.edit', $career) }}"
                                        class="btn btn-sm btn-outline-warning"
                                        title="Edit">

                                        <i class="bi bi-pencil"></i>

                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('admin.careers.destroy', $career) }}"
                                        onsubmit="return confirm('Delete this career position permanently?')">

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            title="Delete">

                                            <i class="bi bi-trash"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="9" class="text-center py-5">

                                <i class="bi bi-briefcase display-5 text-secondary"></i>

                                <h5 class="mt-3">
                                    No Career Positions Found
                                </h5>

                                <p class="text-secondary mb-3">
                                    No career positions match the current search criteria.
                                </p>

                                <a
                                    href="{{ route('admin.careers.create') }}"
                                    class="btn btn-primary">

                                    <i class="bi bi-plus-circle me-2"></i>
                                    Add Career Position

                                </a>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    {{-- Pagination --}}

    <div class="mt-4 d-flex justify-content-center">

        {{ $careers->withQueryString()->links() }}

    </div>

</section>

@endsection
