@extends('layouts.app')

@section('title', 'Inquiry Details | Oola Systems')

@section('content')

<section class="section-block">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-5">

        <div>
            <div class="eyebrow">Administration</div>
            <h1 class="page-title text-start mb-2">Inquiry Details</h1>
            <p class="page-subtitle text-start ms-0">
                Review customer inquiry and response details.
            </p>
        </div>

        <div class="d-flex gap-2">

            <a href="{{ route('admin.inquiries.edit', $inquiry) }}"
                class="btn btn-primary d-inline-flex align-items-center">

                <i class="bi bi-pencil me-2"></i>

                Reply

            </a>

            <a href="{{ route('admin.inquiries.index') }}"
                class="btn btn-outline-light d-inline-flex align-items-center">

                <i class="bi bi-arrow-left me-2"></i>

                Back

            </a>

        </div>

    </div>

    <div class="row justify-content-center">

        <div class="col-lg-9">

            <div class="feature-card">

                <div class="text-center mb-5">

                    <div class="display-1 text-primary">

                        <i class="bi bi-chat-dots-fill"></i>

                    </div>

                    <h2 class="mt-3 mb-1">

                        {{ $inquiry->name }}

                    </h2>

                    <p class="text-secondary mb-0">

                        {{ $inquiry->email }}

                    </p>

                </div>

                <div class="row g-4">

                    <div class="col-md-6">

                        <label class="form-label text-secondary">

                            Inquiry ID

                        </label>

                        <div class="form-control">

                            {{ $inquiry->id }}

                        </div>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label text-secondary">

                            Status

                        </label>

                        <div class="form-control">

                            @php
                                $status = $inquiry->status ?? 'New';
                            @endphp

                            @if($status == 'New')
                                <span class="badge bg-primary">New</span>
                            @elseif($status == 'Read')
                                <span class="badge bg-info">Read</span>
                            @elseif($status == 'Replied')
                                <span class="badge bg-success">Replied</span>
                            @elseif($status == 'Closed')
                                <span class="badge bg-secondary">Closed</span>
                            @else
                                <span class="badge bg-dark">{{ $status }}</span>
                            @endif

                        </div>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label text-secondary">

                            Full Name

                        </label>

                        <div class="form-control">

                            {{ $inquiry->name }}

                        </div>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label text-secondary">

                            Email Address

                        </label>

                        <div class="form-control">

                            {{ $inquiry->email }}

                        </div>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label text-secondary">

                            Project Type

                        </label>

                        <div class="form-control">

                            {{ $inquiry->project_type }}

                        </div>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label text-secondary">

                            Submitted On

                        </label>

                        <div class="form-control">

                            {{ $inquiry->created_at->format('d M Y, h:i A') }}

                        </div>

                    </div>

                    <div class="col-12">

                        <label class="form-label text-secondary">

                            Project Requirements

                        </label>

                        <textarea
                            class="form-control"
                            rows="6"
                            readonly>{{ $inquiry->message }}</textarea>

                    </div>

                    <div class="col-12">

                        <label class="form-label text-secondary">

                            Response

                        </label>

                        <textarea
                            class="form-control"
                            rows="6"
                            readonly>{{ $inquiry->response ?: 'No response has been provided yet.' }}</textarea>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label text-secondary">

                            Created

                        </label>

                        <div class="form-control">

                            {{ $inquiry->created_at->format('d M Y, h:i A') }}

                        </div>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label text-secondary">

                            Last Updated

                        </label>

                        <div class="form-control">

                            {{ $inquiry->updated_at->format('d M Y, h:i A') }}

                        </div>

                    </div>

                </div>

                <hr class="my-5">

                <div class="d-flex justify-content-end gap-3">

                    <form class="d-flex justify-content-end" method="POST"
                        action="{{ route('admin.inquiries.destroy', $inquiry) }}"
                        onsubmit="return confirm('Delete this inquiry permanently?')">

                        @csrf

                        @method('DELETE')

                        <button
                            type="submit"
                            class="btn btn-outline-danger d-inline-flex align-items-center">

                            <i class="bi bi-trash me-2"></i>

                            Delete Inquiry

                        </button>

                    </form>

                    <a
                        href="{{ route('admin.inquiries.edit', $inquiry) }}"
                        class="btn btn-primary d-inline-flex align-items-center">

                        <i class="bi bi-reply-fill me-2"></i>

                        Reply to Inquiry

                    </a>

                </div>

            </div>

        </div>

    </div>

</section>

@endsection
