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
