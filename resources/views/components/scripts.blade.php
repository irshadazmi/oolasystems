<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    /* ==========================================================
     * CAPTCHA
     * ========================================================== */

    function refreshCaptcha(type) {

        fetch(`/refresh-captcha/${type}`)
            .then(response => {

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}`);
                }

                return response.json();

            })
            .then(data => {

                const element =
                    document.getElementById(`captcha-${type}-text`);

                if (element) {
                    element.textContent = data.question;
                }

            })
            .catch(error => {

                console.error("Captcha Error:", error);

                const element =
                    document.getElementById(`captcha-${type}-text`);

                if (element) {
                    element.textContent = "Unable to load";
                }

            });

    }


    /* ==========================================================
     * COMMON SITE FUNCTIONS
     * ========================================================== */

    (function() {

        const progressBar =
            document.getElementById('topProgressBar');

        const nav =
            document.querySelector('[data-nav]');


        /* ------------------------------------------------------
         * Scroll Progress
         * ------------------------------------------------------ */

        function onScroll() {

            const scrollTop = window.scrollY;

            const docHeight =
                document.documentElement.scrollHeight -
                window.innerHeight;

            const scrollPercent =
                docHeight > 0 ?
                (scrollTop / docHeight) * 100 :
                0;

            if (progressBar) {
                progressBar.style.width =
                    scrollPercent + '%';
            }

            if (nav) {
                nav.classList.toggle(
                    'is-scrolled',
                    scrollTop > 24
                );
            }

        }


        window.addEventListener(
            'scroll',
            onScroll, {
                passive: true
            }
        );

        onScroll();


        /* ------------------------------------------------------
         * Mobile Menu
         * ------------------------------------------------------ */

        window.openMenu = function() {

            const menu =
                document.getElementById('mobileMenu');

            if (menu) {

                menu.classList.add('active');

                document.body.style.overflow = 'hidden';

            }

        };


        window.closeMenu = function() {

            const menu =
                document.getElementById('mobileMenu');

            if (menu) {

                menu.classList.remove('active');

                document.body.style.overflow = '';

            }

        };


        /* ------------------------------------------------------
         * Scroll Reveal Animation
         * ------------------------------------------------------ */

        if (
            !window.matchMedia(
                '(prefers-reduced-motion: reduce)'
            ).matches
        ) {

            const revealEls =
                document.querySelectorAll('.reveal');


            if (
                revealEls.length &&
                'IntersectionObserver' in window
            ) {

                const revealObserver =
                    new IntersectionObserver(
                        function(entries) {

                            entries.forEach(function(entry) {

                                if (entry.isIntersecting) {

                                    entry.target.classList.add(
                                        'is-visible'
                                    );

                                    revealObserver.unobserve(
                                        entry.target
                                    );

                                }

                            });

                        }, {
                            threshold: 0.12,
                            rootMargin: '0px 0px -40px 0px'
                        }
                    );


                revealEls.forEach(function(el) {

                    revealObserver.observe(el);

                });

            } else {

                revealEls.forEach(function(el) {

                    el.classList.add('is-visible');

                });

            }

        } else {

            document
                .querySelectorAll('.reveal')
                .forEach(function(el) {

                    el.classList.add('is-visible');

                });

        }


        /* ------------------------------------------------------
         * Initialize Captchas
         * ------------------------------------------------------ */

        document
            .querySelectorAll(
                "[id^='captcha-'][id$='-text']"
            )
            .forEach(function(element) {

                const type =
                    element.id
                    .replace("captcha-", "")
                    .replace("-text", "");

                refreshCaptcha(type);

            });

    })();


    /* ----------------------------------------------------------
     * AI CHATBOT
     * ---------------------------------------------------------- */

    (function() {

        const chatbot =
            document.getElementById('ai-chatbot');

        const toggle =
            document.getElementById('ai-chatbot-toggle');

        const panel =
            document.getElementById('ai-chatbot-panel');

        const close =
            document.getElementById('ai-chatbot-close');

        const input =
            document.getElementById('ai-chatbot-input');

        const send =
            document.getElementById('ai-chatbot-send');

        const messages =
            document.getElementById('ai-chatbot-messages');


        if (
            !chatbot ||
            !toggle ||
            !panel ||
            !close ||
            !input ||
            !send ||
            !messages
        ) {
            return;
        }


        /* ----------------------------------------------------------
         * OPEN
         * ---------------------------------------------------------- */

        function openChatbot() {

            chatbot.classList.add('is-open');

            toggle.setAttribute(
                'aria-expanded',
                'true'
            );

            panel.setAttribute(
                'aria-hidden',
                'false'
            );

            input.focus();
        }


        /* ----------------------------------------------------------
         * CLOSE
         * ---------------------------------------------------------- */

        function closeChatbot() {

            chatbot.classList.remove('is-open');

            toggle.setAttribute(
                'aria-expanded',
                'false'
            );

            panel.setAttribute(
                'aria-hidden',
                'true'
            );
        }


        /* ----------------------------------------------------------
         * TOGGLE
         * ---------------------------------------------------------- */

        toggle.addEventListener(
            'click',
            function() {

                if (
                    chatbot.classList.contains(
                        'is-open'
                    )
                ) {
                    closeChatbot();
                } else {
                    openChatbot();
                }

            }
        );


        /* ----------------------------------------------------------
         * CLOSE BUTTON
         * ---------------------------------------------------------- */

        close.addEventListener(
            'click',
            closeChatbot
        );


        /* ----------------------------------------------------------
         * ADD USER MESSAGE
         * ---------------------------------------------------------- */

        function addUserMessage(message) {

            const wrapper =
                document.createElement('div');

            wrapper.className =
                'ai-chatbot-message ai-chatbot-message-user';

            const content =
                document.createElement('div');

            content.className =
                'ai-chatbot-message-content';

            content.textContent = message;

            wrapper.appendChild(content);

            messages.appendChild(wrapper);

            scrollMessagesToBottom();
        }


        /* ----------------------------------------------------------
         * ADD BOT MESSAGE
         * ---------------------------------------------------------- */

        function addBotMessage(message) {

            const wrapper =
                document.createElement('div');

            wrapper.className =
                'ai-chatbot-message ai-chatbot-message-bot';

            const content =
                document.createElement('div');

            content.className =
                'ai-chatbot-message-content';

            content.textContent = message;

            wrapper.appendChild(content);

            messages.appendChild(wrapper);

            scrollMessagesToBottom();
        }


        /* ----------------------------------------------------------
         * SCROLL
         * ---------------------------------------------------------- */

        function scrollMessagesToBottom() {

            messages.scrollTop =
                messages.scrollHeight;
        }


        /* ----------------------------------------------------------
         * TYPING INDICATOR
         * ---------------------------------------------------------- */

        function showTyping() {

            if (
                document.getElementById(
                    'ai-chatbot-typing'
                )
            ) {
                return;
            }

            const wrapper =
                document.createElement('div');

            wrapper.id =
                'ai-chatbot-typing';

            wrapper.className =
                'ai-chatbot-message ai-chatbot-message-bot';

            wrapper.innerHTML = `
            <div class="ai-chatbot-message-content">
                <span class="ai-chatbot-typing-dot">●</span>
                <span class="ai-chatbot-typing-dot">●</span>
                <span class="ai-chatbot-typing-dot">●</span>
            </div>
        `;

            messages.appendChild(wrapper);

            scrollMessagesToBottom();
        }


        function hideTyping() {

            const typing =
                document.getElementById(
                    'ai-chatbot-typing'
                );

            typing?.remove();
        }


        /* ----------------------------------------------------------
         * SHOW INQUIRY FORM
         * ---------------------------------------------------------- */

        function showInquiryForm() {

            /*
             * Phase 2F only signals readiness.
             *
             * Phase 2G will connect this to:
             *
             * components.forms.inquiry-form
             */

            const event =
                new CustomEvent(
                    'oola:chatbot-inquiry-ready'
                );

            document.dispatchEvent(event);
        }


        /* ----------------------------------------------------------
         * SEND MESSAGE
         * ---------------------------------------------------------- */

        async function sendMessage() {

            const message =
                input.value.trim();

            if (!message) {
                return;
            }


            /*
             * Prevent duplicate requests.
             */
            if (send.disabled) {
                return;
            }


            addUserMessage(message);

            input.value = '';

            send.disabled = true;

            input.disabled = true;

            showTyping();


            try {

                const response =
                    await fetch(
                        '{{ route('chatbot.message') }}', {
                            method: 'POST',

                            headers: {
                                'Content-Type': 'application/json',

                                'Accept': 'application/json',

                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },

                            body: JSON.stringify({
                                message: message
                            })
                        }
                    );


                const data =
                    await response.json();


                hideTyping();


                if (!response.ok || !data.success) {

                    addBotMessage(
                        data.message ||
                        'I’m sorry, something went wrong. Please try again.'
                    );

                    return;
                }


                /*
                 * AI-generated response.
                 */
                addBotMessage(
                    data.message
                );


                /*
                 * Inquiry readiness.
                 */
                if (
                    data.ready_for_inquiry === true
                ) {
                    showInquiryForm();
                }

            } catch (error) {

                console.error(
                    'Chatbot Error:',
                    error
                );

                hideTyping();

                addBotMessage(
                    'I’m sorry, I’m having trouble connecting right now. Please try again.'
                );

            } finally {

                send.disabled = false;

                input.disabled = false;

                input.focus();
            }
        }


        /* ----------------------------------------------------------
         * SEND BUTTON
         * ---------------------------------------------------------- */

        send.addEventListener(
            'click',
            sendMessage
        );


        /* ----------------------------------------------------------
         * ENTER KEY
         * ---------------------------------------------------------- */

        input.addEventListener(
            'keydown',
            function(event) {

                if (event.key === 'Enter') {

                    event.preventDefault();

                    sendMessage();
                }
            }
        );


        /* ----------------------------------------------------------
         * ESCAPE
         * ---------------------------------------------------------- */

        document.addEventListener(
            'keydown',
            function(event) {

                if (
                    event.key === 'Escape' &&
                    chatbot.classList.contains(
                        'is-open'
                    )
                ) {
                    closeChatbot();
                }
            }
        );


        /* ----------------------------------------------------------
         * CHATBOT INQUIRY EVENT
         * ---------------------------------------------------------- */

        document.addEventListener(
            'oola:chatbot-inquiry-ready',
            function() {

                console.log(
                    'Chatbot is ready to start inquiry.'
                );

            }
        );

    })();
</script>

@stack('scripts')
