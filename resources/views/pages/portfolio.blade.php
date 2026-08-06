@extends('layouts.app')

@section('title', 'Case Studies | Oola Systems')
@section('meta_description',
    'Explore engineering case studies covering healthcare, CRM, HR, AI, SaaS, and enterprise
    modernization engagements.')

@section('content')
    <section class="section-block text-center">

        <div class="eyebrow">
            Success Stories
        </div>

        <h1 class="page-title">
            Proven solutions that deliver
            measurable business outcomes
        </h1>

        <p class="page-subtitle">

            Every engagement reflects our commitment to solving real business
            challenges through thoughtful architecture, modern engineering,
            and practical technology solutions. From healthcare and financial
            services to enterprise operations and AI-driven platforms, our
            portfolio demonstrates how we help organizations innovate,
            modernize, and grow with confidence.

        </p>

    </section>

    <section class="section-block">
        <div class="row gx-3 gy-4">
            <div class="col-lg-6" id="dental">

                <article class="feature-card h-100">

                    <h2 class="h4">
                        Dental Practice Management System
                    </h2>

                    <p class="text-primary fw-semibold mb-3">
                        Healthcare & Life Sciences
                    </p>

                    <div class="mt-3">

                        <p>

                            <strong>Business Challenge</strong><br>

                            The client needed to replace fragmented clinical and
                            administrative processes with a unified platform that
                            improved operational efficiency and enhanced patient
                            experience.

                        </p>

                        <p>

                            <strong>Our Solution</strong><br>

                            We designed and developed a centralized practice
                            management platform integrating appointments,
                            patient records, billing, scheduling, and operational
                            workflows into a secure, scalable solution.

                        </p>

                        <p>

                            <strong>Business Impact</strong><br>

                            Reduced administrative effort, improved clinic
                            productivity, enhanced patient service,
                            and established a scalable digital foundation
                            for future growth.

                        </p>

                        <p>

                            <strong>Technologies Used</strong><br>

                            Laravel, React, MySQL,
                            REST APIs,
                            Cloud Infrastructure.

                        </p>

                    </div>

                    <a href="{{ route('contact') }}" class="btn btn-primary mt-4">

                        Discuss a Similar Project

                    </a>

                </article>

            </div>

            <div class="col-lg-6" id="crm">

                <article class="feature-card h-100">

                    <h2 class="h4">
                        Customer Relationship Management (CRM) Platform
                    </h2>

                    <p class="text-primary fw-semibold mb-3">
                        Business Services & Sales Operations
                    </p>

                    <div class="mt-3">

                        <p>
                            <strong>Business Challenge</strong><br>
                            Customer information was fragmented across multiple systems,
                            making it difficult to maintain a unified customer view,
                            manage sales opportunities efficiently, and deliver
                            consistent customer engagement.
                        </p>

                        <p>
                            <strong>Our Solution</strong><br>
                            We designed and developed a centralized CRM platform that
                            unified customer data, streamlined sales workflows,
                            automated lead management, and provided real-time reporting
                            to improve collaboration across sales and customer service teams.
                        </p>

                        <p>
                            <strong>Business Impact</strong><br>
                            Improved customer visibility, accelerated sales processes,
                            enhanced team collaboration, and enabled data-driven decision
                            making that supported sustainable business growth.
                        </p>

                        <p>
                            <strong>Technologies Used</strong><br>
                            Laravel, React, MySQL,
                            REST APIs,
                            Analytics Dashboards,
                            Cloud Infrastructure.
                        </p>

                    </div>

                    <a href="{{ route('contact') }}" class="btn btn-primary mt-4">

                        Discuss a Similar Project

                    </a>

                </article>

            </div>

            <div class="col-lg-6" id="payroll">

                <article class="feature-card h-100">

                    <h2 class="h4">
                        Payroll & Human Resource Management System
                    </h2>

                    <p class="text-primary fw-semibold mb-3">
                        Human Resources & Enterprise Operations
                    </p>

                    <div class="mt-3">

                        <p>
                            <strong>Business Challenge</strong><br>
                            Manual payroll processing, fragmented employee records, and
                            repetitive HR administration increased processing time,
                            reduced operational efficiency, and made regulatory
                            compliance more difficult.
                        </p>

                        <p>
                            <strong>Our Solution</strong><br>
                            We designed and implemented a centralized HR and Payroll
                            Management System that automated payroll processing,
                            employee lifecycle management, attendance, reporting,
                            and administrative workflows within a secure enterprise platform.
                        </p>

                        <p>
                            <strong>Business Impact</strong><br>
                            Reduced payroll processing time, improved data accuracy,
                            strengthened compliance, and provided HR teams with
                            greater operational visibility and workforce productivity.
                        </p>

                        <p>
                            <strong>Technologies Used</strong><br>
                            Laravel, MySQL,
                            Role-Based Access Control,
                            Reporting & Analytics,
                            Cloud Infrastructure.
                        </p>

                    </div>

                    <a href="{{ route('contact') }}" class="btn btn-primary mt-4">

                        Discuss a Similar Project

                    </a>

                </article>

            </div>

            <div class="col-lg-6" id="ai-applications">

                <article class="feature-card h-100">

                    <h2 class="h4">
                        AI-Powered Expense Management Platform
                    </h2>

                    <p class="text-primary fw-semibold mb-3">
                        Finance & Business Operations
                    </p>

                    <div class="mt-3">

                        <p>
                            <strong>Business Challenge</strong><br>
                            Manual expense capture, categorization, and approval workflows
                            were time-consuming, error-prone, and lacked the intelligence
                            needed to support growing business operations.
                        </p>

                        <p>
                            <strong>Our Solution</strong><br>
                            We developed an AI-powered expense management platform that
                            automates expense categorization, provides intelligent insights,
                            enables natural language interactions, supports voice input,
                            and delivers real-time reporting through a modern mobile-first
                            experience.
                        </p>

                        <p>
                            <strong>Business Impact</strong><br>
                            Reduced manual effort, accelerated expense processing,
                            improved financial visibility, enhanced user experience,
                            and enabled smarter decision-making through AI-driven
                            automation and analytics.
                        </p>

                        <p>
                            <strong>Technologies Used</strong><br>
                            React Native, FastAPI, PostgreSQL,
                            Artificial Intelligence, Generative AI,
                            Ollama, Vector Database,
                            REST APIs, Cloud Infrastructure.
                        </p>

                    </div>

                    <a href="{{ route('contact') }}" class="btn btn-primary mt-4">

                        Discuss a Similar Project

                    </a>

                </article>

            </div>

            <div class="col-lg-6" id="saas">

                <article class="feature-card h-100">

                    <h2 class="h4">
                        Custom SaaS Platform
                    </h2>

                    <p class="text-primary fw-semibold mb-3">
                        Technology & SaaS Products
                    </p>

                    <div class="mt-3">

                        <p>
                            <strong>Business Challenge</strong><br>
                            The client required a secure, scalable, and multi-tenant SaaS
                            platform capable of supporting rapid business growth while
                            maintaining performance, reliability, and ease of future
                            enhancements.
                        </p>

                        <p>
                            <strong>Our Solution</strong><br>
                            We designed and developed a cloud-native SaaS platform with
                            modular architecture, secure tenant isolation, API-first
                            integration, role-based access control, and automated deployment
                            capabilities to support continuous product evolution.
                        </p>

                        <p>
                            <strong>Business Impact</strong><br>
                            Enabled faster product delivery, improved platform scalability,
                            reduced operational complexity, and established a robust
                            foundation for long-term product innovation and customer growth.
                        </p>

                        <p>
                            <strong>Technologies Used</strong><br>
                            React, Angular, .NET, Node.js,
                            Microsoft Azure, AWS,
                            Docker, Kubernetes,
                            REST APIs, CI/CD Pipelines.
                        </p>

                    </div>

                    <a href="{{ route('contact') }}" class="btn btn-primary mt-4">

                        Discuss a Similar Project

                    </a>

                </article>

            </div>

            <div class="col-lg-6" id="ai-integration">

                <article class="feature-card h-100">

                    <h2 class="h4">
                        Enterprise AI Integration & Intelligent Automation
                    </h2>

                    <p class="text-primary fw-semibold mb-3">
                        Enterprise Digital Transformation
                    </p>

                    <div class="mt-3">

                        <p>
                            <strong>Business Challenge</strong><br>
                            Business teams needed to improve operational efficiency and
                            decision-making by introducing Artificial Intelligence into
                            existing enterprise applications without disrupting established
                            business processes or compromising governance.
                        </p>

                        <p>
                            <strong>Our Solution</strong><br>
                            We seamlessly integrated Generative AI, intelligent automation,
                            conversational assistants, document processing, and predictive
                            insights into enterprise workflows, enabling organizations to
                            modernize operations while preserving existing business systems
                            and investments.
                        </p>

                        <p>
                            <strong>Business Impact</strong><br>
                            Reduced repetitive manual work, accelerated business processes,
                            improved decision quality, increased employee productivity,
                            and established a scalable foundation for enterprise-wide
                            AI adoption.
                        </p>

                        <p>
                            <strong>Technologies Used</strong><br>
                            Python, FastAPI, OpenAI,
                            Azure AI, Ollama,
                            LangChain, Vector Databases,
                            REST APIs, Cloud Services,
                            AI Agents, RAG.
                        </p>

                    </div>

                    <a href="{{ route('contact') }}" class="btn btn-primary mt-4">

                        Discuss a Similar Project

                    </a>

                </article>

            </div>
        </div>
    </section>

    <section class="section-block">

        <div class="cta-band">

            <div class="eyebrow mb-3">
                Let's Build Your Success Story
            </div>

            <h2 class="cta-band__title">
                Ready to turn your next technology initiative into a success story?
            </h2>

            <p class="cta-band__subtitle">

                Whether you're developing a custom enterprise application,
                modernizing legacy systems, implementing Artificial Intelligence,
                or building a scalable cloud platform, Oola Systems brings the
                experience, engineering expertise, and delivery discipline needed
                to transform ideas into measurable business outcomes.

            </p>

            <div class="page-actions justify-content-center gap-3 mt-4">

                <a href="{{ route('contact') }}" class="btn btn-primary">

                    Discuss Your Project

                </a>

                <a href="{{ route('services') }}" class="btn btn-outline-light">

                    Explore Our Services

                </a>

            </div>

        </div>

    </section>
@endsection
