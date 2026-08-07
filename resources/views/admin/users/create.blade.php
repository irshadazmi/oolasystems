@extends('layouts.app')

@section('title', 'Create User | Oola Systems')

@section('content')

<section class="section-block">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-5">

        <div>
            <div class="eyebrow">Administration</div>
            <h1 class="page-title text-start mb-2">Create User</h1>
            <p class="page-subtitle text-start ms-0">
                Create a new administrator account.
            </p>
        </div>

        <div>

            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-light">
                <i class="bi bi-arrow-left"></i>
                Back to Users
            </a>

        </div>

    </div>

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="feature-card">

                @if(session('success'))

                    <div class="alert alert-success">

                        {{ session('success') }}

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

                <form method="POST" action="{{ route('admin.users.store') }}">

                    @csrf

                    <div class="row g-4">

                        <div class="col-md-6">

                            <label class="form-label">Full Name</label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                value="{{ old('name') }}"
                                required>

                        </div>

                        <div class="col-md-6">

                            <label class="form-label">Email Address</label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                value="{{ old('email') }}"
                                required>

                        </div>

                        <div class="col-md-6">

                            <label class="form-label">Password</label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                required>

                        </div>

                        <div class="col-md-6">

                            <label class="form-label">Confirm Password</label>

                            <input
                                type="password"
                                name="password_confirmation"
                                class="form-control"
                                required>

                        </div>

                    </div>

                    <div class="d-flex justify-content-end gap-3 mt-5">

                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-light">

                            Cancel

                        </a>

                        <button type="submit" class="btn btn-primary">

                            <i class="bi bi-person-plus"></i>

                            Create User

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</section>

@endsection
