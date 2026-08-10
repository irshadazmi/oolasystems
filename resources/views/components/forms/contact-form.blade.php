@props([
    'showHeading' => true,
])

<div class="contact-form">

    @if($showHeading)

        <h4 class="fw-bold mb-3">
            Send us a detailed message
        </h4>

    @endif


    @if(session('contact_success'))

        <div class="alert alert-success">
            {{ session('contact_success') }}
        </div>

    @endif


    @if($errors->getBag('contact')->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach($errors->getBag('contact')->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <form
        method="POST"
        action="{{ route('contact.submit') }}"
        data-form-type="contact"
    >

        @csrf


        <div class="row g-3">

            <div class="col-sm-6 col-12">

                <x-forms.field
                    name="first_name"
                    label="First Name"
                    required
                    error-bag="contact"
                />

            </div>


            <div class="col-sm-6 col-12">

                <x-forms.field
                    name="last_name"
                    label="Last Name"
                    error-bag="contact"
                />

            </div>

        </div>


        <x-forms.field
            name="email"
            type="email"
            label="Email"
            required
            error-bag="contact"
        />


        <x-forms.field
            name="company"
            label="Company"
            error-bag="contact"
        />


        <x-forms.field
            name="subject"
            label="Subject"
            error-bag="contact"
        />


        <x-forms.field
            name="message"
            type="textarea"
            label="Message"
            rows="4"
            required
            error-bag="contact"
        />


        <x-forms.captcha
            type="contact"
            error-bag="contact"
        />


        <button
            type="submit"
            class="btn btn-primary w-100"
        >

            <i class="bi bi-send me-2"></i>

            Submit Message

        </button>

    </form>

</div>
