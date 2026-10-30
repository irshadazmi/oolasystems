@extends('layouts.app')

@section('title', $project['title'] . ' | OolaLabs')
@section('meta_description', $project['summary'])

@section('content')
    <style>
        /* Keep every section on the same page grid as About and Home. */
        .project-detail__hero,
        .project-detail__content-section,
        .project-detail__planning-section,
        .project-detail__cta-section,
        .project-detail__related-section {
            width: 90%;
            max-width: 1800px;
            margin-inline: auto;
        }

        .project-detail__hero {
            text-align: center;
        }

        .project-detail__hero .page-subtitle {
            margin-inline: auto;
        }

        .project-detail__status {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid currentColor;
            border-radius: 999px;
            padding: .45rem .9rem;
            font-size: .875rem;
            line-height: 1.2;
            white-space: nowrap;
        }

        /* Full-width documentation panel, using the site's existing card treatment. */
        .project-detail__document {
            width: 100%;
            min-width: 0;
            padding: clamp(1.25rem, 2.5vw, 2.5rem);
            line-height: 1.8;
            overflow-wrap: anywhere;
        }

        .project-detail__document.markdown-body > h1:first-child {
            display: none;
        }

        .project-detail__document.markdown-body h2 {
            margin-top: 2.25rem;
            margin-bottom: .8rem;
            padding-bottom: .55rem;
            border-bottom: 1px solid var(--color-border, rgba(255,255,255,.12));
            font-size: clamp(1.35rem, 2.2vw, 1.8rem);
            line-height: 1.25;
            letter-spacing: -.02em;
        }

        .project-detail__document.markdown-body h2:first-of-type {
            margin-top: 0;
        }

        .project-detail__document.markdown-body h3 {
            margin-top: 1.5rem;
            margin-bottom: .6rem;
            font-size: clamp(1.1rem, 1.7vw, 1.35rem);
            line-height: 1.35;
        }

        .project-detail__document.markdown-body p,
        .project-detail__document.markdown-body ul,
        .project-detail__document.markdown-body ol,
        .project-detail__document.markdown-body table,
        .project-detail__document.markdown-body blockquote {
            margin-bottom: 1rem;
        }

        .project-detail__document.markdown-body ul,
        .project-detail__document.markdown-body ol {
            padding-left: 1.5rem;
        }

        .project-detail__document.markdown-body li + li {
            margin-top: .35rem;
        }

        .project-detail__document.markdown-body > :last-child {
            margin-bottom: 0;
        }

        .project-detail__document.markdown-body table {
            display: block;
            width: 100%;
            overflow-x: auto;
            border-collapse: collapse;
        }

        .project-detail__document.markdown-body th,
        .project-detail__document.markdown-body td {
            padding: .7rem .85rem;
            border: 1px solid var(--color-border, rgba(255,255,255,.12));
            text-align: left;
        }

        .project-detail__document.markdown-body th {
            background: rgba(255,255,255,.04);
        }

        .project-detail__section-heading {
            max-width: 760px;
            margin: 0 auto 2rem;
            text-align: center;
        }

        .project-detail__planning,
        .project-detail__related {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1.25rem;
            align-items: stretch;
        }

        .project-detail__planning-card,
        .project-detail__related-card {
            height: 100%;
            min-width: 0;
        }

        .project-detail__card-heading {
            display: flex;
            align-items: center;
            gap: .7rem;
            margin-bottom: .9rem;
        }

        .project-detail__card-heading i {
            color: var(--bs-primary, #35cdb7);
            font-size: 1.2rem;
            flex: 0 0 auto;
        }

        .project-detail__card-heading h3 {
            margin: 0;
            font-size: 1.08rem;
            line-height: 1.35;
        }

        .project-detail__list {
            margin: 0;
            padding-left: 1.2rem;
        }

        .project-detail__list li + li {
            margin-top: .45rem;
        }

        .project-detail__related-card a {
            text-decoration: none;
        }

        .project-detail__related-card a:hover {
            text-decoration: underline;
        }

        .project-detail__related-card .project-detail__related-link {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            margin-top: auto;
            padding-top: .75rem;
            font-weight: 600;
        }

        @media (max-width: 991.98px) {
            .project-detail__planning,
            .project-detail__related {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 767.98px) {
            .project-detail__hero,
            .project-detail__content-section,
            .project-detail__planning-section,
            .project-detail__cta-section,
            .project-detail__related-section {
                width: 92%;
            }

            .project-detail__document {
                padding: 1.25rem;
            }
        }

        @media (max-width: 575.98px) {
            .project-detail__planning,
            .project-detail__related {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <section class="section-block project-detail__hero" id="project-overview">
        <div class="eyebrow mb-3">
            <a href="{{ route('oolalabs.projects.index') }}">OolaLabs</a>
            <span aria-hidden="true">·</span>
            {{ $project['category'] }}
        </div>

        <h1 class="page-title">{{ $project['title'] }}</h1>
        <p class="page-subtitle">{{ $project['summary'] }}</p>

        @php
            $status = strtolower($project['status'] ?? 'proposed project');
            $statusBadgeClass = match ($status) {
                'proposed project', 'project concept' => 'text-warning',
                'in development' => 'text-info',
                'available for mentoring' => 'text-success',
                'completed' => 'text-secondary',
                default => 'text-light',
            };
        @endphp

        <div class="d-flex flex-wrap justify-content-center align-items-center gap-2 mt-4">
            <span class="badge rounded-pill border border-info text-info bg-transparent px-3 py-2">{{ $project['category'] }}</span>
            <span class="project-detail__status {{ $statusBadgeClass }}">{{ $project['status'] ?? 'Proposed project' }}</span>
        </div>
    </section>

    <section class="section-block project-detail__content-section" id="project-details">
        <div class="project-detail__section-heading">
            <p class="eyebrow">PROJECT DETAILS</p>
            <h2 class="section-title">Explore the project brief</h2>
            <p class="section-subtitle">Business context, proposed capabilities, architecture and delivery considerations for this project.</p>
        </div>

        <article class="feature-card markdown-body project-detail__document">
            {!! $project['content'] !!}
        </article>
    </section>

    @php($sidebar = $project['sidebar'] ?? [])
    @if (!empty($sidebar['technology']) || !empty($sidebar['roadmap']) || !empty($sidebar['deliverables']))
        <section class="section-block project-detail__planning-section" id="project-planning">
            <div class="project-detail__section-heading">
                <p class="eyebrow">PROJECT PLANNING</p>
                <h2 class="section-title">From brief to implementation</h2>
                <p class="section-subtitle">A concise planning snapshot to help structure the build, review progress and demonstrate the result.</p>
            </div>

            <div class="project-detail__planning">
                @if (!empty($sidebar['technology']))
                    <article class="feature-card project-detail__planning-card">
                        <div class="project-detail__card-heading">
                            <i class="bi bi-code-slash" aria-hidden="true"></i>
                            <h3>Technology and skills</h3>
                        </div>
                        <ul class="project-detail__list">
                            @foreach (array_slice($sidebar['technology'], 0, 4) as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </article>
                @endif

                @if (!empty($sidebar['roadmap']))
                    <article class="feature-card project-detail__planning-card">
                        <div class="project-detail__card-heading">
                            <i class="bi bi-signpost-split" aria-hidden="true"></i>
                            <h3>Suggested roadmap</h3>
                        </div>
                        <ol class="project-detail__list">
                            @foreach (array_slice($sidebar['roadmap'], 0, 5) as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ol>
                    </article>
                @endif

                @if (!empty($sidebar['deliverables']))
                    <article class="feature-card project-detail__planning-card">
                        <div class="project-detail__card-heading">
                            <i class="bi bi-box-seam" aria-hidden="true"></i>
                            <h3>Expected deliverables</h3>
                        </div>
                        <ul class="project-detail__list">
                            @foreach (array_slice($sidebar['deliverables'], 0, 5) as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </article>
                @endif
            </div>
        </section>
    @endif

    <section class="section-block project-detail__cta-section" id="discuss-project">
        <div class="cta-band">
            <p class="eyebrow">NEXT STEP</p>
            <h2 class="cta-band__title">Interested in this project?</h2>
            <p class="cta-band__subtitle">Discuss the scope, prerequisites, mentoring options, milestones and expected outcomes before starting.</p>

            <div class="d-flex flex-wrap justify-content-center gap-3 mt-4">
                <a class="btn btn-primary d-inline-flex align-items-center justify-content-center" href="{{ route('oolalabs.projects.index') }}#catalogue">
                    <i class="bi bi-grid-3x3-gap me-2" aria-hidden="true"></i>
                    Explore Projects
                </a>

                <a class="btn btn-outline-light d-inline-flex align-items-center justify-content-center" href="{{ route('contact') }}">
                    <i class="bi bi-chat-dots me-2" aria-hidden="true"></i>
                    Discuss This Project
                </a>
            </div>
        </div>
    </section>

    @if ($relatedProjects->isNotEmpty())
        <section class="section-block project-detail__related-section" id="related-projects">
            <div class="project-detail__section-heading">
                <p class="eyebrow">KEEP EXPLORING</p>
                <h2 class="section-title">Related projects</h2>
                <p class="section-subtitle">Explore other projects with overlapping business workflows or engineering skills.</p>
            </div>

            <div class="project-detail__related">
                @foreach ($relatedProjects as $related)
                    <article class="feature-card project-detail__related-card">
                        <p class="eyebrow mb-2">{{ $related['category'] }}</p>
                        <h3 class="h5"><a href="{{ $related['url'] }}">{{ $related['title'] }}</a></h3>
                        <p>{{ $related['summary'] }}</p>
                        <a href="{{ $related['url'] }}" class="link-primary project-detail__related-link">Explore project <span aria-hidden="true">↗</span></a>
                    </article>
                @endforeach
            </div>
        </section>
    @endif
@endsection
