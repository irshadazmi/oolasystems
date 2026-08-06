@extends('layouts.app')

@section('title', 'Custom Software, AI & Cloud Solutions | Oola Systems')

@section('meta_description',
    'Oola Systems delivers enterprise software development, Artificial Intelligence, cloud
    solutions, mobile applications, digital transformation, technology consulting and corporate training.')

@section('content')

    {{-- ========================================================= --}}
    {{-- HERO --}}
    {{-- ========================================================= --}}
    @include('components.home.hero')

    {{-- ========================================================= --}}
    {{-- SERVICES --}}
    {{-- ========================================================= --}}

    @include('components.home.services')

    {{-- ========================================================= --}}
    {{-- INDUSTRIES --}}
    {{-- ========================================================= --}}

    @include('components.home.industries')

    {{-- ========================================================= --}}
    {{-- FEATURED SOLUTIONS --}}
    {{-- ========================================================= --}}

    @include('components.home.portfolio')

    {{-- ========================================================= --}}
    {{-- WHY CHOOSE OOLA --}}
    {{-- ========================================================= --}}

    @include('components.home.whyoola')

    {{-- ========================================================= --}}
    {{-- KNOWLEDGE CENTER --}}
    {{-- ========================================================= --}}

    @include('components.home.resources')

    {{-- ========================================================= --}}
    {{-- CTA --}}
    {{-- ========================================================= --}}

    <section class="section-block">

        <div class="cta-band">

            <h2 class="cta-band__title">

                Ready to Transform Your Business?

            </h2>

            <p class="cta-band__subtitle">

                Whether you're planning a new digital platform, modernizing legacy
                applications, or exploring Artificial Intelligence, our team is
                ready to help.

            </p>

            <a href="{{ route('contact') }}" class="btn btn-primary">

                Schedule a Free Consultation

            </a>

        </div>

    </section>

@endsection
