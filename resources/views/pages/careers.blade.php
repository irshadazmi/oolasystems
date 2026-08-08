@extends('layouts.app')

@section('title', 'Careers | Oola Systems')

@section('meta_description',
    'Explore career opportunities at Oola Systems and join our team working on enterprise software, Artificial Intelligence, cloud, data, and digital transformation.')

@section('content')

<section class="section-block text-center">
    <div class="eyebrow">Join Oola Systems</div>
    <h1 class="page-title">Careers</h1>
    <p class="page-subtitle">
        Build meaningful technology solutions, solve challenging business problems,
        and grow with a team focused on software engineering, Artificial Intelligence,
        cloud, data, and digital transformation.
    </p>
</section>

<section class="section-block">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="feature-card">
                <div class="eyebrow">Why Oola Systems</div>
                <h2 class="section-title">Build. Learn. Transform.</h2>
                <p>
                    At Oola Systems, we bring technology and business thinking together
                    to build scalable solutions for real-world challenges. We value
                    engineering excellence, continuous learning, innovation,
                    collaboration, and practical problem solving.
                </p>
                <p class="mb-0">
                    Whether you are an experienced technology professional or an
                    aspiring engineer, we encourage people who are curious,
                    accountable, and passionate about creating meaningful technology.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="section-block" id="open-positions">
    <div class="text-center mb-5">
        <div class="eyebrow">Opportunities</div>
        <h2 class="section-title">Open Positions</h2>
        <p class="section-subtitle">
            Explore our current opportunities and find a role that matches
            your skills, experience, and career goals.
        </p>
    </div>

    <div class="row gx-3 gy-4">

        @forelse($careers as $career)

            <div class="col-lg-6">

                <div class="feature-card h-100">

                    <div class="d-flex justify-content-between align-items-start gap-3 mb-3">

                        <div>
                            <h3 class="h4 mb-2">
                                {{ $career->title }}
                            </h3>

                            @if($career->department)
                                <div class="text-secondary">
                                    <i class="bi bi-diagram-3 me-1"></i>
                                    {{ $career->department }}
                                </div>
                            @endif
                        </div>

                        @if($career->status)
                            <span class="badge bg-success">
                                {{ $career->status }}
                            </span>
                        @endif

                    </div>

                    <div class="d-flex flex-wrap gap-3 mb-4 text-secondary">

                        @if($career->location)
                            <span>
                                <i class="bi bi-geo-alt me-1"></i>
                                {{ $career->location }}
                            </span>
                        @endif

                        @if($career->employment_type)
                            <span>
                                <i class="bi bi-briefcase me-1"></i>
                                {{ $career->employment_type }}
                            </span>
                        @endif

                        @if($career->experience)
                            <span>
                                <i class="bi bi-person-badge me-1"></i>
                                {{ $career->experience }}
                            </span>
                        @endif

                    </div>

                    @if($career->description)
                        <p>
                            {{ $career->description }}
                        </p>
                    @endif

                    @if($career->responsibilities)
                        <h5 class="mt-4">
                            Responsibilities
                        </h5>

                        <div class="text-secondary">
                            {!! nl2br(e($career->responsibilities)) !!}
                        </div>
                    @endif

                    @if($career->requirements)
                        <h5 class="mt-4">
                            Requirements
                        </h5>

                        <div class="text-secondary">
                            {!! nl2br(e($career->requirements)) !!}
                        </div>
                    @endif

                    <div class="mt-4 pt-3 border-top">

                        <a
                            href="{{ route('contact') }}"
                            class="btn btn-primary d-inline-flex align-items-center">

                            <i class="bi bi-send me-2"></i>

                            Apply for this Position

                        </a>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">

                <div class="feature-card text-center py-5">

                    <i class="bi bi-briefcase display-4 text-secondary"></i>

                    <h3 class="mt-3">
                        No Open Positions
                    </h3>

                    <p class="text-secondary mb-4">
                        We don't have any open positions at the moment.
                        Please check back later for new opportunities.
                    </p>

                    <a
                        href="{{ route('contact') }}"
                        class="btn btn-primary">

                        <i class="bi bi-envelope me-2"></i>

                        Contact Us

                    </a>

                </div>

            </div>

        @endforelse

    </div>
</section>

<section class="section-block">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="feature-card">

                <div class="text-center">

                    <div class="eyebrow">Stay Connected</div>

                    <h2 class="section-title">
                        Don't See the Right Role?
                    </h2>

                    <p class="section-subtitle">
                        If you believe your skills and experience could add value
                        to Oola Systems, we would still like to hear from you.
                    </p>

                    <a
                        href="{{ route('contact') }}"
                        class="btn btn-primary">

                        <i class="bi bi-envelope me-2"></i>

                        Get in Touch

                    </a>

                </div>

            </div>

        </div>
    </div>
</section>

<section class="section-block">
    <div class="cta-band">
        <h2 class="cta-band__title">
            Build the Future With Us
        </h2>

        <p class="cta-band__subtitle">
            Join us in turning business challenges into scalable,
            intelligent, and sustainable technology solutions.
        </p>

        <a
            href="{{ route('contact') }}"
            class="btn btn-primary">

            Start a Conversation

        </a>
    </div>
</section>

@endsection
