@extends('layouts.app')

@section('title', 'Industries | Oola Systems')
@section('meta_description',
    'Oola Systems delivers AI, cloud, software engineering, data, and enterprise solutions
    across healthcare, banking, retail, manufacturing, education, logistics, HR, and government.')

@section('content')

    <section class="section-block text-center">

        <div class="eyebrow">
            Industries We Serve
        </div>

        <h1 class="page-title">
            Industry expertise backed by
            modern technology solutions
        </h1>

        <p class="page-subtitle">

            Every industry has its own operational challenges, regulatory requirements,
            customer expectations, and competitive pressures. Oola Systems combines
            deep technology expertise with an understanding of industry-specific
            business processes to deliver secure, scalable, and outcome-driven digital
            solutions tailored to your organization's unique needs.

        </p>

    </section>

    <section class="section-block">
        <div class="row gx-3 gy-4">
            <!-- Healthcare -->
            <div class="col-lg-6" id="healthcare">
                <div class="feature-card h-100">

                    <h2 class="h4">Healthcare & Life Sciences</h2>

                    <div class="mt-3">

                        <p><strong>Industry Challenges</strong><br>
                            Delivering high-quality patient care while maintaining regulatory
                            compliance, protecting sensitive health information, and improving
                            operational efficiency.
                        </p>

                        <p><strong>How We Help</strong><br>
                            We help healthcare providers digitize clinical and administrative
                            processes through secure, scalable solutions that improve patient
                            engagement and streamline healthcare operations.
                        </p>

                        <p><strong>Typical Solutions</strong><br>
                            Hospital Information Systems, Dental Practice Management,
                            Patient Portals, Appointment Scheduling,
                            Billing, Electronic Medical Record Integration.
                        </p>

                        <p><strong>Key Technologies</strong><br>
                            AI, Cloud, Mobile Applications,
                            APIs, Analytics, Enterprise Platforms.
                        </p>

                    </div>

                    <a href="{{ route('contact') }}" class="btn btn-primary mt-4">
                        Explore Healthcare Solutions
                    </a>

                </div>
            </div>

            <!-- Banking -->
            <div class="col-lg-6" id="banking">
                <div class="feature-card h-100">

                    <h2 class="h4">Banking & Financial Services</h2>

                    <div class="mt-3">

                        <p><strong>Industry Challenges</strong><br>
                            Balancing digital innovation with regulatory compliance,
                            cybersecurity, fraud prevention, and exceptional customer experiences.
                        </p>

                        <p><strong>How We Help</strong><br>
                            We enable financial institutions to modernize customer services,
                            automate business processes, and improve operational resilience
                            through secure digital platforms.
                        </p>

                        <p><strong>Typical Solutions</strong><br>
                            Digital Banking, Loan Processing,
                            Customer Portals, Risk Management,
                            Compliance Reporting, Analytics.
                        </p>

                        <p><strong>Key Technologies</strong><br>
                            Secure APIs, Cloud, AI,
                            Enterprise Applications, Analytics.
                        </p>

                    </div>

                    <a href="{{ route('contact') }}" class="btn btn-primary mt-4">
                        Explore Banking Solutions
                    </a>

                </div>
            </div>

            <!-- Insurance -->
            <div class="col-lg-6" id="insurance">
                <div class="feature-card h-100">
                    <h2 class="h4">Insurance</h2>
                    <div class="mt-3">
                        <p><strong>Industry Challenges</strong><br>
                            Claims automation, customer self-service,
                            policy administration, and fraud detection.
                        </p>
                        <p><strong>How We Help</strong><br>
                            We modernize insurance operations with digital platforms,
                            workflow automation, and AI-powered decision support.
                        </p>
                        <p><strong>Typical Solutions</strong><br>
                            Claims Management, Policy Administration,
                            Customer Portals, Document Processing.
                        </p>
                        <p><strong>Technologies</strong><br>
                            AI, Cloud, APIs, Workflow Automation, Analytics.
                        </p>
                    </div>

                    <a href="{{ route('contact') }}" class="btn btn-primary mt-4">
                        Explore Insurance Solutions
                    </a>
                </div>
            </div>

            <!-- Retail -->
            <div class="col-lg-6" id="retail">
                <div class="feature-card h-100">
                    <h2 class="h4">Retail & E-Commerce</h2>
                    <div class="mt-3">
                        <p><strong>Industry Challenges</strong><br>
                            Omnichannel customer experiences, inventory visibility,
                            and personalized shopping journeys.
                        </p>
                        <p><strong>How We Help</strong><br>
                            We build commerce platforms, customer engagement solutions,
                            and AI-driven retail experiences.
                        </p>
                        <p><strong>Typical Solutions</strong><br>
                            E-Commerce, Inventory Management,
                            CRM, Loyalty Programs, Mobile Commerce.
                        </p>
                        <p><strong>Technologies</strong><br>
                            Laravel, React, Cloud, Payment APIs, AI.
                        </p>
                    </div>

                    <a href="{{ route('contact') }}" class="btn btn-primary mt-4">
                        Explore Retail Solutions
                    </a>
                </div>
            </div>

            <!-- Manufacturing -->
            <div class="col-lg-6" id="manufacturing">
                <div class="feature-card h-100">
                    <h2 class="h4">Manufacturing</h2>
                    <div class="mt-3">
                        <p><strong>Industry Challenges</strong><br>
                            Production efficiency, supply chain visibility,
                            quality control, and operational optimization.
                        </p>
                        <p><strong>How We Help</strong><br>
                            We develop enterprise systems that improve production,
                            planning, reporting, and operational efficiency.
                        </p>
                        <p><strong>Typical Solutions</strong><br>
                            ERP, Inventory, Production Tracking,
                            Supplier Portals, Analytics.
                        </p>
                        <p><strong>Technologies</strong><br>
                            Cloud, APIs, BI, AI, Enterprise Applications.
                        </p>
                    </div>

                    <a href="{{ route('contact') }}" class="btn btn-primary mt-4">
                        Explore Manufacturing Solutions
                    </a>
                </div>
            </div>

            <!-- Education -->
            <div class="col-lg-6" id="education">
                <div class="feature-card h-100">
                    <h2 class="h4">Education</h2>
                    <div class="mt-3">
                        <p><strong>Industry Challenges</strong><br>
                            Digital learning, student engagement,
                            administration, and academic collaboration.
                        </p>
                        <p><strong>How We Help</strong><br>
                            We build secure digital learning platforms,
                            portals, and collaborative education systems.
                        </p>
                        <p><strong>Typical Solutions</strong><br>
                            LMS, Student Portals,
                            Assessments, Mobile Learning.
                        </p>
                        <p><strong>Technologies</strong><br>
                            Laravel, React, Mobile Apps, Cloud.
                        </p>
                    </div>

                    <a href="{{ route('contact') }}" class="btn btn-primary mt-4">
                        Explore Education Solutions
                    </a>
                </div>
            </div>

            <!-- Logistics -->
            <div class="col-lg-6" id="logistics">
                <div class="feature-card h-100">
                    <h2 class="h4">Logistics & Transportation</h2>
                    <div class="mt-3">
                        <p><strong>Industry Challenges</strong><br>
                            Shipment visibility, fleet utilization,
                            warehouse optimization, and real-time tracking.
                        </p>
                        <p><strong>How We Help</strong><br>
                            We develop intelligent logistics solutions
                            that improve efficiency and operational visibility.
                        </p>
                        <p><strong>Typical Solutions</strong><br>
                            Fleet Management,
                            Shipment Tracking,
                            Warehouse Systems,
                            Route Optimization.
                        </p>
                        <p><strong>Technologies</strong><br>
                            GPS APIs, Mobile Apps, Cloud, AI.
                        </p>
                    </div>

                    <a href="{{ route('contact') }}" class="btn btn-primary mt-4">
                        Explore Logistics Solutions
                    </a>
                </div>
            </div>

            <!-- HR -->
            <div class="col-lg-6" id="human-resources">
                <div class="feature-card h-100">
                    <h2 class="h4">Human Resources & Enterprise Operations</h2>
                    <div class="mt-3">
                        <p><strong>Industry Challenges</strong><br>
                            Employee lifecycle management,
                            payroll automation,
                            workforce productivity,
                            and compliance.
                        </p>
                        <p><strong>How We Help</strong><br>
                            We build enterprise HR platforms that streamline
                            recruitment, payroll, attendance, and performance management.
                        </p>
                        <p><strong>Typical Solutions</strong><br>
                            HRMS, Payroll,
                            Recruitment,
                            Employee Self-Service,
                            Performance Management.
                        </p>
                        <p><strong>Technologies</strong><br>
                            Laravel, .NET, APIs, Cloud, Analytics.
                        </p>
                    </div>

                    <a href="{{ route('contact') }}" class="btn btn-primary mt-4">
                        Explore HR Solutions
                    </a>
                </div>
            </div>

        </div>
    </section>

    <section class="section-block">

        <div class="cta-band">

            <div class="eyebrow mb-3">
                Let's Build Your Industry Advantage
            </div>

            <h2 class="cta-band__title">
                Technology solutions designed for your industry
            </h2>

            <p class="cta-band__subtitle">

                Every organization faces unique industry challenges. Whether you're improving
                customer experiences, modernizing legacy systems, streamlining operations,
                or accelerating digital transformation, Oola Systems delivers practical,
                secure, and scalable solutions tailored to your business.

            </p>

            <div class="page-actions justify-content-center gap-3 mt-4">

                <a href="{{ route('contact') }}" class="btn btn-primary">
                    Discuss Your Industry Needs
                </a>

                <a href="{{ route('services') }}" class="btn btn-outline-light">
                    Explore Our Services
                </a>

            </div>

        </div>

    </section>
@endsection
