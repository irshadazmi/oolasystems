{{-- Footer --}}
<footer class="footer" aria-label="Footer Navigation">
    <div class="container-fluid footer-main py-5 py-lg-6">
        <div class="row g-4 g-lg-4 align-items-start">
            <div class="col-12 col-sm-6 col-lg-2">
                <h6 class="footer-heading">Home</h6>

                <ul class="list-unstyled mt-3" role="list">

                    <li class="mb-2">
                        <a href="{{ route('home') }}">
                            Overview
                        </a>
                    </li>

                    <li class="mb-2">
                        <a href="{{ route('home') }}#services-preview">
                            Services
                        </a>
                    </li>

                    <li class="mb-2">
                        <a href="{{ route('home') }}#industries-preview">
                            Industries
                        </a>
                    </li>

                    <li class="mb-2">
                        <a href="{{ route('home') }}#portfolio-preview">
                            Success Stories
                        </a>
                    </li>

                    <li class="mb-2">
                        <a href="{{ route('home') }}#why-choose">
                            Why Oola Systems
                        </a>
                    </li>

                    <li class="mb-2">
                        <a href="{{ route('home') }}#resources-preview">
                            Learning Center
                        </a>
                    </li>

                </ul>
            </div>

            <div class="col-12 col-sm-6 col-lg-2">
                <h6 class="footer-heading" id="footer-heading">Services</h6>
                <ul class="list-unstyled mt-3" role="list">
                    <li class="mb-2"><a href="{{ route('services') }}#artificial-intelligence">Artificial
                            Intelligence</a></li>
                    <li class="mb-2"><a href="{{ route('services') }}#software-engineering">Software Engineering</a>
                    </li>
                    <li class="mb-2"><a href="{{ route('services') }}#cloud">Cloud</a></li>
                    <li class="mb-2"><a href="{{ route('services') }}#data-engineering">Data Engineering</a></li>
                    <li class="mb-2"><a href="{{ route('services') }}#analytics">Analytics</a></li>
                    <li class="mb-2"><a href="{{ route('services') }}#devops">DevOps</a></li>
                    <li class="mb-2"><a
                            href="{{ route('services') }}#technology-consulting
                        ">Technology
                            Consulting</a></li>
                    <li class="mb-2"><a href="{{ route('services') }}#enterprise-applications">Enterprise
                            Applications</a></li>
                    <li class="mb-2"><a href="{{ route('services') }}#why-oola-systems">Why Choose Oola Systems</a></li>
                </ul>
            </div>

            <div class="col-12 col-sm-6 col-lg-2">
                <h6 class="footer-heading">Industries</h6>
                <ul class="list-unstyled mt-3" role="list">
                    <li class="mb-2"><a href="{{ route('industries') }}#healthcare">Healthcare</a></li>
                    <li class="mb-2"><a href="{{ route('industries') }}#banking">Banking &amp; Financial Services</a>
                    </li>
                    <li class="mb-2"><a href="{{ route('industries') }}#insurance">Insurance</a></li>
                    <li class="mb-2"><a href="{{ route('industries') }}#retail">Retail &amp; E-Commerce</a></li>
                    <li class="mb-2"><a href="{{ route('industries') }}#manufacturing">Manufacturing</a></li>
                    <li class="mb-2"><a href="{{ route('industries') }}#education">Education</a></li>
                    <li class="mb-2"><a href="{{ route('industries') }}#logistics">Logistics</a></li>
                    <li class="mb-2"><a href="{{ route('industries') }}#human-resources">Human Resources</a></li>
                </ul>
            </div>

            <div class="col-12 col-sm-6 col-lg-2">
                <h6 class="footer-heading">Success Stories</h6>
                <ul class="list-unstyled mt-3" role="list">
                    <li class="mb-2"><a href="{{ route('portfolio') }}#dental">Digital Dental Solutions</a></li>
                    <li class="mb-2"><a href="{{ route('portfolio') }}#crm">CRM Platform</a>
                    </li>
                    <li class="mb-2"><a href="{{ route('portfolio') }}#payroll">Payroll & HR</a></li>
                    <li class="mb-2"><a href="{{ route('portfolio') }}#ai-applications">AI Based Apps</a></li>
                    <li class="mb-2"><a href="{{ route('portfolio') }}#saas">Custom SaaS</a></li>
                    <li class="mb-2"><a href="{{ route('portfolio') }}#ai-integration">AI Integration</a></li>
                </ul>
            </div>

            <div class="col-12 col-sm-6 col-lg-2">
                <h6 class="footer-heading">Company</h6>
                <ul class="list-unstyled mt-3" role="list">
                    <li class="mb-2"><a href="{{ route('about') }}">About</a></li>
                    <li class="mb-2"><a href="{{ route('about') }}#mission">Mission</a></li>
                    <li class="mb-2"><a href="{{ route('about') }}#vision">Vision</a></li>
                    <li class="mb-2"><a href="{{ route('about') }}#values">Values</a></li>
                    <li class="mb-2"><a href="{{ route('about') }}#our-culture">Our Culture</a></li>
                    <li class="mb-2"><a href="{{ route('about') }}#leadership-team">Leadership Team</a></li>
                </ul>
            </div>

            <div class="col-12 col-sm-6 col-lg-2">

                <h6 class="footer-heading">Get in Touch</h6>

                <ul class="list-unstyled mt-3" role="list">

                    <li class="mb-3">
                        <i class="bi bi-geo-alt-fill me-2 text-primary"></i>
                        Pune, Maharashtra
                    </li>

                    <li class="mb-3">
                        <i class="bi bi-envelope-fill me-2 text-primary"></i>
                        <a href="mailto:info@oolasystems.com">
                            info@oolasystems.com
                        </a>
                    </li>

                    <li class="mb-3">
                        <i class="bi bi-telephone-fill me-2 text-primary"></i>
                        <a href="tel:+918668875354">+91 86688 75354</a>
                    </li>

                    <li class="mb-3">
                        <i class="bi bi-globe me-2 text-primary"></i>
                        <a href="{{ route('contact') }}">
                            Contact Us
                        </a>
                    </li>

                </ul>

                <div class="d-flex gap-3 mt-4">

                    <a href="https://www.linkedin.com/company/oolasystems">
                        <i class="bi bi-linkedin"></i>
                    </a>

                    <a href="https://github.com/oolasystems">
                        <i class="bi bi-github"></i>
                    </a>

                    <a href="https://www.youtube.com/@oolasystems">
                        <i class="bi bi-youtube"></i>
                    </a>

                    <a href="https://www.instagram.com/oolasystems">
                        <i class="bi bi-instagram"></i>
                    </a>

                </div>

            </div>
        </div>
    </div>

    <div class="footer-divider my-4"></div>

    <div class="footer-metrics">
        <div class="container-fluid">
            <div class="row g-3 g-md-4 g-lg-5 justify-content-center text-center">
                <div class="col-12 col-md-4">
                    <div class="footer-metric-card">
                        <i class="bi bi-people-fill footer-metric-icon"></i>
                        <div class="footer-metric-card__value">{{ number_format($totalVisitors ?? 0) }}</div>
                        <div class="footer-metric-card__label">Total Visitors</div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="footer-metric-card">
                        <i class="bi bi-people-fill footer-metric-icon"></i>
                        <div class="footer-metric-card__value">{{ number_format($uniqueVisitors ?? 0) }}</div>
                        <div class="footer-metric-card__label">Unique Visitors</div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="footer-metric-card">
                        <i class="bi bi-people-fill footer-metric-icon"></i>
                        <div class="footer-metric-card__value">{{ number_format($todayVisitors ?? 0) }}</div>
                        <div class="footer-metric-card__label">Today&apos;s Visitors</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-divider my-4"></div>

    <div class="footer-bottom">
        <div class="container-fluid py-4">
            <div
                class="d-flex flex-column flex-lg-row justify-content-between align-items-center gap-3 text-center text-lg-start">
                <p class="mb-0 small text-secondary">© {{ date('Y') }} Oola Systems Pvt. Ltd. All Rights Reserved.
                </p>
                <div class="d-flex flex-wrap justify-content-center gap-4 small">

                    <a href="{{ route('privacy') }}">Privacy Policy</a>

                    <a href="{{ route('terms') }}">Terms of Use</a>

                    <a href="{{ route('sitemap') }}">Sitemap</a>

                    <a href="{{ route('careers') }}">Careers</a>

                </div>
            </div>
        </div>
    </div>
</footer>
