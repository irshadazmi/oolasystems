@extends('layouts.app')

@section('title', 'View Contact | Oola Systems')

@section('content')

<section class="section-block">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-5">

        <div>

            <div class="eyebrow">

                Administration

            </div>

            <h1 class="page-title text-start mb-2">

                Contact Details

            </h1>

            <p class="page-subtitle text-start ms-0">

                Review customer enquiry and update its status.

            </p>

        </div>

        <div class="d-flex gap-2">

            <a href="{{ route('admin.dashboard') }}"
                class="btn btn-outline-light">

                <i class="bi bi-arrow-left"></i>

                Back

            </a>

        </div>

    </div>

    <div class="row g-4">

        <div class="col-lg-8">

            <div class="feature-card">

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <h3 class="mb-0">

                        Contact Information

                    </h3>

                    @switch($contact->status)

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
                            <span class="badge bg-secondary">
                                {{ $contact->status }}
                            </span>
                    @endswitch

                </div>

                <div class="row gy-4">

                    <div class="col-md-6">

                        <label class="text-secondary small">

                            First Name

                        </label>

                        <div class="fw-semibold">

                            {{ $contact->first_name }}

                        </div>

                    </div>

                    <div class="col-md-6">

                        <label class="text-secondary small">

                            Last Name

                        </label>

                        <div class="fw-semibold">

                            {{ $contact->last_name ?: '—' }}

                        </div>

                    </div>

                    <div class="col-md-6">

                        <label class="text-secondary small">

                            Email

                        </label>

                        <div>

                            <a href="mailto:{{ $contact->email }}">

                                {{ $contact->email }}

                            </a>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <label class="text-secondary small">

                            Company

                        </label>

                        <div>

                            {{ $contact->company ?: '—' }}

                        </div>

                    </div>

                    <div class="col-12">

                        <label class="text-secondary small">

                            Subject

                        </label>

                        <div class="fw-semibold">

                            {{ $contact->subject ?: 'No Subject' }}

                        </div>

                    </div>

                    <div class="col-12">

                        <label class="text-secondary small">

                            Message

                        </label>

                        <div class="border rounded p-4 mt-2">

                            {!! nl2br(e($contact->message)) !!}

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="feature-card mb-4">

                <h4 class="mb-4">

                    Contact Summary

                </h4>

                <table class="table table-borderless mb-0">

                    <tr>

                        <th width="40%">

                            ID

                        </th>

                        <td>

                            #{{ $contact->id }}

                        </td>

                    </tr>

                    <tr>

                        <th>

                            Received

                        </th>

                        <td>

                            {{ $contact->created_at->format('d M Y') }}

                            <br>

                            <small class="text-secondary">

                                {{ $contact->created_at->format('h:i A') }}

                            </small>

                        </td>

                    </tr>

                    <tr>

                        <th>

                            Last Updated

                        </th>

                        <td>

                            {{ $contact->updated_at->format('d M Y') }}

                        </td>

                    </tr>

                    <tr>

                        <th>

                            Status

                        </th>

                        <td>

                            {{ $contact->status }}

                        </td>

                    </tr>

                </table>

            </div>

            <div class="feature-card">

                <h4 class="mb-4">

                    Update Status

                </h4>

                <form method="POST"
                    action="{{ route('admin.contacts.update', $contact) }}">

                    @csrf

                    @method('PATCH')

                    <div class="mb-4">

                        <select
                            name="status"
                            class="form-select">

                            <option value="New"
                                @selected($contact->status=='New')>

                                New

                            </option>

                            <option value="Read"
                                @selected($contact->status=='Read')>

                                Read

                            </option>

                            <option value="Replied"
                                @selected($contact->status=='Replied')>

                                Replied

                            </option>

                            <option value="Closed"
                                @selected($contact->status=='Closed')>

                                Closed

                            </option>

                        </select>

                    </div>

                    <button
                        class="btn btn-primary w-100">

                        <i class="bi bi-check-circle"></i>

                        Update Status

                    </button>

                </form>

                <hr class="my-4">

                <form
                    method="POST"
                    action="{{ route('admin.contacts.destroy', $contact) }}"
                    onsubmit="return confirm('Delete this contact permanently?')">

                    @csrf

                    @method('DELETE')

                    <button
                        type="submit"
                        class="btn btn-outline-danger w-100">

                        <i class="bi bi-trash"></i>

                        Delete Contact

                    </button>

                </form>

            </div>

        </div>

    </div>

</section>

@endsection
