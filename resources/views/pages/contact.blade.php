@extends('layouts.app')

@section('content')

    <!-- ========================================================= -->
    <!-- HERO -->
    <!-- ========================================================= -->

    <section class="section-block text-center">

        <div class="eyebrow">
            Contact Oola Systems
        </div>

        <h1 class="page-title">
            Let's discuss your next
            technology initiative
        </h1>

        <p class="page-subtitle">

            Whether you're planning a custom software solution,
            exploring Artificial Intelligence, modernizing legacy systems,
            migrating to the cloud, or accelerating digital transformation,
            our team is ready to help you turn ideas into practical,
            scalable business solutions.

        </p>

    </section>

    <!-- Quick Form -->
    <section class="section-block" id="quick-form">
        <div class="row align-items-stretch align-items-top mb-4">
            <div class="col-lg-6 col-12 mb-5">

                <div class="eyebrow">
                    Start Your Project
                </div>

                <h2 class="section-title">

                    Turning business challenges into
                    scalable technology solutions

                </h2>

                <p class="section-subtitle">

                    Every successful digital transformation begins with a conversation.
                    Whether you're planning a new software platform, exploring Artificial
                    Intelligence, modernizing legacy applications, or migrating to the cloud,
                    our consultants are ready to help define the right strategy.

                </p>

                <div class="feature-card mt-4">

                    <h5 class="mb-3">
                        What you can expect
                    </h5>

                    <ul class="list-unstyled mb-0">

                        <li class="mb-3">
                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                            Initial consultation focused on your business objectives.
                        </li>

                        <li class="mb-3">
                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                            Technology recommendations tailored to your requirements.
                        </li>

                        <li class="mb-3">
                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                            High-level architecture and delivery approach.
                        </li>

                        <li class="mb-3">
                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                            Experienced architects with 25+ years of enterprise expertise.
                        </li>

                        <li class="mb-3">
                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                            AI-driven, cloud-native, and scalable solution recommendations.
                        </li>

                        <li class="mb-3">
                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                            End-to-end delivery from strategy and design to implementation and support.
                        </li>

                        <li class="mb-3">
                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                            Transparent project planning, timelines, and engagement model.
                        </li>

                        <li>
                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                            Initial response from our team within one business day.
                        </li>

                    </ul>

                </div>

            </div>

            <!-- RIGHT QUICK FORM -->
            <div class="col-lg-6 col-12">
                <div class="p-4 shadow rounded bg-white">

                    <h4 class="fw-bold">
                        Request a Consultation
                    </h4>

                    <p class="text-muted mb-4">

                        Tell us about your project, business goals,
                        or technology challenges. Our team will review
                        your requirements and get back to you within
                        one business day.

                    </p>

                    <form method="POST" action="{{ route('inquiry.submit') }}">
                        @csrf

                        {{-- Success --}}
                        @if(session('inquiry_success'))
                            <div class="alert alert-success py-2">
                                {{ session('inquiry_success') }}
                            </div>
                        @endif

                        {{-- Errors --}}
                        @if($errors->inquiry->any())
                            <div class="alert alert-danger py-2">
                                <ul class="mb-0 small">
                                    @foreach($errors->inquiry->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mb-3">

                            <input
                                type="text"
                                name="name"
                                class="form-control @error('name','inquiry') is-invalid @enderror"
                                placeholder="Your Full Name"
                                value="{{ old('name') }}"
                                required>

                        </div>

                        <div class="mb-3">

                            <input
                                type="email"
                                name="email"
                                class="form-control @error('email','inquiry') is-invalid @enderror"
                                placeholder="Work Email"
                                value="{{ old('email') }}"
                                required>

                        </div>

                        <div class="mb-3">

                            <select
                                name="project_type"
                                class="form-select @error('project_type','inquiry') is-invalid @enderror"
                                required>

                                <option value="">Select Project Type</option>

                                <option value="Artificial Intelligence" {{ old('project_type')=='Artificial Intelligence' ? 'selected' : '' }}>Artificial Intelligence</option>

                                <option value="Enterprise Software Development" {{ old('project_type')=='Enterprise Software Development' ? 'selected' : '' }}>Enterprise Software Development</option>

                                <option value="Web Application Development" {{ old('project_type')=='Web Application Development' ? 'selected' : '' }}>Web Application Development</option>

                                <option value="Mobile App Development" {{ old('project_type')=='Mobile App Development' ? 'selected' : '' }}>Mobile App Development</option>

                                <option value="Cloud Engineering & Migration" {{ old('project_type')=='Cloud Engineering & Migration' ? 'selected' : '' }}>Cloud Engineering & Migration</option>

                                <option value="Data Engineering & Analytics" {{ old('project_type')=='Data Engineering & Analytics' ? 'selected' : '' }}>Data Engineering & Analytics</option>

                                <option value="DevOps & Platform Engineering" {{ old('project_type')=='DevOps & Platform Engineering' ? 'selected' : '' }}>DevOps & Platform Engineering</option>

                                <option value="Technology Consulting" {{ old('project_type')=='Technology Consulting' ? 'selected' : '' }}>Technology Consulting</option>

                                <option value="Digital Transformation" {{ old('project_type')=='Digital Transformation' ? 'selected' : '' }}>Digital Transformation</option>

                                <option value="Corporate Training & Workshops" {{ old('project_type')=='Corporate Training & Workshops' ? 'selected' : '' }}>Corporate Training & Workshops</option>

                                <option value="Managed Support & Maintenance" {{ old('project_type')=='Managed Support & Maintenance' ? 'selected' : '' }}>Managed Support & Maintenance</option>

                                <option value="Other" {{ old('project_type')=='Other' ? 'selected' : '' }}>Other</option>

                            </select>

                        </div>

                        <div class="mb-3">

                            <textarea
                                name="message"
                                rows="5"
                                class="form-control @error('message','inquiry') is-invalid @enderror"
                                placeholder="Briefly describe your project requirements, business objectives, expected timeline, technologies involved, or any specific expectations."
                                required>{{ old('message') }}</textarea>

                        </div>

                        {{-- CAPTCHA --}}
                        <div class="mb-3">

                            <label class="fw-semibold d-flex align-items-center justify-content-between">

                                <span>

                                    Solve:

                                    <span id="captcha-inquiry-text">

                                        {{ session('captcha_inquiry_question') ?? 'Loading...' }}

                                    </span>

                                </span>

                                <a href="javascript:void(0)"
                                onclick="refreshCaptcha('inquiry')"
                                class="ms-2 text-decoration-none">

                                    🔄

                                </a>

                            </label>

                            <input
                                type="text"
                                name="captcha"
                                class="form-control @error('captcha','inquiry') is-invalid @enderror"
                                placeholder="Enter answer"
                                required>

                        </div>

                        <button type="submit" class="btn btn-primary w-100">

                            <i class="bi bi-send me-2"></i>

                            Submit Inquiry

                        </button>
                    </form>
                </div>
            </div>

        </div>
    </section>

    <!-- CONTACT FORM -->
    <section class="section-block" id="contact-form">
        <div class="row g-5 align-items-start">

            <!-- FULL FORM -->
            <div class="col-lg-7 col-12 mb-4">
                <div class="p-4 shadow rounded bg-white h-100">

                    <h4 class="fw-bold mb-3">Send us a detailed message</h4>

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contact.submit') }}">
                        @csrf

                        {{-- Success --}}
                        @if (session('contact_success'))
                            <div class="alert alert-success">
                                {{ session('contact_success') }}
                            </div>
                        @endif

                        {{-- Errors --}}
                        @if ($errors->contact->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->contact->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row g-3">
                            <div class="col-sm-6 col-12">
                                <label>First Name *</label>
                                <input type="text" name="first_name"
                                    class="form-control @error('first_name', 'contact') is-invalid @enderror"
                                    value="{{ old('first_name') }}" required>
                            </div>

                            <div class="col-sm-6 col-12">
                                <label>Last Name</label>
                                <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Email *</label>
                            <input type="email" name="email"
                                class="form-control @error('email', 'contact') is-invalid @enderror"
                                value="{{ old('email') }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Company</label>
                            <input type="text" name="company" class="form-control" value="{{ old('company') }}">
                        </div>

                        <div class="mb-3">
                            <label>Subject</label>
                            <input type="text" name="subject" class="form-control" value="{{ old('subject') }}">
                        </div>

                        <div class="mb-3">
                            <label>Message *</label>
                            <textarea name="message" class="form-control @error('message', 'contact') is-invalid @enderror" rows="4"
                                required>{{ old('message') }}</textarea>
                        </div>

                        {{-- CAPTCHA --}}
                        <div class="mb-3">
                            <label class="fw-semibold d-flex align-items-center justify-content-between">

                                <span>
                                    Solve:
                                    <span id="captcha-contact-text">
                                        {{ session('captcha_contact_question') ?? 'Loading...' }}
                                    </span>
                                </span>

                                <a href="javascript:void(0)" onclick="refreshCaptcha('contact')"
                                    class="ms-2 text-decoration-none">
                                    🔄
                                </a>

                            </label>

                            <input type="text" name="captcha"
                                class="form-control @error('captcha', 'contact') is-invalid @enderror"
                                placeholder="Enter answer" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Submit Message
                        </button>
                    </form>
                </div>
            </div>

            <!-- CONTACT INFO -->
            <div class="col-lg-5 mb-4">

                <div class="feature-card h-100">

                    <h4 class="fw-bold mb-3">
                        Contact Information
                    </h4>

                    <p class="text-muted mb-4">

                        We'd be delighted to learn about your business goals and discuss how
                        Oola Systems can help you build secure, scalable, and future-ready
                        digital solutions.

                    </p>

                    <hr>

                    <!-- Contact Details -->

                    <div class="mb-4">

                        <h6 class="fw-semibold mb-1">
                            <i class="bi bi-envelope-fill text-primary me-2"></i>
                            Email
                        </h6>

                        <p class="text-muted mb-1">
                            info@oolasystems.com
                        </p>

                        <small class="text-muted">
                            General enquiries, project discussions and partnerships
                        </small>

                    </div>

                    <div class="mb-4">

                        <h6 class="fw-semibold mb-1">
                            <i class="bi bi-telephone-fill text-primary me-2"></i>
                            Phone
                        </h6>

                        <p class="text-muted mb-1">
                            +91 86688 75354
                        </p>

                        <small class="text-muted">
                            Monday – Friday, 9:00 AM – 6:00 PM (IST)
                        </small>

                    </div>

                    <div class="mb-4">

                        <h6 class="fw-semibold mb-1">
                            <i class="bi bi-geo-alt-fill text-primary me-2"></i>
                            Office
                        </h6>

                        <p class="text-muted mb-1">
                            Pune, Maharashtra, India
                        </p>

                        <small class="text-muted">
                            Serving clients across India and globally
                        </small>

                    </div>

                    <div class="mb-4">

                        <h6 class="fw-semibold mb-1">
                            <i class="bi bi-clock-fill text-primary me-2"></i>
                            Business Hours
                        </h6>

                        <p class="text-muted mb-1">
                            Monday – Friday
                        </p>

                        <small class="text-muted">
                            Weekend support available for active engagements
                        </small>

                    </div>

                    <hr>

                    <div class="text-center pt-2">

                        <i class="bi bi-clock-history text-primary fs-3 mb-2"></i>

                        <h6 class="mb-1">
                            Response Commitment
                        </h6>

                        <p class="small text-muted mb-0">

                            We typically acknowledge all enquiries within
                            <strong>one business day</strong> and schedule an
                            initial consultation at your convenience.

                        </p>

                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- FAQ -->

    <section class="section-block" id="faq">

        <div class="text-center mb-5">

            <div class="eyebrow">
                Frequently Asked Questions
            </div>

            <h2 class="section-title">
                Answers to Common Questions
            </h2>

            <p class="section-subtitle">

                Everything you need to know before starting your next
                software, AI, cloud, or digital transformation initiative
                with Oola Systems.

            </p>

        </div>

        <div class="accordion" id="faqAccordion">

            {{-- FAQ 1 --}}
            <div class="accordion-item">

                <h2 class="accordion-header">

                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">

                        How do I get started with Oola Systems?

                    </button>

                </h2>

                <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">

                    <div class="accordion-body">

                        Simply submit the enquiry form, email us, or call our team.
                        We'll schedule an initial consultation to understand your
                        business objectives, discuss possible solutions, and recommend
                        the most suitable engagement approach.

                    </div>

                </div>

            </div>

            {{-- FAQ 2 --}}
            <div class="accordion-item">

                <h2 class="accordion-header">

                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq2">

                        What types of organizations do you work with?

                    </button>

                </h2>

                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">

                    <div class="accordion-body">

                        We work with startups, SMEs, enterprises,
                        educational institutions, and public sector
                        organizations. Every engagement is tailored
                        to your business goals, technical landscape,
                        and growth stage.

                    </div>

                </div>

            </div>

            {{-- FAQ 3 --}}
            <div class="accordion-item">

                <h2 class="accordion-header">

                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq3">

                        What technology services does Oola Systems provide?

                    </button>

                </h2>

                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">

                    <div class="accordion-body">

                        Our services include Artificial Intelligence,
                        custom software development, enterprise applications,
                        cloud solutions, data engineering, analytics,
                        DevOps, digital transformation, and technology consulting.

                    </div>

                </div>

            </div>

            {{-- FAQ 4 --}}
            <div class="accordion-item">

                <h2 class="accordion-header">

                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq4">

                        Which industries do you serve?

                    </button>

                </h2>

                <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">

                    <div class="accordion-body">

                        We deliver technology solutions for Healthcare,
                        Banking & Financial Services, Insurance,
                        Retail & E-Commerce, Manufacturing,
                        Education, Logistics, and Enterprise Operations,
                        while adapting every solution to industry-specific
                        business requirements.

                    </div>

                </div>

            </div>

            {{-- FAQ 5 --}}
            <div class="accordion-item">

                <h2 class="accordion-header">

                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq5">

                        Can you modernize our existing applications?

                    </button>

                </h2>

                <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">

                    <div class="accordion-body">

                        Yes. We modernize legacy applications, migrate
                        workloads to the cloud, improve application
                        performance, integrate AI capabilities, and
                        redesign software architectures while protecting
                        your existing business investments.

                    </div>

                </div>

            </div>

            {{-- FAQ 6 --}}
            <div class="accordion-item">

                <h2 class="accordion-header">

                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq6">

                        Do you develop AI-powered business applications?

                    </button>

                </h2>

                <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">

                    <div class="accordion-body">

                        Absolutely. We build intelligent applications using
                        Generative AI, AI Agents, Retrieval-Augmented Generation (RAG),
                        conversational assistants, workflow automation,
                        predictive analytics, and enterprise AI integrations.

                    </div>

                </div>

            </div>

            {{-- FAQ 7 --}}
            <div class="accordion-item">

                <h2 class="accordion-header">

                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq7">

                        How long does a typical project take?

                    </button>

                </h2>

                <div id="faq7" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">

                    <div class="accordion-body">

                        Timelines vary depending on project scope and
                        complexity. Smaller engagements may take only a
                        few weeks, while enterprise transformation
                        initiatives may span several months. Every project
                        follows a structured delivery plan with clearly
                        defined milestones.

                    </div>

                </div>

            </div>

            {{-- FAQ 8 --}}
            <div class="accordion-item">

                <h2 class="accordion-header">

                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq8">

                        Do you provide post-launch support and maintenance?

                    </button>

                </h2>

                <div id="faq8" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">

                    <div class="accordion-body">

                        Yes. We provide ongoing application support,
                        cloud management, performance optimization,
                        feature enhancements, security updates,
                        and long-term technology partnerships.

                    </div>

                </div>

            </div>

            {{-- FAQ 9 --}}
            <div class="accordion-item">

                <h2 class="accordion-header">

                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq9">

                        Do you sign Non-Disclosure Agreements (NDAs)?

                    </button>

                </h2>

                <div id="faq9" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">

                    <div class="accordion-body">

                        Yes. We understand the importance of protecting
                        confidential business information and intellectual
                        property. We're happy to sign an NDA before discussing
                        sensitive projects.

                    </div>

                </div>

            </div>

            {{-- FAQ 10 --}}
            <div class="accordion-item">

                <h2 class="accordion-header">

                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq10">

                        Why choose Oola Systems as your technology partner?

                    </button>

                </h2>

                <div id="faq10" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">

                    <div class="accordion-body">

                        Oola Systems combines extensive enterprise technology
                        experience with expertise in Artificial Intelligence,
                        cloud computing, enterprise software engineering,
                        and digital transformation. We focus on delivering
                        practical, scalable solutions that create measurable
                        business value through transparent collaboration,
                        technical excellence, and long-term partnerships.

                    </div>

                </div>

            </div>

        </div>

    </section>

    <script>
        function refreshCaptcha(type) {
            fetch('/refresh-captcha/' + type)
                .then(response => response.json())
                .then(data => {

                    if (type === 'contact') {
                        document.getElementById('captcha-contact-text').innerText = data.question;
                    } else {
                        document.getElementById('captcha-inquiry-text').innerText = data.question;
                    }

                })
                .catch(err => console.error(err));
        }
    </script>
@endsection
