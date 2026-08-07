@extends('layouts.app')

@section('title', 'Edit Inquiry | Oola Systems')

@section('content')

<section class="section-block">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-5">

        <div>
            <div class="eyebrow">Administration</div>
            <h1 class="page-title text-start mb-2">Reply to Inquiry</h1>
            <p class="page-subtitle text-start ms-0">
                Review the inquiry and send your response.
            </p>
        </div>

        <div>

            <a href="{{ route('admin.inquiries.index') }}" class="btn btn-outline-light">
                <i class="bi bi-arrow-left"></i>
                Back to Inquiries
            </a>

        </div>

    </div>

    <div class="row justify-content-center">

        <div class="col-lg-9">

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

                <form method="POST" action="{{ route('admin.inquiries.update', $inquiry) }}">

                    @csrf

                    @method('PATCH')

                    <div class="row g-4">

                        <div class="col-md-6">

                            <label class="form-label">Name</label>

                            <input
                                type="text"
                                class="form-control"
                                value="{{ $inquiry->name }}"
                                readonly>

                        </div>

                        <div class="col-md-6">

                            <label class="form-label">Email Address</label>

                            <input
                                type="email"
                                class="form-control"
                                value="{{ $inquiry->email }}"
                                readonly>

                        </div>

                        <div class="col-md-6">

                            <label class="form-label">Project Type</label>

                            <input
                                type="text"
                                class="form-control"
                                value="{{ $inquiry->project_type }}"
                                readonly>

                        </div>

                        <div class="col-md-6">

                            <label class="form-label">Status</label>

                            <select
                                name="status"
                                class="form-select">

                                <option value="New" {{ $inquiry->status=='New' ? 'selected' : '' }}>New</option>
                                <option value="Read" {{ $inquiry->status=='Read' ? 'selected' : '' }}>Read</option>
                                <option value="Replied" {{ $inquiry->status=='Replied' ? 'selected' : '' }}>Replied</option>
                                <option value="Closed" {{ $inquiry->status=='Closed' ? 'selected' : '' }}>Closed</option>

                            </select>

                        </div>

                        <div class="col-12">

                            <label class="form-label">Customer Message</label>

                            <textarea
                                class="form-control"
                                rows="6"
                                readonly>{{ $inquiry->message }}</textarea>

                        </div>

                        <div class="col-12">

                            <label class="form-label">Your Response</label>

                            <textarea
                                name="response"
                                rows="8"
                                class="form-control"
                                placeholder="Type your response to the customer...">{{ old('response', $inquiry->response) }}</textarea>

                        </div>

                    </div>

                    <div class="d-flex justify-content-end gap-3 mt-5">

                        <a href="{{ route('admin.inquiries.index') }}"
                           class="btn btn-outline-light d-inline-flex align-items-center justify-content-center">

                            <i class="bi bi-x-circle me-2"></i>

                            Cancel

                        </a>

                        <button type="submit"
                                class="btn btn-primary d-inline-flex align-items-center justify-content-center">

                            <i class="bi bi-send me-2"></i>

                            Save Response

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</section>

@endsection
