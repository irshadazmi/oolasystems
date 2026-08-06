<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    /* ----------------------------------------------------------
     * CAPTCHA
     * ---------------------------------------------------------- */

    function refreshCaptcha(type) {

        fetch(`/refresh-captcha/${type}`)

            .then(response => {

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}`);
                }

                return response.json();

            })

            .then(data => {

                const element = document.getElementById(`captcha-${type}-text`);

                if (element) {
                    element.textContent = data.question;
                }

            })

            .catch(error => {

                console.error("Captcha Error:", error);

                const element = document.getElementById(`captcha-${type}-text`);

                if (element) {
                    element.textContent = "Unable to load";
                }

            });

    }


    /* ----------------------------------------------------------
     * COMMON SITE FUNCTIONS
     * ---------------------------------------------------------- */

    (function() {

        const progressBar = document.getElementById('topProgressBar');
        const nav = document.querySelector('[data-nav]');

        /* -----------------------------
         * Scroll Progress
         * ----------------------------- */

        function onScroll() {

            const scrollTop = window.scrollY;
            const docHeight = document.documentElement.scrollHeight - window.innerHeight;
            const scrollPercent = docHeight > 0 ?
                (scrollTop / docHeight) * 100 :
                0;

            if (progressBar) {
                progressBar.style.width = scrollPercent + '%';
            }

            if (nav) {
                nav.classList.toggle('is-scrolled', scrollTop > 24);
            }

        }

        window.addEventListener('scroll', onScroll, {
            passive: true
        });

        onScroll();

        /* -----------------------------
         * Mobile Menu
         * ----------------------------- */

        window.openMenu = function() {

            const menu = document.getElementById('mobileMenu');

            if (menu) {
                menu.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

        };

        window.closeMenu = function() {

            const menu = document.getElementById('mobileMenu');

            if (menu) {
                menu.classList.remove('active');
                document.body.style.overflow = '';
            }

        };

        /* -----------------------------
         * Scroll Reveal Animation
         * ----------------------------- */

        if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {

            const revealEls = document.querySelectorAll('.reveal');

            if (revealEls.length && 'IntersectionObserver' in window) {

                const revealObserver = new IntersectionObserver(function(entries) {

                    entries.forEach(function(entry) {

                        if (entry.isIntersecting) {

                            entry.target.classList.add('is-visible');

                            revealObserver.unobserve(entry.target);

                        }

                    });

                }, {
                    threshold: 0.12,
                    rootMargin: '0px 0px -40px 0px'
                });

                revealEls.forEach(function(el) {

                    revealObserver.observe(el);

                });

            } else {

                revealEls.forEach(function(el) {

                    el.classList.add('is-visible');

                });

            }

        } else {

            document.querySelectorAll('.reveal').forEach(function(el) {

                el.classList.add('is-visible');

            });

        }

        /* -----------------------------
         * Initialize Captchas
         * ----------------------------- */

        document
            .querySelectorAll("[id^='captcha-'][id$='-text']")
            .forEach(function(element) {

                const type = element.id
                    .replace("captcha-", "")
                    .replace("-text", "");

                refreshCaptcha(type);

            });

    })();
</script>

@stack('scripts')
