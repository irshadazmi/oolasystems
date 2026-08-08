@extends('layouts.app')

@section('title', 'Admin Dashboard | Oola Systems')

@section('content')

<section class="section-block">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-5">

        <div>

            <div class="eyebrow">

                Administration

            </div>

            <h1 class="page-title text-start mb-2">

                Admin Dashboard

            </h1>

            <p class="page-subtitle text-start ms-0">

                Welcome back,
                <strong>{{ Auth::user()->name }}</strong>.
                Manage contacts, visitors, inquiries and users from one place.

            </p>

        </div>

        <form method="POST" action="{{ route('admin.logout') }}">

            @csrf

            <button
                type="submit"
                class="btn btn-outline-light btn-lg">

                <i class="bi bi-box-arrow-right"></i>

                Logout

            </button>

        </form>

    </div>

    {{-- ====================================================== --}}
    {{-- Statistics --}}
    {{-- ====================================================== --}}

    <div class="row g-1 mb-5">

        <div class="col-lg-3 col-md-6">

            <div class="feature-card text-center h-100">

                <i class="bi bi-envelope-paper fs-1 text-primary"></i>

                <h2 class="mt-3">

                    {{ $contactsCount }}

                </h2>

                <h5>

                    Contacts

                </h5>

                <p class="text-secondary">

                    Customer Enquiries

                </p>

                <a
                    href="{{ route('admin.contacts.index') }}"
                    class="btn btn-outline-light btn-lg justify-content-center">

                    View All

                </a>

            </div>

        </div>

        <div class="col-lg-2 col-md-6">

            <div class="feature-card text-center h-100">

                <i class="bi bi-people fs-1 text-success"></i>

                <h2 class="mt-3">

                    {{ $careersCount }}

                </h2>

                <h5>

                    Careers

                </h5>

                <p class="text-secondary">

                    Job Opportunities

                </p>

                <a
                    href="{{ route('admin.careers.index') }}"
                    class="btn btn-outline-light btn-lg justify-content-center">

                    View All

                </a>

            </div>

        </div>

        <div class="col-lg-2 col-md-6">

            <div class="feature-card text-center h-100">

                <i class="bi bi-people fs-1 text-success"></i>

                <h2 class="mt-3">

                    {{ $visitorsCount }}

                </h2>

                <h5>

                    Visitors

                </h5>

                <p class="text-secondary">

                    Website Visitors

                </p>

                <a
                    href="{{ route('admin.visitors.index') }}"
                    class="btn btn-outline-light btn-lg justify-content-center">

                    View All

                </a>

            </div>

        </div>

        <div class="col-lg-2 col-md-6">

            <div class="feature-card text-center h-100">

                <i class="bi bi-person-badge fs-1 text-warning"></i>

                <h2 class="mt-3">

                    {{ $usersCount }}

                </h2>

                <h5>

                    Users

                </h5>

                <p class="text-secondary">

                    System Users

                </p>

                <a
                    href="{{ route('admin.users.index') }}"
                    class="btn btn-outline-light btn-lg justify-content-center">

                    View All

                </a>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="feature-card text-center h-100">

                <i class="bi bi-briefcase fs-1 text-info"></i>

                <h2 class="mt-3">

                    {{ $inquiriesCount }}

                </h2>

                <h5>

                    Inquiries

                </h5>

                <p class="text-secondary">

                    Business Enquiries

                </p>

                <a
                    href="{{ route('admin.inquiries.index') }}"
                    class="btn btn-outline-light btn-lg justify-content-center">

                    View All

                </a>

            </div>

        </div>

    </div>

    {{-- ====================================================== --}}
    {{-- Quick Actions --}}
    {{-- ====================================================== --}}

    <div class="feature-card">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

            <div>

                <h3 class="mb-1">

                    Quick Actions

                </h3>

                <p class="text-secondary mb-0">

                    Frequently used administration tasks.

                </p>

            </div>

        </div>

        <div class="row g-1">

            <div class="col-lg-3 col-md-6">

                <a
                    href="{{ route('admin.contacts.index') }}"
                    class="btn btn-primary w-100">

                    <i class="bi bi-envelope-paper"></i>

                    Manage Contact

                </a>

            </div>

            <div class="col-lg-2 col-md-6">

                <a
                    href="{{ route('admin.careers.index') }}"
                    class="btn btn-primary w-100">

                    <i class="bi bi-people"></i>

                    Manage Career

                </a>

            </div>

            <div class="col-lg-2 col-md-6">

                <a
                    href="{{ route('admin.visitors.index') }}"
                    class="btn btn-primary w-100">

                    <i class="bi bi-people"></i>

                    Visitor Analytics

                </a>

            </div>

            <div class="col-lg-2 col-md-6">

                <a
                    href="{{ route('admin.users.index') }}"
                    class="btn btn-primary w-100">

                    <i class="bi bi-person-gear"></i>

                    Manage User

                </a>

            </div>

            <div class="col-lg-3 col-md-6">

                <a
                    href="{{ route('admin.inquiries.index') }}"
                    class="btn btn-primary w-100">

                    <i class="bi bi-briefcase"></i>

                    Manage Inquiry

                </a>

            </div>

        </div>

    </div>

</section>

@endsection
