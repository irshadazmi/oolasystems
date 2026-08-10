@props([
    'mode' => 'standard',
    'showHeading' => true,
])

<div class="inquiry-form">

    @if($showHeading)

        <h4 class="fw-bold">
            Request a Consultation
        </h4>

        <p class="text-muted mb-4">
            Tell us about your project, business goals,
            or technology challenges. Our team will review
            your requirements and get back to you within
            one business day.
        </p>

    @endif


    @if(session('inquiry_success'))

        <div class="alert alert-success py-2">
            {{ session('inquiry_success') }}
        </div>

    @endif


    @if($errors->getBag('inquiry')->any())

        <div class="alert alert-danger py-2">

            <ul class="mb-0 small">

                @foreach($errors->getBag('inquiry')->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <form
        method="POST"
        action="{{ route('inquiry.submit') }}"
        data-form-type="inquiry"
        data-form-mode="{{ $mode }}"
    >

        @csrf


        <x-forms.field
            name="name"
            label="Your Full Name"
            placeholder="Your Full Name"
            required
            error-bag="inquiry"
        />


        <x-forms.field
            name="email"
            type="email"
            label="Work Email"
            placeholder="Work Email"
            required
            error-bag="inquiry"
        />


        @php

            $projectTypes = [

                '' => 'Select Project Type',

                'Artificial Intelligence'
                    => 'Artificial Intelligence',

                'Enterprise Software Development'
                    => 'Enterprise Software Development',

                'Web Application Development'
                    => 'Web Application Development',

                'Mobile App Development'
                    => 'Mobile App Development',

                'Cloud Engineering & Migration'
                    => 'Cloud Engineering & Migration',

                'Data Engineering & Analytics'
                    => 'Data Engineering & Analytics',

                'DevOps & Platform Engineering'
                    => 'DevOps & Platform Engineering',

                'Technology Consulting'
                    => 'Technology Consulting',

                'Digital Transformation'
                    => 'Digital Transformation',

                'Corporate Training & Workshops'
                    => 'Corporate Training & Workshops',

                'Managed Support & Maintenance'
                    => 'Managed Support & Maintenance',

                'Other'
                    => 'Other',

            ];

        @endphp


        <x-forms.field
            name="project_type"
            type="select"
            label="Project Type"
            :options="$projectTypes"
            required
            error-bag="inquiry"
        />


        <x-forms.field
            name="message"
            type="textarea"
            label="Project Requirements"
            rows="5"
            placeholder="Briefly describe your project requirements, business objectives, expected timeline, technologies involved, or any specific expectations."
            required
            error-bag="inquiry"
        />


        <x-forms.captcha
            type="inquiry"
            error-bag="inquiry"
        />


        <button
            type="submit"
            class="btn btn-primary w-100"
        >

            <i class="bi bi-send me-2"></i>

            {{ $mode === 'chatbot'
                ? 'Continue with Inquiry'
                : 'Submit Inquiry'
            }}

        </button>

    </form>

</div>
