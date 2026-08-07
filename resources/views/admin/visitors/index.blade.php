@extends('layouts.app')

@section('title', 'Visitor Analytics | Oola Systems')

@section('content')

    <section class="section-block">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-5">

            <div>
                <div class="eyebrow">Administration</div>
                <h1 class="page-title text-start mb-2">Visitor Analytics</h1>
                <p class="page-subtitle text-start ms-0">
                    Monitor website traffic, visitor activity and page visits.
                </p>
            </div>

            <div>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light btn-lg">
                    <i class="bi bi-arrow-left"></i>
                    Dashboard
                </a>
            </div>

        </div>

        {{-- Analytics Cards --}}

        <div class="row g-4 mb-5">

            <div class="col-lg-3 col-md-6">
                <div class="feature-card text-center">
                    <i class="bi bi-people-fill fs-2 text-primary"></i>
                    <h2 class="mt-3">{{ $visitors->total() }}</h2>
                    <p>Total Visits</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="feature-card text-center">
                    <i class="bi bi-person-check fs-2 text-info"></i>
                    <h2 class="mt-3">{{ \App\Models\Visitor::distinct('ip')->count('ip') }}</h2>
                    <p>Unique Visitors</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="feature-card text-center">
                    <i class="bi bi-calendar-day fs-2 text-warning"></i>
                    <h2 class="mt-3">{{ \App\Models\Visitor::whereDate('created_at', today())->count() }}</h2>
                    <p>Today's Visits</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="feature-card text-center">
                    <i class="bi bi-file-earmark-bar-graph fs-2 text-success"></i>
                    <h2 class="mt-3">{{ \App\Models\Visitor::distinct('page')->count('page') }}</h2>
                    <p>Pages Visited</p>
                </div>
            </div>

        </div>

        {{-- Filters --}}

        <div class="feature-card mb-4">

            <form method="GET">

                <div class="row g-3 align-items-end">

                    <div class="col-lg-10">

                        <label class="form-label">

                            Search Visitor Activity

                        </label>

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            value="{{ request('search') }}"
                            placeholder="Search by IP address, visited page or browser">

                    </div>

                    <div class="col-lg-2 d-grid">

                        <button class="btn btn-primary">

                            <i class="bi bi-search me-2"></i>

                            Search

                        </button>

                    </div>

                </div>

            </form>

        </div>

        {{-- Visitor Activity --}}

        <div class="feature-card p-0 overflow-hidden">

            <div class="px-4 py-3 border-bottom">

                <h5 class="mb-0">

                    <i class="bi bi-activity text-primary"></i>

                    Recent Visitor Activity

                </h5>

            </div>

            <div class="table-responsive">

                <table class="table table-dark table-hover align-middle mb-0">

                    <thead>

                        <tr>
                            <th width="70">#</th>
                            <th width="170">Visitor</th>
                            <th>Visited Page</th>
                            <th width="250">Browser</th>
                            <th width="150">Date</th>
                            <th width="90" class="text-center">View</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($visitors as $visitor)
                            <tr>

                                <td>#{{ $visitor->id }}</td>

                                <td>

                                    <div class="fw-semibold">

                                        {{ $visitor->ip }}

                                    </div>

                                    <small class="text-secondary">

                                        Visitor

                                    </small>

                                </td>

                                <td>

                                    <span class="badge bg-secondary">

                                        {{ $visitor->page }}

                                    </span>

                                </td>

                                <td>

                                    <small class="text-secondary">

                                        {{ \Illuminate\Support\Str::limit($visitor->user_agent, 60) }}

                                    </small>

                                </td>
                                <td>

                                    {{ $visitor->created_at->format('d M Y') }}

                                    <br>

                                    <small class="text-secondary">

                                        {{ $visitor->created_at->format('h:i A') }}

                                    </small>

                                </td>

                                <td>

                                    <div class="d-flex justify-content-center">

                                        <a href="{{ route('admin.visitors.show', $visitor) }}"
                                            class="btn btn-sm btn-outline-light" title="View Details">

                                            <i class="bi bi-eye"></i>

                                        </a>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="text-center py-5">

                                    <i class="bi bi-graph-up-arrow display-4 text-secondary"></i>

                                    <h4 class="mt-3">

                                        No Visitor Activity Found

                                    </h4>

                                    <p class="text-secondary mb-0">

                                        No visitor records are available for the selected criteria.

                                    </p>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-4">

            <div class="text-secondary">

                Showing

                <strong>{{ $visitors->firstItem() ?? 0 }}</strong>

                to

                <strong>{{ $visitors->lastItem() ?? 0 }}</strong>

                of

                <strong>{{ $visitors->total() }}</strong>

                visits

            </div>

            <div>

                {{ $visitors->withQueryString()->links('pagination::bootstrap-5') }}

            </div>

        </div>

    </section>

@endsection
