@extends('layouts.app')

@section('title', 'Sitemap | Oola Systems')

@section('meta_description',
    'Explore the Oola Systems website sitemap covering software engineering, Artificial Intelligence, cloud solutions, industries, portfolio, resources, careers, and company information.')

@section('content')

<section class="section-block text-center" id="sitemap">
    <div class="eyebrow">Explore Oola Systems</div>
    <h1 class="page-title">Sitemap</h1>
    <p class="page-subtitle">
        Explore our services, solutions, industry capabilities, technology resources,
        company information, and other important areas of the Oola Systems website.
    </p>
</section>

<section class="section-block" id="main-navigation">
    <div class="text-center mb-5">
        <div class="eyebrow">Start Here</div>
        <h2 class="section-title">Main Navigation</h2>
        <p class="section-subtitle">
            Discover the core areas of Oola Systems.
        </p>
    </div>

    <div class="row gx-3 gy-4">
        <div class="col-md-6 col-lg-4">
            <div class="feature-card h-100">
                <h3 class="h5">
                    <i class="bi bi-house text-primary me-2"></i>
                    <a href="{{ route('home') }}" class="text-decoration-none">
                        Home
                    </a>
                </h3>
                <p class="mb-0">
                    Overview of Oola Systems, our capabilities, services,
                    industries, solutions, resources, and approach.
                </p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="feature-card h-100">
                <h3 class="h5">
                    <i class="bi bi-building text-primary me-2"></i>
                    <a href="{{ route('about') }}" class="text-decoration-none">
                        About Oola Systems
                    </a>
                </h3>
                <p class="mb-0">
                    Learn about our vision, technology expertise, approach,
                    leadership, and commitment to delivering business value.
                </p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="feature-card h-100">
                <h3 class="h5">
                    <i class="bi bi-envelope text-primary me-2"></i>
                    <a href="{{ route('contact') }}" class="text-decoration-none">
                        Contact
                    </a>
                </h3>
                <p class="mb-0">
                    Discuss your project, business challenge, technology
                    requirements, partnership opportunity, or other enquiry.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="section-block" id="services">
    <div class="text-center mb-5">
        <div class="eyebrow">What We Do</div>
        <h2 class="section-title">Services</h2>
        <p class="section-subtitle">
            Technology services designed to help organizations build,
            modernize, scale, and transform their digital capabilities.
        </p>
    </div>

    <div class="row gx-3 gy-4">
        <div class="col-md-6 col-lg-4">
            <div class="feature-card h-100">
                <h3 class="h5">
                    <i class="bi bi-code-slash text-primary me-2"></i>
                    Enterprise Software Development
                </h3>
                <p class="mb-0">
                    Scalable enterprise applications, APIs, platforms,
                    modernization, and software engineering solutions.
                </p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="feature-card h-100">
                <h3 class="h5">
                    <i class="bi bi-robot text-primary me-2"></i>
                    Artificial Intelligence
                </h3>
                <p class="mb-0">
                    AI-powered applications, intelligent automation,
                    Agentic AI, conversational experiences, and enterprise AI.
                </p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="feature-card h-100">
                <h3 class="h5">
                    <i class="bi bi-cloud text-primary me-2"></i>
                    Cloud Solutions
                </h3>
                <p class="mb-0">
                    Cloud architecture, migration, modernization,
                    application platforms, and scalable cloud solutions.
                </p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="feature-card h-100">
                <h3 class="h5">
                    <i class="bi bi-phone text-primary me-2"></i>
                    Mobile Application Development
                </h3>
                <p class="mb-0">
                    Modern mobile applications and cross-platform experiences
                    designed around business and customer needs.
                </p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="feature-card h-100">
                <h3 class="h5">
                    <i class="bi bi-database text-primary me-2"></i>
                    Data Engineering & Analytics
                </h3>
                <p class="mb-0">
                    Data platforms, pipelines, modeling, analytics,
                    reporting, and data-driven business solutions.
                </p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="feature-card h-100">
                <h3 class="h5">
                    <i class="bi bi-diagram-3 text-primary me-2"></i>
                    Technology Consulting
                </h3>
                <p class="mb-0">
                    Architecture, technology strategy, digital transformation,
                    modernization, and enterprise technology consulting.
                </p>
            </div>
        </div>
    </div>

    <div class="text-center mt-5">
        <a href="{{ route('services') }}" class="btn btn-primary">
            <i class="bi bi-arrow-right me-2"></i>
            Explore All Services
        </a>
    </div>
</section>

<section class="section-block" id="industries">
    <div class="text-center mb-5">
        <div class="eyebrow">Industry Expertise</div>
        <h2 class="section-title">Industries</h2>
        <p class="section-subtitle">
            Technology expertise applied to industry-specific business
            challenges and transformation initiatives.
        </p>
    </div>

    <div class="row gx-3 gy-4">
        <div class="col-md-6 col-lg-4">
            <div class="feature-card h-100">
                <h3 class="h5">
                    <i class="bi bi-bank text-primary me-2"></i>
                    Banking & Financial Services
                </h3>
                <p class="mb-0">
                    Digital platforms, data solutions, AI, modernization,
                    and enterprise technology for financial organizations.
                </p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="feature-card h-100">
                <h3 class="h5">
                    <i class="bi bi-heart-pulse text-primary me-2"></i>
                    Healthcare
                </h3>
                <p class="mb-0">
                    Technology solutions supporting healthcare applications,
                    data, digital experiences, and operational transformation.
                </p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="feature-card h-100">
                <h3 class="h5">
                    <i class="bi bi-cart3 text-primary me-2"></i>
                    Retail & E-Commerce
                </h3>
                <p class="mb-0">
                    Digital commerce, customer experiences, analytics,
                    automation, and scalable technology platforms.
                </p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="feature-card h-100">
                <h3 class="h5">
                    <i class="bi bi-building-check text-primary me-2"></i>
                    Enterprise & Technology
                </h3>
                <p class="mb-0">
                    Enterprise modernization, cloud transformation,
                    software engineering, and technology strategy.
                </p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="feature-card h-100">
                <h3 class="h5">
                    <i class="bi bi-truck text-primary me-2"></i>
                    Logistics & Transportation
                </h3>
                <p class="mb-0">
                    Technology platforms, data, automation, and digital
                    solutions for transportation and logistics operations.
                </p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="feature-card h-100">
                <h3 class="h5">
                    <i class="bi bi-grid text-primary me-2"></i>
                    Other Industries
                </h3>
                <p class="mb-0">
                    Flexible technology consulting and engineering capabilities
                    tailored to specific organizational requirements.
                </p>
            </div>
        </div>
    </div>

    <div class="text-center mt-5">
        <a href="{{ route('industries') }}" class="btn btn-primary">
            <i class="bi bi-arrow-right me-2"></i>
            Explore Industries
        </a>
    </div>
</section>

<section class="section-block" id="solutions">
    <div class="text-center mb-5">
        <div class="eyebrow">Featured Work</div>
        <h2 class="section-title">Solutions & Portfolio</h2>
        <p class="section-subtitle">
            Explore selected solutions, technology initiatives, and
            practical applications of our engineering capabilities.
        </p>
    </div>

    <div class="row gx-3 gy-4">
        <div class="col-md-6 col-lg-4">
            <div class="feature-card h-100">
                <h3 class="h5">
                    <i class="bi bi-briefcase text-primary me-2"></i>
                    <a href="{{ route('portfolio') }}" class="text-decoration-none">
                        Portfolio
                    </a>
                </h3>
                <p class="mb-0">
                    Explore selected projects and technology solutions
                    demonstrating our engineering and transformation expertise.
                </p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="feature-card h-100">
                <h3 class="h5">
                    <i class="bi bi-layers text-primary me-2"></i>
                    Digital Transformation
                </h3>
                <p class="mb-0">
                    Modernization and transformation approaches that connect
                    business strategy with scalable technology architecture.
                </p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="feature-card h-100">
                <h3 class="h5">
                    <i class="bi bi-stars text-primary me-2"></i>
                    AI-Powered Solutions
                </h3>
                <p class="mb-0">
                    Intelligent applications and enterprise AI capabilities
                    designed to improve productivity, insight, and experiences.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="section-block" id="knowledge-center">
    <div class="text-center mb-5">
        <div class="eyebrow">Knowledge Center</div>
        <h2 class="section-title">Resources & Learning</h2>
        <p class="section-subtitle">
            Practical technology knowledge for developers, architects,
            engineering teams, and technology professionals.
        </p>
    </div>

    <div class="row gx-3 gy-4">
        <div class="col-md-6 col-lg-4">
            <div class="feature-card h-100">
                <h3 class="h5">
                    <i class="bi bi-journal-text text-primary me-2"></i>
                    <a href="{{ route('resources') }}" class="text-decoration-none">
                        Resources
                    </a>
                </h3>
                <p class="mb-0">
                    Articles, guides, reference material, and technology
                    resources covering modern enterprise development.
                </p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="feature-card h-100">
                <h3 class="h5">
                    <i class="bi bi-mortarboard text-primary me-2"></i>
                    Training & Workshops
                </h3>
                <p class="mb-0">
                    Professional learning programs and workshops covering
                    modern software engineering and emerging technologies.
                </p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="feature-card h-100">
                <h3 class="h5">
                    <i class="bi bi-code-square text-primary me-2"></i>
                    Tutorials
                </h3>
                <p class="mb-0">
                    Practical, structured learning content for developers,
                    architects, testers, and technology professionals.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="section-block" id="tutorials">
    <div class="text-center mb-5">
        <div class="eyebrow">Technical Learning</div>
        <h2 class="section-title">Tutorials</h2>
        <p class="section-subtitle">
            Explore our technology learning tracks and practical tutorials.
        </p>
    </div>

    <div class="row gx-3 gy-4">
        <div class="col-md-6 col-lg-4">
            <div class="feature-card h-100">
                <h3 class="h5">
                    <i class="bi bi-robot text-primary me-2"></i>
                    <a href="{{ route('tutorial.agenticai.index') }}" class="text-decoration-none">
                        Agentic AI
                    </a>
                </h3>
                <p class="mb-0">
                    Foundations and enterprise practices for building
                    intelligent, goal-oriented AI agents.
                </p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="feature-card h-100">
                <h3 class="h5">
                    <i class="bi bi-cup-hot text-primary me-2"></i>
                    <a href="{{ route('tutorial.javafundamentals.index') }}" class="text-decoration-none">
                        Java Fundamentals
                    </a>
                </h3>
                <p class="mb-0">
                    Core Java programming, object-oriented concepts,
                    collections, exceptions, and application development.
                </p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="feature-card h-100">
                <h3 class="h5">
                    <i class="bi bi-phone text-primary me-2"></i>
                    <a href="{{ route('tutorial.reactnative.index') }}" class="text-decoration-none">
                        React Native
                    </a>
                </h3>
                <p class="mb-0">
                    Practical mobile application development using
                    React Native and modern cross-platform practices.
                </p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="feature-card h-100">
                <h3 class="h5">
                    <i class="bi bi-cloud text-primary me-2"></i>
                    <a href="{{ route('tutorial.gcpdatamodeling.index') }}" class="text-decoration-none">
                        GCP Data Modeling
                    </a>
                </h3>
                <p class="mb-0">
                    Enterprise data modeling and architecture concepts
                    for Google Cloud environments.
                </p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="feature-card h-100">
                <h3 class="h5">
                    <i class="bi bi-check2-square text-primary me-2"></i>
                    <a href="{{ route('tutorial.selenium.index') }}" class="text-decoration-none">
                        Selenium
                    </a>
                </h3>
                <p class="mb-0">
                    Web automation and test engineering practices
                    using Selenium.
                </p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="feature-card h-100">
                <h3 class="h5">
                    <i class="bi bi-diagram-2 text-primary me-2"></i>
                    <a href="{{ route('tutorial.springboot.index') }}" class="text-decoration-none">
                        Spring Boot
                    </a>
                </h3>
                <p class="mb-0">
                    Modern Java backend development using Spring Boot
                    and enterprise application architecture.
                </p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="feature-card h-100">
                <h3 class="h5">
                    <i class="bi bi-braces text-primary me-2"></i>
                    <a href="{{ route('tutorial.dotnet.fundamental.index') }}" class="text-decoration-none">
                        .NET
                    </a>
                </h3>
                <p class="mb-0">
                    Modern .NET development, Web APIs, architecture,
                    and enterprise application development.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="section-block" id="company">
    <div class="text-center mb-5">
        <div class="eyebrow">Company</div>
        <h2 class="section-title">Oola Systems</h2>
        <p class="section-subtitle">
            Learn more about our organization and opportunities to work with us.
        </p>
    </div>

    <div class="row gx-3 gy-4 justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="feature-card h-100">
                <h3 class="h5">
                    <i class="bi bi-people text-primary me-2"></i>
                    <a href="{{ route('about') }}" class="text-decoration-none">
                        About Us
                    </a>
                </h3>
                <p class="mb-0">
                    Our vision, capabilities, engineering approach,
                    and technology leadership.
                </p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="feature-card h-100">
                <h3 class="h5">
                    <i class="bi bi-person-workspace text-primary me-2"></i>
                    <a href="{{ route('careers') }}" class="text-decoration-none">
                        Careers
                    </a>
                </h3>
                <p class="mb-0">
                    Explore opportunities to work with Oola Systems
                    on modern technology and transformation initiatives.
                </p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="feature-card h-100">
                <h3 class="h5">
                    <i class="bi bi-chat-dots text-primary me-2"></i>
                    <a href="{{ route('contact') }}" class="text-decoration-none">
                        Contact Us
                    </a>
                </h3>
                <p class="mb-0">
                    Start a conversation about your project,
                    technology challenge, or business requirement.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="section-block" id="legal">
    <div class="text-center mb-5">
        <div class="eyebrow">Legal</div>
        <h2 class="section-title">Legal & Policies</h2>
        <p class="section-subtitle">
            Important information governing use of the Oola Systems website.
        </p>
    </div>

    <div class="row gx-3 gy-4 justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="feature-card h-100">
                <h3 class="h5">
                    <i class="bi bi-shield-check text-primary me-2"></i>
                    <a href="{{ route('privacy') }}" class="text-decoration-none">
                        Privacy Policy
                    </a>
                </h3>
                <p class="mb-0">
                    Information about how Oola Systems collects,
                    uses, protects, and manages personal information.
                </p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="feature-card h-100">
                <h3 class="h5">
                    <i class="bi bi-file-earmark-text text-primary me-2"></i>
                    <a href="{{ route('terms') }}" class="text-decoration-none">
                        Terms of Use
                    </a>
                </h3>
                <p class="mb-0">
                    Terms and conditions governing access to and use
                    of the Oola Systems website.
                </p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="feature-card h-100">
                <h3 class="h5">
                    <i class="bi bi-diagram-3 text-primary me-2"></i>
                    Sitemap
                </h3>
                <p class="mb-0">
                    You are currently viewing the complete website
                    navigation and content structure.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="section-block">
    <div class="cta-band">
        <h2 class="cta-band__title">
            Ready to Explore What's Possible?
        </h2>
        <p class="cta-band__subtitle">
            Whether you are planning a new digital platform, modernizing
            existing systems, or exploring Artificial Intelligence,
            our team is ready to help.
        </p>
        <a href="{{ route('contact') }}" class="btn btn-primary">
            <i class="bi bi-arrow-right me-2"></i>
            Schedule a Free Consultation
        </a>
    </div>
</section>

@endsection
