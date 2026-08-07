@extends('layouts.app')

@section('title', 'Visitor Details | Oola Systems')

@section('content')

<section class="section-block">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-5">

        <div>
            <div class="eyebrow">Administration</div>
            <h1 class="page-title text-start mb-2">Visitor Details</h1>
            <p class="page-subtitle text-start ms-0">
                View website visitor activity and request information.
            </p>
        </div>

        <div>

            <a href="{{ route('admin.visitors.index') }}"
                class="btn btn-outline-light d-inline-flex align-items-center">

                <i class="bi bi-arrow-left me-2"></i>

                Back to Visitor Analytics

            </a>

        </div>

    </div>

    <div class="row justify-content-center">

        <div class="col-lg-9">

            <div class="feature-card">

                <div class="text-center mb-5">

                    <div class="display-1 text-primary">

                        <i class="bi bi-person-badge-fill"></i>

                    </div>

                    <h2 class="mt-3 mb-1">

                        Visitor #{{ $visitor->id }}

                    </h2>

                    <p class="text-secondary mb-0">

                        Website Visitor Activity

                    </p>

                </div>

                <div class="row g-4">

                    <div class="col-md-6">

                        <label class="form-label text-secondary">

                            Visitor ID

                        </label>

                        <div class="form-control">

                            {{ $visitor->id }}

                        </div>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label text-secondary">

                            IP Address

                        </label>

                        <div class="form-control">

                            {{ $visitor->ip }}

                        </div>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label text-secondary">

                            Visited Page

                        </label>

                        <div class="form-control">

                            {{ $visitor->page }}

                        </div>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label text-secondary">

                            Visit Date & Time

                        </label>

                        <div class="form-control">

                            {{ $visitor->created_at->format('d M Y, h:i A') }}

                        </div>

                    </div>

                    <div class="col-12">

                        <label class="form-label text-secondary">

                            User Agent

                        </label>

                        <textarea
                            class="form-control"
                            rows="5"
                            readonly>{{ $visitor->user_agent }}</textarea>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label text-secondary">

                            Created

                        </label>

                        <div class="form-control">

                            {{ $visitor->created_at->format('d M Y, h:i A') }}

                        </div>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label text-secondary">

                            Last Updated

                        </label>

                        <div class="form-control">

                            {{ $visitor->updated_at->format('d M Y, h:i A') }}

                        </div>

                    </div>

                </div>

                <hr class="my-5">

                <div class="d-flex justify-content-end">

                    <a href="{{ route('admin.visitors.index') }}"
                        class="btn btn-primary d-inline-flex align-items-center">

                        <i class="bi bi-arrow-left-circle me-2"></i>

                        Back to Visitor Analytics

                    </a>

                </div>

            </div>

        </div>

    </div>

</section>

@endsection
