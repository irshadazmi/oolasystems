@extends('layouts.app')

@section('title', 'Services | Oola Systems')
@section('meta_description',
    'Explore Oola Systems services in artificial intelligence, software engineering, cloud,
    data, analytics, DevOps, technology consulting, and enterprise applications.')

@section('content')
    <section class="section-block text-center">

        <div class="eyebrow">
            Our Services
        </div>

        <h1 class="page-title">
            Technology capabilities that solve
            complex business challenges
        </h1>

        <p class="page-subtitle">

            From Artificial Intelligence and enterprise software engineering to cloud,
            data, analytics, DevOps, and strategic technology consulting, our services
            help organizations modernize operations, accelerate innovation, and build
            secure, scalable digital platforms that create measurable business value.

        </p>

    </section>

    <section class="section-block" id="service-overview">
        <div class="row gx-3 gy-4">
            <div class="col-lg-6">
                <div class="feature-card h-100" id="artificial-intelligence">

                    <h2 class="h4">Artificial Intelligence</h2>

                    <div class="mt-3">

                        <p>
                            <strong>Business Challenge</strong><br>
                            Organizations struggle to transform growing volumes of data into
                            timely decisions, intelligent automation, and meaningful customer
                            experiences.
                        </p>

                        <p>
                            <strong>Our Approach</strong><br>
                            We design AI-powered solutions including intelligent assistants,
                            workflow automation, knowledge discovery, predictive analytics,
                            and Generative AI integrations tailored to business objectives.
                        </p>

                        <p>
                            <strong>Business Outcomes</strong><br>
                            Faster decision-making, improved productivity, reduced manual effort,
                            and scalable intelligent business processes.
                        </p>

                        <p>
                            <strong>Key Technologies</strong><br>
                            Python, Azure AI, OpenAI, LangChain, Vector Databases, RAG,
                            AI Agents, REST APIs.
                        </p>

                    </div>

                    <a href="{{ route('contact') }}" class="btn btn-primary mt-4">
                        Discuss Your AI Initiative
                    </a>

                </div>
            </div>

            <div class="col-lg-6">
                <div class="feature-card h-100" id="software-engineering">

                    <h2 class="h4">Software Engineering</h2>

                    <div class="mt-3">

                        <p><strong>Business Challenge</strong><br>
                            Legacy systems, fragmented applications, and evolving business
                            requirements often slow innovation and increase operational cost.
                        </p>

                        <p><strong>Our Approach</strong><br>
                            We build secure, scalable, and maintainable enterprise software
                            using modern architectures, agile delivery, and engineering best
                            practices.
                        </p>

                        <p><strong>Business Outcomes</strong><br>
                            Faster product delivery, improved user experience, lower maintenance
                            costs, and long-term technology sustainability.
                        </p>

                        <p><strong>Key Technologies</strong><br>
                            Laravel, React, Angular, .NET, Node.js, REST APIs,
                            Microservices.
                        </p>

                    </div>

                    <a href="{{ route('contact') }}" class="btn btn-primary mt-4">
                        Discuss Your Software Project
                    </a>

                </div>
            </div>

            <div class="col-lg-6">
                <div class="feature-card h-100" id="cloud">

                    <h2 class="h4">Cloud Solutions</h2>

                    <div class="mt-3">

                        <p><strong>Business Challenge</strong><br>
                            Traditional infrastructure limits scalability, resilience, and
                            operational agility.
                        </p>

                        <p><strong>Our Approach</strong><br>
                            We help organizations migrate, modernize, and optimize workloads
                            using secure cloud-native architectures and automation.
                        </p>

                        <p><strong>Business Outcomes</strong><br>
                            Improved scalability, enhanced security, better performance,
                            and reduced infrastructure costs.
                        </p>

                        <p><strong>Key Technologies</strong><br>
                            AWS, Microsoft Azure, Google Cloud, Kubernetes,
                            Docker, Terraform.
                        </p>

                    </div>

                    <a href="{{ route('contact') }}" class="btn btn-primary mt-4">
                        Modernize Your Cloud Platform
                    </a>

                </div>
            </div>

            <div class="col-lg-6">
                <div class="feature-card h-100" id="data-engineering">

                    <h2 class="h4">Data Engineering</h2>

                    <div class="mt-3">

                        <p><strong>Business Challenge</strong><br>
                            Disconnected data sources reduce reporting accuracy and limit
                            business insight.
                        </p>

                        <p><strong>Our Approach</strong><br>
                            We build reliable data platforms, integration pipelines,
                            and scalable architectures that support analytics and AI.
                        </p>

                        <p><strong>Business Outcomes</strong><br>
                            Trusted enterprise data, improved governance,
                            and faster business intelligence.
                        </p>

                        <p><strong>Key Technologies</strong><br>
                            PostgreSQL, SQL Server, ETL, APIs,
                            Data Warehousing, Cloud Data Services.
                        </p>

                    </div>

                    <a href="{{ route('contact') }}" class="btn btn-primary mt-4">
                        Build a Modern Data Platform
                    </a>

                </div>
            </div>

            <div class="col-lg-6">
                <div class="feature-card h-100" id="analytics">

                    <h2 class="h4">Business Analytics</h2>

                    <div class="mt-3">

                        <p><strong>Business Challenge</strong><br>
                            Leaders need timely, reliable insights to support operational
                            and strategic decisions.
                        </p>

                        <p><strong>Our Approach</strong><br>
                            We design dashboards, KPI frameworks, and reporting solutions
                            that transform operational data into business intelligence.
                        </p>

                        <p><strong>Business Outcomes</strong><br>
                            Better visibility, faster reporting,
                            and data-driven decision making.
                        </p>

                        <p><strong>Key Technologies</strong><br>
                            Power BI, Tableau, Looker,
                            SQL, Data Visualization.
                        </p>

                    </div>

                    <a href="{{ route('contact') }}" class="btn btn-primary mt-4">
                        Improve Business Visibility
                    </a>

                </div>
            </div>

            <div class="col-lg-6">
                <div class="feature-card h-100" id="devops">

                    <h2 class="h4">DevOps & Automation</h2>

                    <div class="mt-3">

                        <p><strong>Business Challenge</strong><br>
                            Slow deployments and manual release processes delay innovation
                            and increase operational risk.
                        </p>

                        <p><strong>Our Approach</strong><br>
                            We implement CI/CD pipelines, infrastructure automation,
                            monitoring, and modern DevOps practices.
                        </p>

                        <p><strong>Business Outcomes</strong><br>
                            Faster releases, improved reliability,
                            and higher engineering productivity.
                        </p>

                        <p><strong>Key Technologies</strong><br>
                            GitHub Actions, Azure DevOps,
                            Docker, Kubernetes, Terraform.
                        </p>

                    </div>

                    <a href="{{ route('contact') }}" class="btn btn-primary mt-4">
                        Accelerate Software Delivery
                    </a>

                </div>
            </div>

            <div class="col-lg-6">
                <div class="feature-card h-100" id="technology-consulting">

                    <h2 class="h4">Technology Consulting</h2>

                    <div class="mt-3">

                        <p><strong>Business Challenge</strong><br>
                            Organizations require clear technology direction while
                            balancing innovation, risk, and long-term investment.
                        </p>

                        <p><strong>Our Approach</strong><br>
                            We provide strategic consulting, enterprise architecture,
                            modernization roadmaps, and technology leadership.
                        </p>

                        <p><strong>Business Outcomes</strong><br>
                            Better technology decisions,
                            reduced implementation risk,
                            and improved business alignment.
                        </p>

                        <p><strong>Key Technologies</strong><br>
                            Enterprise Architecture,
                            Cloud Strategy,
                            Digital Transformation,
                            Solution Design.
                        </p>

                    </div>

                    <a href="{{ route('contact') }}" class="btn btn-primary mt-4">
                        Schedule a Strategy Session
                    </a>

                </div>
            </div>

            <div class="col-lg-6">
                <div class="feature-card h-100" id="enterprise-applications">

                    <h2 class="h4">Enterprise Applications</h2>

                    <div class="mt-3">

                        <p><strong>Business Challenge</strong><br>
                            Manual and disconnected business processes reduce efficiency,
                            visibility, and organizational agility.
                        </p>

                        <p><strong>Our Approach</strong><br>
                            We develop custom enterprise applications that streamline
                            operations, automate workflows, and integrate business systems.
                        </p>

                        <p><strong>Business Outcomes</strong><br>
                            Increased operational efficiency,
                            stronger governance,
                            and scalable digital operations.
                        </p>

                        <p><strong>Key Technologies</strong><br>
                            Laravel, React, APIs,
                            Authentication,
                            Reporting,
                            Cloud Platforms.
                        </p>

                    </div>

                    <a href="{{ route('contact') }}" class="btn btn-primary mt-4">
                        Build Your Enterprise Solution
                    </a>

                </div>
            </div>
        </div>
    </section>

    <section class="section-block" id="why-oola-systems">

        <div class="text-center mb-5">

            <div class="eyebrow">
                Why Choose Oola Systems
            </div>

            <h2 class="section-title">
                A trusted technology partner from strategy to delivery
            </h2>

            <p class="section-subtitle">
                We combine business understanding, engineering excellence, and modern
                technology to deliver practical, scalable solutions that create long-term value.
            </p>

        </div>

        <div class="row gx-3 gy-4">

            <div class="col-md-6 col-lg-4">

                <div class="feature-card h-100">

                    <h3 class="h5">
                        Business-First Thinking
                    </h3>

                    <p class="mb-0">
                        Every engagement begins with your business objectives,
                        ensuring technology investments deliver measurable outcomes.
                    </p>

                </div>

            </div>

            <div class="col-md-6 col-lg-4">

                <div class="feature-card h-100">

                    <h3 class="h5">
                        Enterprise Engineering
                    </h3>

                    <p class="mb-0">
                        We build secure, scalable, maintainable solutions using
                        proven architectures and modern engineering practices.
                    </p>

                </div>

            </div>

            <div class="col-md-6 col-lg-4">

                <div class="feature-card h-100">

                    <h3 class="h5">
                        AI & Cloud Expertise
                    </h3>

                    <p class="mb-0">
                        We help organizations adopt Artificial Intelligence,
                        cloud platforms, automation, and modern digital capabilities
                        with confidence.
                    </p>

                </div>

            </div>

            <div class="col-md-6 col-lg-4">

                <div class="feature-card h-100">

                    <h3 class="h5">
                        End-to-End Delivery
                    </h3>

                    <p class="mb-0">
                        From strategy and architecture through implementation,
                        deployment, and ongoing support, we stay engaged
                        throughout the technology lifecycle.
                    </p>

                </div>

            </div>

            <div class="col-md-6 col-lg-4">

                <div class="feature-card h-100">

                    <h3 class="h5">
                        Long-Term Partnership
                    </h3>

                    <p class="mb-0">
                        We work as an extension of your team,
                        providing trusted guidance that supports
                        sustainable business growth.
                    </p>

                </div>

            </div>

            <div class="col-md-6 col-lg-4">

                <div class="feature-card h-100">

                    <h3 class="h5">
                        Measurable Results
                    </h3>

                    <p class="mb-0">
                        Every solution is designed to improve operational efficiency,
                        customer experience, business agility,
                        and return on investment.
                    </p>

                </div>

            </div>

        </div>

    </section>

    <section class="section-block">

        <div class="cta-band">

            <div class="eyebrow mb-3">
                Let's Build Together
            </div>

            <h2 class="cta-band__title">
                Ready to transform your business with modern technology?
            </h2>

            <p class="cta-band__subtitle">

                Whether you're planning an AI initiative, modernizing legacy systems,
                migrating to the cloud, or building enterprise applications,
                Oola Systems is ready to help you move from strategy to successful delivery.

            </p>

            <div class="page-actions justify-content-center gap-3 mt-4">

                <a href="{{ route('contact') }}" class="btn btn-primary">

                    Schedule a Consultation

                </a>

                <a href="{{ route('portfolio') }}" class="btn btn-outline-light">

                    View Success Stories

                </a>

            </div>

        </div>

    </section>
@endsection
