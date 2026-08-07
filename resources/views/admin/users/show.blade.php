@extends('layouts.app')

@section('title', 'User Details | Oola Systems')

@section('content')

<section class="section-block">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-5">

        <div>
            <div class="eyebrow">Administration</div>
            <h1 class="page-title text-start mb-2">User Details</h1>
            <p class="page-subtitle text-start ms-0">
                View administrator account information.
            </p>
        </div>

        <div class="d-flex gap-2">

            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary d-inline-flex align-items-center">

                <i class="bi bi-pencil me-2"></i>

                Edit

            </a>

            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-light d-inline-flex align-items-center">

                <i class="bi bi-arrow-left me-2"></i>

                Back

            </a>

        </div>

    </div>

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="feature-card">

                <div class="text-center mb-5">

                    <div class="display-1 text-primary">

                        <i class="bi bi-person-circle"></i>

                    </div>

                    <h2 class="mt-3 mb-1">

                        {{ $user->name }}

                    </h2>

                    <p class="text-secondary mb-0">

                        Administrator

                    </p>

                </div>

                <div class="row g-4">

                    <div class="col-md-6">

                        <label class="form-label text-secondary">

                            User ID

                        </label>

                        <div class="form-control">

                            {{ $user->id }}

                        </div>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label text-secondary">

                            Full Name

                        </label>

                        <div class="form-control">

                            {{ $user->name }}

                        </div>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label text-secondary">

                            Email Address

                        </label>

                        <div class="form-control">

                            {{ $user->email }}

                        </div>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label text-secondary">

                            Email Verified

                        </label>

                        <div class="form-control">

                            @if($user->email_verified_at)

                                <span class="badge bg-success">

                                    Verified

                                </span>

                            @else

                                <span class="badge bg-warning text-dark">

                                    Not Verified

                                </span>

                            @endif

                        </div>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label text-secondary">

                            Created On

                        </label>

                        <div class="form-control">

                            {{ $user->created_at->format('d M Y, h:i A') }}

                        </div>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label text-secondary">

                            Last Updated

                        </label>

                        <div class="form-control">

                            {{ $user->updated_at->format('d M Y, h:i A') }}

                        </div>

                    </div>

                </div>

                <hr class="my-5">

                <div class="d-flex justify-content-end gap-3">

                    <form  class="d-flex justify-content-end" method="POST"
                          action="{{ route('admin.users.destroy', $user) }}"
                          onsubmit="return confirm('Delete this user permanently?')">

                        @csrf

                        @method('DELETE')

                        <button type="submit"
                                class="btn btn-outline-danger d-inline-flex align-items-center">

                            <i class="bi bi-trash me-2"></i>

                            Delete User

                        </button>

                    </form>

                    <a href="{{ route('admin.users.edit', $user) }}"
                       class="btn btn-primary d-inline-flex align-items-center">

                        <i class="bi bi-pencil me-2"></i>

                        Edit User

                    </a>

                </div>

            </div>

        </div>

    </div>

</section>

@endsection
