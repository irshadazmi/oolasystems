@extends('layouts.app')

@section('title', 'User Management | Oola Systems')

@section('content')

<section class="section-block">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-5">

        <div>
            <div class="eyebrow">Administration</div>
            <h1 class="page-title text-start mb-2">User Management</h1>
            <p class="page-subtitle text-start ms-0">
                Manage administrator accounts and portal access.
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
                <i class="bi bi-people-fill fs-2 text-primary"></i>
                <h2 class="mt-3">{{ $users->total() }}</h2>
                <p>Total Users</p>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="feature-card text-center">
                <i class="bi bi-person-check fs-2 text-success"></i>
                <h2 class="mt-3">{{ \App\Models\User::count() }}</h2>
                <p>Active Users</p>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="feature-card text-center">
                <i class="bi bi-envelope-check fs-2 text-info"></i>
                <h2 class="mt-3">{{ \App\Models\User::whereNotNull('email_verified_at')->count() }}</h2>
                <p>Verified</p>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="feature-card text-center">
                <i class="bi bi-person-plus fs-2 text-warning"></i>
                <h2 class="mt-3">{{ \App\Models\User::whereDate('created_at', today())->count() }}</h2>
                <p>Added Today</p>
            </div>
        </div>

    </div>

    {{-- Add User --}}

    <div class="feature-card mb-5">

        <div class="d-flex align-items-center mb-4">

            <i class="bi bi-person-plus-fill fs-3 text-primary me-3"></i>

            <div>

                <h4 class="mb-1">Add New User</h4>

                <small class="text-secondary">
                    Create a new administrator account.
                </small>

            </div>

        </div>

        <form method="POST" action="{{ route('admin.users.store') }}">

            @csrf

            <div class="row g-4">

                <div class="col-md-4">

                    <label class="form-label">Full Name</label>

                    <input
                        type="text"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}"
                        required>

                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                </div>

                <div class="col-md-4">

                    <label class="form-label">Email Address</label>

                    <input
                        type="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        required>

                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                </div>

                <div class="col-md-4">

                    <label class="form-label">Password</label>

                    <input
                        type="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        required>

                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                </div>

                <div class="col-md-4">

                    <label class="form-label">Confirm Password</label>

                    <input
                        type="password"
                        name="password_confirmation"
                        class="form-control"
                        required>

                </div>

                <div class="col-md-8 d-flex align-items-end justify-content-end">

                    <button class="btn btn-primary">
                        <i class="bi bi-person-plus"></i>
                        Create User
                    </button>

                </div>

            </div>

        </form>

    </div>

    {{-- Search --}}

    <div class="feature-card mb-4">

        <form method="GET">

            <div class="row g-3 align-items-end">

                <div class="col-lg-9">

                    <label class="form-label">Search Users</label>

                    <input
                        type="text"
                        class="form-control"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search by name or email">

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

    {{-- Users Table --}}

    <div class="feature-card p-0 overflow-hidden">

        <div class="table-responsive">

            <table class="table table-dark table-hover align-middle mb-0">

                <thead>

                    <tr>

                        <th width="70">#</th>

                        <th>User</th>

                        <th>Email</th>

                        <th width="150">Joined</th>

                        <th width="180" class="text-center">Actions</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($users as $user)

                    <tr>

                        <td>#{{ $user->id }}</td>

                        <td>

                            <div class="fw-semibold">

                                {{ $user->name }}

                            </div>

                        </td>

                        <td>

                            {{ $user->email }}

                        </td>
                                                <td>

                            {{ $user->created_at->format('d M Y') }}

                            <br>

                            <small class="text-secondary">

                                {{ $user->created_at->format('h:i A') }}

                            </small>

                        </td>

                        <td>

                            <div class="d-flex justify-content-center gap-2">

                                <a href="{{ route('admin.users.show', $user) }}"
                                   class="btn btn-sm btn-outline-light"
                                   title="View">

                                    <i class="bi bi-eye"></i>

                                </a>

                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="btn btn-sm btn-outline-warning"
                                   title="Edit">

                                    <i class="bi bi-pencil"></i>

                                </a>

                                <form method="POST"
                                      action="{{ route('admin.users.destroy', $user) }}"
                                      onsubmit="return confirm('Delete this user permanently?')">

                                    @csrf

                                    @method('DELETE')

                                    <button type="submit"
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

                        <td colspan="5" class="text-center py-5">

                            <i class="bi bi-people display-4 text-secondary"></i>

                            <h4 class="mt-3">

                                No Users Found

                            </h4>

                            <p class="text-secondary mb-0">

                                There are no users matching the current search criteria.

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

            <strong>{{ $users->firstItem() ?? 0 }}</strong>

            to

            <strong>{{ $users->lastItem() ?? 0 }}</strong>

            of

            <strong>{{ $users->total() }}</strong>

            users

        </div>

        <div>

            {{ $users->withQueryString()->links('pagination::bootstrap-5') }}

        </div>

    </div>

</section>

@endsection
