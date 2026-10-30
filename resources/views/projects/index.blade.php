@extends('layouts.app')

@section('title', 'OolaLabs | Industry-Inspired Projects & Mentoring')
@section('meta_description',
    'Explore 24 industry-inspired software projects across enterprise systems, AI and data,
    cloud, security, healthcare and education. Build practical engineering skills with OolaLabs.')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/oolalabs-projects.css') }}?v=4">
    <section class="section-block text-center" id="company">
        <div class="eyebrow">Oola Systems · OolaLabs</div>
        <h1 class="page-title">Build real-world skills through industry-inspired projects</h1>
        <p class="page-subtitle">Move beyond sample applications. Learn to plan, design, build, test and explain substantial
            software systems with structured guidance and engineering reviews.</p>
        <div class="d-flex flex-wrap justify-content-center gap-3 mt-4">
            <a class="btn btn-primary d-inline-flex align-items-center justify-content-center" href="#catalogue">
                <i class="bi bi-grid-3x3-gap me-2" aria-hidden="true"></i>
                Explore Projects
            </a>

            <a class="btn btn-outline-light d-inline-flex align-items-center justify-content-center" href="#apply">
                <i class="bi bi-chat-dots me-2" aria-hidden="true"></i>
                Discuss Your Goals
            </a>
        </div>
        <div class="row g-3 justify-content-center mt-4">
            <div class="col-6 col-md-3">
                <div class="feature-card h-100"><i class="bi bi-kanban fs-3 text-primary" aria-hidden="true"></i>
                    <div class="h4 mt-2 mb-1">{{ $allProjects->count() }}</div>
                    <p class="mb-0 small">Proposed projects</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="feature-card h-100"><i class="bi bi-diagram-3 fs-3 text-primary" aria-hidden="true"></i>
                    <div class="h4 mt-2 mb-1">{{ $categories->where('slug', '!=', 'all')->count() }}</div>
                    <p class="mb-0 small">Project domains</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="feature-card h-100"><i class="bi bi-code-square fs-3 text-primary" aria-hidden="true"></i>
                    <div class="h4 mt-2 mb-1">Build</div>
                    <p class="mb-0 small">Hands-on implementation</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="feature-card h-100"><i class="bi bi-person-workspace fs-3 text-primary" aria-hidden="true"></i>
                    <div class="h4 mt-2 mb-1">Mentored</div>
                    <p class="mb-0 small">Review-led learning</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section-block" id="company-story">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <div class="eyebrow">What is OolaLabs?</div>
                <h2 class="section-title">Engineering practice shaped by real business problems</h2>
                <p>OolaLabs is the industry-project and mentoring initiative of Oola Systems. It brings together practical
                    software development, architecture thinking, team collaboration and professional engineering habits.</p>
                <p>Participants work through a defined project scope, break it into milestones, use version control and
                    issue tracking, and learn to justify their technical decisions. The emphasis is on understanding and
                    building—not simply receiving a finished project.</p>
                <p class="mb-0">Projects can be approached as individual capstones or team engagements. Scope, duration,
                    tools and mentoring support are discussed before an engagement begins.</p>
            </div>
            <div class="col-lg-5">
                <div class="feature-card h-100">
                    <h3 class="h5 mb-4"><i class="bi bi-check2-circle text-primary me-2" aria-hidden="true"></i>What makes
                        the experience practical?</h3>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3"><i class="bi bi-check-circle-fill text-primary me-2"
                                aria-hidden="true"></i>Business problem and requirements analysis</li>
                        <li class="mb-3"><i class="bi bi-check-circle-fill text-primary me-2"
                                aria-hidden="true"></i>Architecture, data modelling and API design</li>
                        <li class="mb-3"><i class="bi bi-check-circle-fill text-primary me-2"
                                aria-hidden="true"></i>Git-based teamwork and code reviews</li>
                        <li class="mb-3"><i class="bi bi-check-circle-fill text-primary me-2"
                                aria-hidden="true"></i>Testing, security and deployment practices</li>
                        <li><i class="bi bi-check-circle-fill text-primary me-2" aria-hidden="true"></i>Documentation and
                            project demonstration</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="section-block" id="who-can-join">
        <div class="row align-items-start g-4">
            <div class="col-lg-5">
                <div class="eyebrow">Who can participate?</div>
                <h2 class="section-title">For learners ready to build beyond the basics</h2>
                <p>OolaLabs is suitable for learners who want to practise software engineering with a meaningful project
                    scope. The project and prerequisites are agreed according to each participant's current skills and
                    goals.</p>
            </div>
            <div class="col-lg-7">
                <div class="row g-3">
                    @foreach ([['bi-mortarboard', 'B.Tech / B.E.', 'Computer Science, IT and related branches'], ['bi-journal-code', 'MCA / MSc Computer Science', 'Learners strengthening application and architecture skills'], ['bi-laptop', 'BCA / BSc / Diploma', 'Learners with relevant programming foundations'], ['bi-person-gear', 'Early-career developers', 'Developers looking for structured practice and review']] as $audience)
                        <div class="col-md-6">
                            <div class="feature-card h-100"><i class="bi {{ $audience[0] }} fs-3 text-primary"
                                    aria-hidden="true"></i>
                                <h3 class="h6 mt-3">{{ $audience[1] }}</h3>
                                <p class="mb-0">{{ $audience[2] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="section-block" id="catalogue">
        <div class="text-center mb-4">
            <div class="eyebrow">Project Catalogue</div>
            <h2 class="section-title">Choose a problem worth solving</h2>
            <p class="section-subtitle">Browse the project collection by domain. Select a project to review its proposed
                scope, features and engineering challenges.</p>
        </div>

        <nav class="project-category-tabs mb-4" aria-label="Filter projects by category">
            @foreach ($categories as $category)
                @php $isActive = $selectedCategory === $category['slug']; @endphp
                <a class="project-category-tab {{ $isActive ? 'active' : '' }}"
                    href="{{ route('oolalabs.projects.index', ['category' => $category['slug']]) }}#catalogue"
                    @if ($isActive) aria-current="page" @endif>
                    <i class="bi {{ $category['icon'] }} me-2" aria-hidden="true"></i>{{ $category['label'] }}
                    @if ($category['slug'] !== 'all')
                        <span
                            class="project-tab-count">{{ $allProjects->where('category_slug', $category['slug'])->count() }}</span>
                    @else
                        <span class="project-tab-count">{{ $allProjects->count() }}</span>
                    @endif
                </a>
            @endforeach
        </nav>

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
            <p class="text-secondary mb-0">Showing <strong>{{ $projects->count() }}</strong>
                {{ $projects->count() === 1 ? 'project' : 'projects' }}</p>
            @if ($selectedCategory !== 'all')
                <a class="btn btn-sm btn-outline-light" href="{{ route('oolalabs.projects.index') }}#catalogue"><i
                        class="bi bi-arrow-counterclockwise me-1" aria-hidden="true"></i>Show all projects</a>
            @endif
        </div>

        @if ($projects->isEmpty())
            <div class="feature-card text-center py-5"><i class="bi bi-folder2-open fs-1 text-primary"
                    aria-hidden="true"></i>
                <h3 class="h5 mt-3">No projects in this category yet</h3>
                <p class="mb-0">Choose another category to explore the catalogue.</p>
            </div>
        @else
            <div class="project-card-grid">
                @foreach ($projects as $project)
                    <div class="project-card-grid__item" id="project-{{ $project['slug'] }}">
                        <article class="feature-card project-card h-100 d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start gap-2 mb-3">
                                <span class="project-icon"><i class="bi {{ $project['icon'] ?? 'bi-code-slash' }}"
                                        aria-hidden="true"></i></span>
                                @php
                                    $statusClass = match (strtolower($project['status'] ?? 'proposed project')) {
                                        'proposed project', 'project concept' => 'project-status--proposed',
                                        'in development' => 'project-status--development',
                                        'available for mentoring' => 'project-status--mentoring',
                                        'completed' => 'project-status--completed',
                                        default => 'project-status--default',
                                    };
                                @endphp

                                <span class="project-status {{ $statusClass }}">
                                    {{ $project['status'] ?? 'Proposed project' }}
                                </span>
                            </div>
                            <div class="eyebrow mb-2">{{ $project['category'] }}</div>
                            <h3 class="h4">{{ $project['title'] }}</h3>
                            <p>{{ $project['summary'] }}</p>
                            <div class="mt-auto pt-3"><a class="btn btn-outline-light"
                                    href="{{ $project['url'] }}">Explore Project <i class="bi bi-arrow-up-right ms-1"
                                        aria-hidden="true"></i></a></div>
                        </article>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <section class="section-block" id="project-domains">
        <div class="text-center mb-4">
            <div class="eyebrow">Project Domains</div>
            <h2 class="section-title">Explore by engineering challenge</h2>
            <p class="section-subtitle">Select a domain to see the matching projects in the catalogue.</p>
        </div>
        <div class="row g-3">
            @foreach ($categories->where('slug', '!=', 'all') as $category)
                <div class="col-md-6 col-xl-4">
                    <a class="feature-card h-100 d-block text-decoration-none"
                        href="{{ route('oolalabs.projects.index', ['category' => $category['slug']]) }}#catalogue">
                        <i class="bi {{ $category['icon'] }} fs-2 text-primary" aria-hidden="true"></i>
                        <h3 class="h5 mt-3">{{ $category['label'] }}</h3>
                        <p>{{ $allProjects->where('category_slug', $category['slug'])->count() }} projects in this domain
                        </p>
                        <span class="text-primary">View projects <i class="bi bi-arrow-right ms-1"
                                aria-hidden="true"></i></span>
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    <section class="section-block" id="training-models">
        <div class="text-center mb-4">
            <div class="eyebrow">Ways to Participate</div>
            <h2 class="section-title">Choose a mentoring model</h2>
            <p class="section-subtitle">The engagement is scoped before it starts, so milestones and expectations are
                clear.</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="feature-card h-100"><i class="bi bi-signpost-split fs-2 text-primary" aria-hidden="true"></i>
                    <h3 class="h4 mt-3">Guided Project Development</h3>
                    <p>Follow a milestone-based plan with help on requirements, implementation choices, debugging and
                        regular progress reviews.</p>
                    <ul class="mb-0">
                        <li>Defined scope and milestones</li>
                        <li>Hands-on implementation</li>
                        <li>Periodic feedback and review</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="feature-card h-100"><i class="bi bi-diagram-3 fs-2 text-primary" aria-hidden="true"></i>
                    <h3 class="h4 mt-3">Advanced Project Mentoring</h3>
                    <p>Deepen your understanding of architecture and engineering trade-offs while owning the implementation
                        work.</p>
                    <ul class="mb-0">
                        <li>Architecture and data modelling</li>
                        <li>Code quality, testing and security</li>
                        <li>Deployment and technical discussion</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="feature-card h-100"><i class="bi bi-people fs-2 text-primary" aria-hidden="true"></i>
                    <h3 class="h4 mt-3">Team-Based Industrial Projects</h3>
                    <p>Collaborate in a small team with roles, issues, branches, pull requests and a shared demonstration
                        target.</p>
                    <ul class="mb-0">
                        <li>Team planning and task ownership</li>
                        <li>Git-based collaboration</li>
                        <li>Integration and team review</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="section-block" id="what-you-build">
        <div class="row g-4 align-items-center">
            <div class="col-lg-5">
                <div class="eyebrow">Outcomes</div>
                <h2 class="section-title">A project you can explain, demonstrate and improve</h2>
                <p>Deliverables depend on the chosen scope and are confirmed at the start. The aim is to help you understand
                    both what you built and why it was built that way.</p>
            </div>
            <div class="col-lg-7">
                <div class="feature-card">
                    <div class="row g-4">
                        @foreach ([['bi-card-checklist', 'Requirements & scope', 'User stories, acceptance criteria and milestone plan'], ['bi-bezier2', 'Architecture & design', 'System context, component design, data model and API contracts'], ['bi-code-slash', 'Working implementation', 'Source code organised with meaningful commits and review history'], ['bi-shield-check', 'Quality practices', 'Test cases, validation, security considerations and troubleshooting'], ['bi-journal-text', 'Documentation', 'Setup guide, design notes, known limitations and future improvements'], ['bi-easel2', 'Demonstration', 'A walkthrough explaining design choices, trade-offs and results']] as $deliverable)
                            <div class="col-md-6"><i class="bi {{ $deliverable[0] }} text-primary me-2"
                                    aria-hidden="true"></i>
                                <h3 class="h6 d-inline">{{ $deliverable[1] }}</h3>
                                <p class="mt-2 mb-0">{{ $deliverable[2] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-block" id="mentor-profile">
        <div class="row g-4 align-items-center">
            <div class="col-lg-8">
                <div class="eyebrow">Mentorship approach</div>
                <h2 class="section-title">Learn the habits behind dependable software</h2>
                <p>OolaLabs is guided by enterprise software and technology leadership experience across software
                    engineering, architecture, cloud platforms, data and AI-enabled solutions. Sessions focus on practical
                    reasoning, incremental delivery, maintainability and explaining technical decisions clearly.</p>
                <p class="mb-0">Mentoring is intended to support learning and independent implementation. Participants
                    are expected to understand, test and present their own work.</p>
            </div>
            <div class="col-lg-4">
                <div class="feature-card h-100">
                    <h3 class="h5"><i class="bi bi-compass text-primary me-2" aria-hidden="true"></i>Engineering
                        principles</h3>
                    <ul class="mb-0">
                        <li>Start with the business problem</li>
                        <li>Prefer clear, maintainable designs</li>
                        <li>Build and test incrementally</li>
                        <li>Protect data and credentials</li>
                        <li>Document decisions and limitations</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="section-block" id="how-it-works">
        <div class="text-center mb-4">
            <div class="eyebrow">A clear process</div>
            <h2 class="section-title">How it works</h2>
        </div>
        <div class="row g-3">
            @foreach ([['01', 'Choose', 'Select a project or share your idea and goals.', 'bi-search'], ['02', 'Discuss scope', 'Review prerequisites, timeline, deliverables and support needs.', 'bi-chat-square-text'], ['03', 'Plan', 'Agree milestones, tools, roles and communication cadence.', 'bi-calendar2-check'], ['04', 'Build', 'Implement in increments, document progress and raise questions.', 'bi-code-square'], ['05', 'Review', 'Use feedback, testing and code reviews to improve the solution.', 'bi-clipboard2-check'], ['06', 'Demonstrate', 'Present the working outcome and explain key technical choices.', 'bi-easel']] as $step)
                <div class="col-md-6 col-xl-4">
                    <div class="feature-card h-100">
                        <div class="d-flex align-items-center gap-3 mb-3"><i
                                class="bi {{ $step[3] }} fs-3 text-primary" aria-hidden="true"></i><span
                                class="eyebrow mb-0">{{ $step[0] }}</span></div>
                        <h3 class="h5">{{ $step[1] }}</h3>
                        <p class="mb-0">{{ $step[2] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="section-block" id="duration-fees">
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="feature-card h-100"><i class="bi bi-calendar-week fs-2 text-primary" aria-hidden="true"></i>
                    <h3 class="h4 mt-3">Duration and scope</h3>
                    <p class="mb-0">Duration depends on project complexity, existing skills, team size and mentoring
                        frequency. A proposed timeline and milestones will be discussed before enrollment; no single
                        duration is assumed for every project.</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="feature-card h-100"><i class="bi bi-receipt fs-2 text-primary" aria-hidden="true"></i>
                    <h3 class="h4 mt-3">Fees and engagement</h3>
                    <p class="mb-0">Fees, session frequency and deliverables are discussed after understanding the scope.
                        Contact Oola Systems for a proposal suited to an individual learner, a project team or an
                        institutional engagement.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section-block" id="faqs">
        <div class="text-center mb-4">
            <div class="eyebrow">FAQs</div>
            <h2 class="section-title">Questions before you begin</h2>
        </div>
        <div class="row g-3">
            @foreach ([
            ['Do I need to know every technology already?', 'No. Prerequisites depend on the selected project. We will discuss the expected foundations and identify any gaps before confirming scope.'],
            ['Will OolaLabs build my academic submission for me?', 'No. The purpose is guided learning and engineering practice. Participants are expected to implement, understand and present their own work.'],
            ['Can a group work on one project?', 'Yes. Team-based engagements can define roles, tasks, source-control practices and shared milestones.'],
            ['Will every project become a commercial product?', 'No. Projects are learning and engineering exercises unless a separate, explicit product-development agreement is made.'],
            ['Can we use real customer or patient data?', 'Use synthetic or properly authorised data for practice. Production credentials and sensitive records should not be shared with participants.'],
            ['Can a college request a customised programme?', 'Yes. Institutional workshops and team engagements can be discussed based on the learning objectives, timeline and group size.'],
        ] as $faq)
                <div class="col-md-6">
                    <div class="feature-card h-100">
                        <h3 class="h6"><i class="bi bi-patch-question text-primary me-2"
                                aria-hidden="true"></i>{{ $faq[0] }}</h3>
                        <p class="mb-0">{{ $faq[1] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="section-block" id="apply">
        <div class="cta-band">
            <h2 class="cta-band__title">Ready to build something meaningful?</h2>
            <p class="cta-band__subtitle">Tell us about your background, interests and goals. We can discuss a suitable
                project, mentoring model, expected outcomes and next steps.</p><a href="{{ route('contact') }}"
                class="btn btn-primary">Discuss a Project <i class="bi bi-arrow-right ms-2" aria-hidden="true"></i></a>
        </div>
    </section>
@endsection
