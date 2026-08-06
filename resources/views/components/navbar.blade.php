@php $currentPath = request()->path(); @endphp

<div class="top-progress-bar" id="topProgressBar" aria-hidden="true"></div>

<header>
    <nav class="oola-navbar" data-nav aria-label="Primary navigation">
        <div class="oola-navbar-container oola-navbar__inner">

            <a class="oola-navbar__brand" href="{{ route('home') }}" aria-label="Oola Systems home page">

                <img src="{{ asset('images/os-logo.png') }}" alt="Oola Systems" class="oola-navbar__logo">

                <span class="oola-navbar__divider"></span>

                <div class="oola-navbar__tagline">

                    <div class="line-1">
                        Transform Your Business
                    </div>

                    <div class="line-2">
                        with Custom Software & AI Automation
                    </div>

                </div>

            </a>

            <ul class="oola-navbar__links d-none d-lg-flex" role="list">
                <li>
                    <a href="{{ route('home') }}"
                        class="oola-navbar__link {{ request()->routeIs('home') ? 'is-active' : '' }}"
                        @if (request()->routeIs('Home')) aria-current="page" @endif>
                        Home
                    </a>
                </li>
                <li class="dropdown">
                    <a class="oola-navbar__link dropdown-toggle {{ request()->routeIs('services') ? 'is-active' : '' }}"
                        href="{{ route('services') }}" id="servicesDropdown" role="button" data-bs-toggle="dropdown"
                        data-bs-display="static" aria-expanded="false"
                        @if (request()->routeIs('services')) aria-current="page" @endif>
                        Services
                    </a>
                    <div class="dropdown-menu oola-dropdown-menu" aria-labelledby="servicesDropdown">
                        <div class="row g-4">
                            <div class="col-12 col-lg-4">
                                <h6 class="oola-dropdown__title">Services We Offer</h6>
                                <ul class="oola-dropdown__list">
                                    <li><a href="{{ route('services') }}#artificial-intelligence">Artificial
                                            Intelligence</a></li>
                                    <li><a href="{{ route('services') }}#software-engineering">Software Engineering</a>
                                    </li>
                                    <li><a href="{{ route('services') }}#cloud">Cloud</a></li>
                                    <li><a href="{{ route('services') }}#data-engineering">Data Engineering</a></li>
                                </ul>
                            </div>
                            <div class="col-12 col-lg-4">
                                <h6 class="oola-dropdown__title">&nbsp;</h6>
                                <ul class="oola-dropdown__list">
                                    <li><a href="{{ route('services') }}#analytics">Analytics</a></li>
                                    <li><a href="{{ route('services') }}#devops">DevOps</a></li>
                                    <li><a href="{{ route('services') }}#technology-consulting">Technology
                                            Consulting</a></li>
                                    <li><a href="{{ route('services') }}#enterprise-applications">Enterprise
                                            Applications</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="dropdown">
                    <a class="oola-navbar__link dropdown-toggle {{ request()->routeIs('industries') ? 'is-active' : '' }}"
                        href="{{ route('industries') }}" id="industriesDropdown" role="button"
                        data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false"
                        @if (request()->routeIs('industries')) aria-current="page" @endif>
                        Industries
                    </a>
                    <div class="dropdown-menu oola-dropdown-menu" aria-labelledby="industriesDropdown">
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <h6 class="oola-dropdown__title">
                                    Industries We Work For
                                </h6>
                                <ul class="oola-dropdown__list">
                                    <li><a href="{{ route('industries') }}#healthcare">Healthcare & Life Sciences</a>
                                    </li>
                                    <li><a href="{{ route('industries') }}#banking">Banking & Financial Services</a>
                                    </li>
                                    <li><a href="{{ route('industries') }}#insurance">Insurance</a></li>
                                    <li><a href="{{ route('industries') }}#retail">Retail & E-commerce</a></li>
                                </ul>
                            </div>
                            <div class="col-12 col-lg-4">
                                <h6 class="oola-dropdown__title">&nbsp;</h6>
                                <ul class="oola-dropdown__list">
                                    <li><a href="{{ route('industries') }}#manufacturing">Manufacturing</a></li>
                                    <li><a href="{{ route('industries') }}#education">Education</a></li>
                                    <li><a href="{{ route('industries') }}#human-resources">Human Resources</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="dropdown">
                    <a class="oola-navbar__link dropdown-toggle {{ request()->routeIs('portfolio') ? 'is-active' : '' }}"
                        href="{{ route('portfolio') }}" id="portfolioDropdown" role="button" data-bs-toggle="dropdown"
                        data-bs-display="static" aria-expanded="false"
                        @if (request()->routeIs('portfolio')) aria-current="page" @endif>
                        Portfolio
                    </a>
                    <div class="dropdown-menu oola-dropdown-menu" aria-labelledby="portfolioDropdown">
                        <div class="row g-4">
                            <div class="col-12 col-lg-6">
                                <h6 class="oola-dropdown__title">Solutions We've Delivered</h6>
                                <ul class="oola-dropdown__list">
                                    <li><a href="{{ route('portfolio') }}#dental">Dental Practice</a></li>
                                    <li><a href="{{ route('portfolio') }}#crm">CRM Platform</a></li>
                                    <li><a href="{{ route('portfolio') }}#payroll">Payroll & HR</a></li>
                                    <li><a href="{{ route('portfolio') }}#aiapps">AI Based Apps</a></li>
                                </ul>
                            </div>
                            <div class="col-12 col-lg-4">
                                <h6 class="oola-dropdown__title">&nbsp;</h6>
                                <ul class="oola-dropdown__list">
                                    <li><a href="{{ route('portfolio') }}#saas">Custom SaaS</a></li>
                                    <li><a href="{{ route('portfolio') }}#ai">Intelligent Automation</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="dropdown">
                    <a class="oola-navbar__link dropdown-toggle {{ request()->routeIs('resources') || request()->is('tutorials/*') ? 'is-active' : '' }}"
                        href="{{ route('resources') }}" id="resourcesDropdown" role="button" data-bs-toggle="dropdown"
                        data-bs-display="static" aria-expanded="false"
                        @if (request()->routeIs('resources') || request()->is('tutorials/*')) aria-current="page" @endif>
                        Resources
                    </a>
                    <div class="dropdown-menu oola-dropdown-menu" aria-labelledby="resourcesDropdown">
                        <div class="row g-4">
                            <div class="col-12 col-lg-4">
                                <h6 class="oola-dropdown__title">React Tutorials</h6>
                                <ul class="oola-dropdown__list">
                                    <li>
                                        <a href="{{ route('tutorial.reactnative.index') }}">
                                            React Native
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-12 col-lg-3">
                                <h6 class="oola-dropdown__title">Java Tutorials</h6>
                                <ul class="oola-dropdown__list">
                                    <li><a href="{{ route('tutorial.javafundamentals.index') }}">Fundamentals</a></li>
                                    <li><a href="{{ route('tutorial.springboot.index') }}">Spring Boot</a></li>
                                </ul>
                            </div>
                            <div class="col-12 col-lg-3">
                                <h6 class="oola-dropdown__title">.NET Tutorials</h6>
                                <ul class="oola-dropdown__list">
                                    <li><a href="{{ route('tutorial.dotnet.fundamental.index') }}"> Fundamentals</a>
                                    </li>
                                    <li><a href="{{ route('tutorial.dotnet.core.index') }}">Web API</a></li>
                                </ul>
                            </div>
                            <div class="col-12 col-lg-3">
                                <h6 class="oola-dropdown__title">Data Engineering</h6>
                                <ul class="oola-dropdown__list">
                                    <li><a href="{{ route('tutorial.gcpdatamodeling.index') }}">Data Modeling</a></li>
                                    <li><a href="{{ route('tutorial.dotnet.database.index') }}">Database</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="row g-4 mt-1">
                            <div class="col-12 col-lg-6">
                                <h6 class="oola-dropdown__title">Test Automation</h6>
                                <ul class="oola-dropdown__list">
                                    <li><a href="{{ route('tutorial.selenium.index') }}">Selenium</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <a href="{{ route('about') }}"
                        class="oola-navbar__link {{ request()->routeIs('about') ? 'is-active' : '' }}"
                        @if (request()->routeIs('about')) aria-current="page" @endif>
                        About
                    </a>
                </li>
                <li>
                    <a href="{{ route('contact') }}"
                        class="oola-navbar__link {{ request()->routeIs('contact') ? 'is-active' : '' }}"
                        @if (request()->routeIs('contact')) aria-current="page" @endif>
                        Contact
                    </a>
                </li>
            </ul>

            <div class="oola-navbar__actions">
                <a href="{{ route('contact') }}" class="btn-oola-primary oola-navbar__cta d-none d-lg-inline-flex">
                    Get In Touch
                </a>

                <button type="button" class="oola-navbar__toggle d-lg-none" onclick="openMenu()"
                    aria-label="Open navigation menu" aria-controls="mobileMenu" aria-expanded="false"
                    aria-haspopup="dialog">
                    <span class="oola-navbar__toggle-bar"></span>
                    <span class="oola-navbar__toggle-bar"></span>
                    <span class="oola-navbar__toggle-bar"></span>
                </button>
            </div>

        </div>
    </nav>
</header>

<!-- MOBILE MENU OVERLAY -->
<div id="mobileMenu" class="oola-mobile-menu" role="dialog" aria-modal="true" aria-label="Mobile navigation"
    tabindex="-1">

    <div class="oola-mobile-menu__header">
        <a href="{{ route('home') }}" class="d-inline-flex" aria-label="Oola Systems home page">
            <img src="{{ asset('images/os-logo.png') }}" alt="Oola Systems" class="oola-mobile-menu__logo">
        </a>
        <button type="button" class="oola-mobile-menu__close" onclick="closeMenu()" aria-label="Close menu">
            <i class="bi bi-x-lg" aria-hidden="true"></i>
        </button>
    </div>

    <div class="accordion oola-mobile-accordion" id="mobileMenuAccordion">
        <!-- Home -->
        <div class="accordion-item">
            <h2 class="accordion-header">
                <a href="{{ route('home') }}"
                    class="accordion-button collapsed {{ request()->routeIs('home') ? 'is-active' : '' }}">Home</a>
            </h2>
        </div>

        <!-- Services -->
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed {{ request()->routeIs('services') ? 'is-active' : '' }}"
                    type="button" data-bs-toggle="collapse" data-bs-target="#collapseServices"
                    aria-expanded="false" aria-controls="collapseServices">
                    Services
                </button>
            </h2>
            <div id="collapseServices" class="accordion-collapse collapse" data-bs-parent="#mobileMenuAccordion">
                <div class="accordion-body">
                    <ul class="list-unstyled">
                        <li><a href="{{ route('services') }}#artificial-intelligence">Artificial Intelligence</a></li>
                        <li><a href="{{ route('services') }}#software-engineering">Software Engineering</a></li>
                        <li><a href="{{ route('services') }}#cloud">Cloud</a></li>
                        <li><a href="{{ route('services') }}#data-engineering">Data Engineering</a></li>
                        <li><a href="{{ route('services') }}#analytics">Analytics</a></li>
                        <li><a href="{{ route('services') }}#devops">DevOps</a></li>
                        <li><a href="{{ route('services') }}#technology-consulting">Technology Consulting</a></li>
                        <li><a href="{{ route('services') }}#enterprise-applications">Enterprise Applications</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Industries -->
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed {{ request()->routeIs('industries') ? 'is-active' : '' }}"
                    type="button" data-bs-toggle="collapse" data-bs-target="#collapseIndustries"
                    aria-expanded="false" aria-controls="collapseIndustries">
                    Industries
                </button>
            </h2>
            <div id="collapseIndustries" class="accordion-collapse collapse" data-bs-parent="#mobileMenuAccordion">
                <div class="accordion-body">
                    <ul class="list-unstyled">
                        <li><a href="{{ route('industries') }}#healthcare">Healthcare</a></li>
                        <li><a href="{{ route('industries') }}#banking">Banking</a></li>
                        <li><a href="{{ route('industries') }}#insurance">Insurance</a></li>
                        <li><a href="{{ route('industries') }}#retail">Retail</a></li>
                        <li><a href="{{ route('industries') }}#manufacturing">Manufacturing</a></li>
                        <li><a href="{{ route('industries') }}#education">Education</a></li>
                        <li><a href="{{ route('industries') }}#human-resources">Human Resources</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Portfolio -->
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed {{ request()->routeIs('portfolio') ? 'is-active' : '' }}"
                    type="button" data-bs-toggle="collapse" data-bs-target="#collapsePortfolio"
                    aria-expanded="false" aria-controls="collapsePortfolio">
                    Portfolio
                </button>
            </h2>
            <div id="collapsePortfolio" class="accordion-collapse collapse" data-bs-parent="#mobileMenuAccordion">
                <div class="accordion-body">
                    <ul class="list-unstyled">
                        <li><a href="{{ route('portfolio') }}#dental">Dental Practice</a></li>
                        <li><a href="{{ route('portfolio') }}#crm">CRM Platform</a></li>
                        <li><a href="{{ route('portfolio') }}#payroll">Payroll & HR</a></li>
                        <li><a href="{{ route('portfolio') }}#aiapps">AI Based Apps</a></li>
                        <li><a href="{{ route('portfolio') }}#saas">Custom SaaS</a></li>
                        <li><a href="{{ route('portfolio') }}#ai">Intelligent Automation</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Resources -->
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button
                    class="accordion-button collapsed {{ request()->routeIs('resources') || request()->is('tutorials/*') ? 'is-active' : '' }}"
                    type="button" data-bs-toggle="collapse" data-bs-target="#collapseResources"
                    aria-expanded="false" aria-controls="collapseResources">
                    Resources
                </button>
            </h2>
            <div id="collapseResources" class="accordion-collapse collapse" data-bs-parent="#mobileMenuAccordion">
                <div class="accordion-body">
                    <ul class="list-unstyled">
                        <li><a href="{{ route('tutorial.reactnative.index') }}">React Native</a></li>
                        <li><a href="{{ route('tutorial.javafundamentals.index') }}">Java</a></li>
                        <li><a href="{{ route('tutorial.springboot.index') }}">Spring Boot</a></li>
                        <li><a href="{{ route('tutorial.dotnet.fundamental.index') }}">.NET Fundamentals</a></li>
                        <li><a href="{{ route('tutorial.dotnet.core.index') }}">.NET Web API</a></li>
                        <li><a href="{{ route('tutorial.dotnet.database.index') }}">Database</a></li>
                        <li><a href="{{ route('tutorial.gcpdatamodeling.index') }}">Data Modeling</a></li>
                        <li><a href="{{ route('tutorial.selenium.index') }}">Selenium</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- About -->
        <div class="accordion-item">
            <h2 class="accordion-header">
                <a href="{{ route('about') }}"
                    class="accordion-button collapsed {{ request()->routeIs('about') ? 'is-active' : '' }}">About</a>
            </h2>
        </div>

        <!-- Contact -->
        <div class="accordion-item">
            <h2 class="accordion-header">
                <a href="{{ route('contact') }}"
                    class="accordion-button collapsed {{ request()->routeIs('contact') ? 'is-active' : '' }}">Contact</a>
            </h2>
        </div>
    </div>

    <a href="{{ route('contact') }}" class="btn-oola-primary oola-mobile-menu__cta">Talk to Our Team</a>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var toggle = document.querySelector('.oola-navbar__toggle');
        var menu = document.getElementById('mobileMenu');
        if (!toggle || !menu) return;

        var observer = new MutationObserver(function() {
            toggle.setAttribute('aria-expanded', menu.classList.contains('active') ? 'true' : 'false');
        });
        observer.observe(menu, {
            attributes: true,
            attributeFilter: ['class']
        });
    });
</script>
