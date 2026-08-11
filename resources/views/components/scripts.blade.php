<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    /* ==========================================================
     * CAPTCHA
     * ========================================================== */

    /**
     * Refresh a CAPTCHA instance.
     *
     * Normal forms use:
     *     captcha-inquiry-text
     *
     * Chatbot inquiry form uses:
     *     captcha-inquiry-chatbot-text
     *
     * The server-side CAPTCHA session remains the same.
     */

    function refreshCaptcha(type, instance = null) {

        const elementId = instance ?
            `captcha-${type}-${instance}-text` :
            `captcha-${type}-text`;

        const element =
            document.getElementById(elementId);

        if (!element) {

            console.warn(
                `CAPTCHA element not found: ${elementId}`
            );

            return;

        }


        element.textContent = 'Loading...';


        fetch(`/refresh-captcha/${type}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => {

                if (!response.ok) {

                    throw new Error(
                        `HTTP ${response.status}`
                    );

                }

                return response.json();

            })
            .then(data => {

                if (data.question) {

                    element.textContent =
                        data.question;

                } else {

                    element.textContent =
                        'Unable to load';

                }

            })
            .catch(error => {

                console.error(
                    'Captcha Error:',
                    error
                );

                element.textContent =
                    'Unable to load';

            });

    }


    /**
     * Refresh CAPTCHA inside a specific container.
     *
     * This is used by the chatbot Inquiry form so that
     * its refresh button does not accidentally target
     * the normal Inquiry form.
     */
    function refreshCaptchaInstance(
        type,
        instance
    ) {

        refreshCaptcha(
            type,
            instance
        );

    }


    /* ==========================================================
     * COMMON SITE FUNCTIONS
     * ========================================================== */

    (function() {

        const progressBar =
            document.getElementById(
                'topProgressBar'
            );

        const nav =
            document.querySelector(
                '[data-nav]'
            );


        /* ------------------------------------------------------
         * Scroll Progress
         * ------------------------------------------------------ */

        function onScroll() {

            const scrollTop =
                window.scrollY;

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
                document.getElementById(
                    'mobileMenu'
                );


            if (menu) {

                menu.classList.add(
                    'active'
                );

                document.body.style.overflow =
                    'hidden';

            }

        };


        window.closeMenu = function() {

            const menu =
                document.getElementById(
                    'mobileMenu'
                );


            if (menu) {

                menu.classList.remove(
                    'active'
                );

                document.body.style.overflow =
                    '';

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
                document.querySelectorAll(
                    '.reveal'
                );


            if (
                revealEls.length &&
                'IntersectionObserver' in window
            ) {

                const revealObserver =
                    new IntersectionObserver(
                        function(entries) {

                            entries.forEach(
                                function(entry) {

                                    if (
                                        entry.isIntersecting
                                    ) {

                                        entry.target.classList.add(
                                            'is-visible'
                                        );


                                        revealObserver.unobserve(
                                            entry.target
                                        );

                                    }

                                }
                            );

                        }, {
                            threshold: 0.12,
                            rootMargin: '0px 0px -40px 0px'
                        }
                    );


                revealEls.forEach(
                    function(el) {

                        revealObserver.observe(
                            el
                        );

                    }
                );


            } else {

                revealEls.forEach(
                    function(el) {

                        el.classList.add(
                            'is-visible'
                        );

                    }
                );

            }


        } else {

            document
                .querySelectorAll('.reveal')
                .forEach(
                    function(el) {

                        el.classList.add(
                            'is-visible'
                        );

                    }
                );

        }


        /* ------------------------------------------------------
         * Initialize Existing CAPTCHA Instances
         * ------------------------------------------------------ */

        document
            .querySelectorAll(
                "[id^='captcha-'][id$='-text']"
            )
            .forEach(
                function(element) {

                    /*
                     * Only initialize standard CAPTCHA
                     * instances here.
                     *
                     * Chatbot CAPTCHA does not exist in
                     * the DOM until the inquiry stage.
                     */

                    const id =
                        element.id;


                    if (
                        id.includes(
                            '-chatbot-'
                        )
                    ) {

                        return;

                    }


                    const type =
                        id
                        .replace(
                            'captcha-',
                            ''
                        )
                        .replace(
                            '-text',
                            ''
                        );


                    refreshCaptcha(
                        type
                    );

                }
            );

    })();


    /* ==========================================================
     * AI CHATBOT
     * ========================================================== */

    (function() {

        const chatbot =
            document.getElementById(
                'ai-chatbot'
            );

        const toggle =
            document.getElementById(
                'ai-chatbot-toggle'
            );

        const panel =
            document.getElementById(
                'ai-chatbot-panel'
            );

        const close =
            document.getElementById(
                'ai-chatbot-close'
            );

        const input =
            document.getElementById(
                'ai-chatbot-input'
            );

        const send =
            document.getElementById(
                'ai-chatbot-send'
            );

        const messages =
            document.getElementById(
                'ai-chatbot-messages'
            );

        const inquiryTemplate =
            document.getElementById(
                'ai-chatbot-inquiry-template'
            );

        const inquiryForm =
            document.getElementById(
                'ai-chatbot-inquiry-form'
            );

        const inputArea =
            document.querySelector(
                '.ai-chatbot-input-area'
            );


        /*
         * Inquiry form state.
         */

        let inquiryFormVisible =
            false;


        /*
         * Prevent JavaScript from silently failing
         * if the chatbot markup is incomplete.
         */

        if (!chatbot) {

            console.warn(
                'AI Chatbot: #ai-chatbot was not found.'
            );

            return;

        }


        if (!toggle) {

            console.warn(
                'AI Chatbot: toggle button was not found.'
            );

            return;

        }


        if (!panel) {

            console.warn(
                'AI Chatbot: panel was not found.'
            );

            return;

        }


        if (!close) {

            console.warn(
                'AI Chatbot: close button was not found.'
            );

            return;

        }


        if (!input) {

            console.warn(
                'AI Chatbot: input was not found.'
            );

            return;

        }


        if (!send) {

            console.warn(
                'AI Chatbot: send button was not found.'
            );

            return;

        }


        if (!messages) {

            console.warn(
                'AI Chatbot: messages container was not found.'
            );

            return;

        }


        /* ----------------------------------------------------------
         * OPEN CHATBOT
         * ---------------------------------------------------------- */

        function openChatbot() {

            chatbot.classList.add(
                'is-open'
            );


            toggle.setAttribute(
                'aria-expanded',
                'true'
            );


            panel.setAttribute(
                'aria-hidden',
                'false'
            );


            if (
                !inquiryFormVisible
            ) {

                setTimeout(
                    function() {

                        input.focus();

                    },
                    100
                );

            }

        }


        /* ----------------------------------------------------------
         * CLOSE CHATBOT
         * ---------------------------------------------------------- */

        function closeChatbot() {

            chatbot.classList.remove(
                'is-open'
            );


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
            function(event) {

                event.preventDefault();

                event.stopPropagation();


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
            function(event) {

                event.preventDefault();

                event.stopPropagation();

                closeChatbot();

            }
        );


        /* ----------------------------------------------------------
         * ADD USER MESSAGE
         * ---------------------------------------------------------- */

        function addUserMessage(
            message
        ) {

            const wrapper =
                document.createElement(
                    'div'
                );


            wrapper.className =
                'ai-chatbot-message ai-chatbot-message-user';


            const content =
                document.createElement(
                    'div'
                );


            content.className =
                'ai-chatbot-message-content';


            content.textContent =
                message;


            wrapper.appendChild(
                content
            );


            messages.appendChild(
                wrapper
            );


            scrollMessagesToBottom();

        }


        /* ----------------------------------------------------------
         * ADD BOT MESSAGE
         * ---------------------------------------------------------- */

        function addBotMessage(
            message
        ) {

            const wrapper =
                document.createElement(
                    'div'
                );


            wrapper.className =
                'ai-chatbot-message ai-chatbot-message-bot';


            const content =
                document.createElement(
                    'div'
                );


            content.className =
                'ai-chatbot-message-content';


            content.textContent =
                message;


            wrapper.appendChild(
                content
            );


            messages.appendChild(
                wrapper
            );


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
                document.createElement(
                    'div'
                );


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


            messages.appendChild(
                wrapper
            );


            scrollMessagesToBottom();

        }


        function hideTyping() {

            const typing =
                document.getElementById(
                    'ai-chatbot-typing'
                );


            if (typing) {

                typing.remove();

            }

        }


        /* ----------------------------------------------------------
         * PREPARE CHATBOT INQUIRY FORM
         * ---------------------------------------------------------- */

        function prepareChatbotInquiryForm() {

            if (
                !inquiryTemplate ||
                !inquiryForm
            ) {

                console.warn(
                    'AI Chatbot: inquiry form template/container not found.'
                );

                return false;

            }


            /*
             * Do not insert the template more than once.
             */

            if (
                inquiryForm.dataset.loaded === 'true'
            ) {

                return true;

            }


            /*
             * Clone the template.
             */

            const fragment =
                inquiryTemplate.content.cloneNode(
                    true
                );


            /*
             * Insert the reusable Inquiry form.
             */

            inquiryForm.appendChild(
                fragment
            );


            /*
             * ------------------------------------------------------
             * Make every ID inside the chatbot Inquiry form unique.
             * ------------------------------------------------------
             *
             * This prevents conflicts with the normal Inquiry form
             * already rendered elsewhere on the page.
             */

            const elementsWithId =
                inquiryForm.querySelectorAll(
                    '[id]'
                );


            elementsWithId.forEach(
                function(element) {

                    const oldId =
                        element.id;


                    /*
                     * Don't prefix IDs twice.
                     */

                    if (
                        oldId.startsWith(
                            'chatbot-'
                        )
                    ) {

                        return;

                    }


                    const newId =
                        'chatbot-' +
                        oldId;


                    /*
                     * Update associated labels.
                     */

                    document
                        .querySelectorAll(
                            `label[for="${oldId}"]`
                        )
                        .forEach(
                            function(label) {

                                /*
                                 * Only modify labels that belong
                                 * to this chatbot form.
                                 */

                                if (
                                    inquiryForm.contains(
                                        label
                                    )
                                ) {

                                    label.setAttribute(
                                        'for',
                                        newId
                                    );

                                }

                            }
                        );


                    element.id =
                        newId;

                }
            );


            /*
             * ------------------------------------------------------
             * CAPTCHA
             * ------------------------------------------------------
             */

            const captchaText =
                inquiryForm.querySelector(
                    '#chatbot-captcha-inquiry-text'
                );


            if (captchaText) {

                /*
                 * Ensure a unique chatbot CAPTCHA ID.
                 */

                captchaText.id =
                    'captcha-inquiry-chatbot-text';

            }


            /*
             * Update CAPTCHA refresh links.
             */

            inquiryForm
                .querySelectorAll(
                    '[onclick*="refreshCaptcha"]'
                )
                .forEach(
                    function(link) {

                        link.removeAttribute(
                            'onclick'
                        );


                        link.addEventListener(
                            'click',
                            function(event) {

                                event.preventDefault();


                                refreshCaptchaInstance(
                                    'inquiry',
                                    'chatbot'
                                );

                            }
                        );

                    }
                );


            inquiryForm.dataset.loaded =
                'true';


            return true;

        }

        /* ----------------------------------------------------------
         * POPULATE CHATBOT INQUIRY FORM
         * Phase 2G-2
         * ---------------------------------------------------------- */

        function populateChatbotInquiryForm(extracted = {}) {

            if (!inquiryForm) {
                return;
            }

            /*
             * ------------------------------------------------------
             * Helper: find a form field by its name.
             * ------------------------------------------------------
             */

            function getField(name) {

                return inquiryForm.querySelector(
                    `[name="${name}"]`
                );

            }


            /*
             * ------------------------------------------------------
             * Project Type
             * ------------------------------------------------------
             *
             * The AI may return:
             *
             *   "AI mobile app development"
             *   "AI-powered mobile app development"
             *   "Mobile App Development"
             *
             * We map that to one of the existing select options.
             */

            const projectType =
                getField('project_type');


            if (projectType) {

                const serviceInterest =
                    String(
                        extracted.service_interest || ''
                    ).toLowerCase();


                let selectedType = '';


                if (
                    serviceInterest.includes('mobile') ||
                    serviceInterest.includes('app')
                ) {

                    selectedType =
                        'Mobile App Development';

                } else if (
                    serviceInterest.includes('artificial intelligence') ||
                    serviceInterest.includes('ai')
                ) {

                    selectedType =
                        'Artificial Intelligence';

                } else if (
                    serviceInterest.includes('cloud')
                ) {

                    selectedType =
                        'Cloud Engineering & Migration';

                } else if (
                    serviceInterest.includes('web')
                ) {

                    selectedType =
                        'Web Application Development';

                } else if (
                    serviceInterest.includes('data')
                ) {

                    selectedType =
                        'Data Engineering & Analytics';

                } else if (
                    serviceInterest.includes('devops')
                ) {

                    selectedType =
                        'DevOps & Platform Engineering';

                } else if (
                    serviceInterest.includes('consult')
                ) {

                    selectedType =
                        'Technology Consulting';

                } else if (
                    serviceInterest.includes('training')
                ) {

                    selectedType =
                        'Corporate Training & Workshops';

                }


                /*
                 * Only select a value if it actually exists
                 * in the current form options.
                 */

                if (
                    selectedType &&
                    Array.from(
                        projectType.options
                    ).some(
                        option =>
                        option.value === selectedType
                    )
                ) {

                    projectType.value =
                        selectedType;

                    projectType.dispatchEvent(
                        new Event(
                            'change', {
                                bubbles: true
                            }
                        )
                    );

                }

            }


            /*
             * ------------------------------------------------------
             * Project Requirements
             * ------------------------------------------------------
             *
             * Build one clean message from everything already
             * extracted by the AI.
             */

            const messageField =
                getField('message');


            if (messageField) {

                const sections = [];


                /*
                 * Business Need
                 */

                if (
                    extracted.business_need
                ) {

                    sections.push(
                        `Business Need:\n${extracted.business_need}`
                    );

                }


                /*
                 * Requirements
                 */

                if (
                    Array.isArray(
                        extracted.requirements
                    ) &&
                    extracted.requirements.length > 0
                ) {

                    sections.push(
                        `Requirements:\n- ${
                    extracted.requirements.join('\n- ')
                }`
                    );

                }


                /*
                 * Timeline
                 */

                if (
                    extracted.timeline
                ) {

                    sections.push(
                        `Expected Timeline: ${extracted.timeline}`
                    );

                }


                /*
                 * Budget
                 *
                 * Only add it if the visitor actually provided it.
                 */

                if (
                    extracted.budget_range
                ) {

                    sections.push(
                        `Budget Range: ${extracted.budget_range}`
                    );

                }


                /*
                 * Existing content should normally be empty
                 * because this is a newly-created chatbot form.
                 */

                if (
                    sections.length > 0
                ) {

                    messageField.value =
                        sections.join('\n\n');

                    messageField.dispatchEvent(
                        new Event(
                            'input', {
                                bubbles: true
                            }
                        )
                    );

                }

            }


            /*
             * ------------------------------------------------------
             * Visual indication
             * ------------------------------------------------------
             *
             * Mark fields populated by AI so we can later style
             * or label them if desired.
             */

            const populatedFields =
                inquiryForm.querySelectorAll(
                    '[name="project_type"], [name="message"]'
                );


            populatedFields.forEach(
                function(field) {

                    if (
                        field.value &&
                        field.value.trim() !== ''
                    ) {

                        field.dataset.aiPopulated =
                            'true';

                    }

                }
            );


            console.log(
                'AI inquiry form populated:',
                extracted
            );

        }

        /* ----------------------------------------------------------
         * SHOW INQUIRY FORM
         * Phase 2G-1
         * ---------------------------------------------------------- */

        function showInquiryForm(extracted = {}) {

            if (
                inquiryFormVisible
            ) {

                return;

            }


            /*
             * Prepare form.
             */

            const prepared =
                prepareChatbotInquiryForm();


            if (!prepared) {

                addBotMessage(
                    'I have enough information to proceed, but the inquiry form could not be loaded. Please try again.'
                );

                return;

            }


            /*
             * Update state.
             */

            inquiryFormVisible =
                true;


            /*
             * Show form.
             */

            inquiryForm.classList.remove(
                'd-none'
            );


            /*
             * Hide chatbot text input.
             */

            if (inputArea) {

                inputArea.classList.add(
                    'd-none'
                );

            }


            /*
             * Disable chatbot input.
             */

            input.disabled =
                true;

            send.disabled =
                true;


            /*
             * Refresh chatbot CAPTCHA.
             *
             * This happens only after the chatbot form
             * has been inserted into the DOM.
             */

            refreshCaptchaInstance(
                'inquiry',
                'chatbot'
            );

            /*
             * Populate the reusable inquiry form with information
             * already captured during the chatbot conversation.
             *
             * Name, email and CAPTCHA intentionally remain empty.
             */
            populateChatbotInquiryForm(
                extracted
            );


            /*
             * Dispatch event for future integrations.
             */

            const event =
                new CustomEvent(
                    'oola:chatbot-inquiry-ready'
                );


            document.dispatchEvent(
                event
            );


            /*
             * Scroll inquiry form into view.
             */

            setTimeout(
                function() {

                    inquiryForm.scrollIntoView({
                        behavior: 'smooth',
                        block: 'nearest'
                    });


                },
                100
            );

        }


        /* ----------------------------------------------------------
         * SEND MESSAGE
         * ---------------------------------------------------------- */

        async function sendMessage() {

            /*
             * Never send another chatbot message after
             * inquiry form has been activated.
             */

            if (inquiryFormVisible) {

                return;

            }


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


            /*
             * Display visitor message immediately.
             */

            addUserMessage(
                message
            );


            input.value =
                '';


            /*
             * Disable input while AI is processing.
             */

            send.disabled =
                true;

            input.disabled =
                true;


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


                /*
                 * Handle non-JSON responses safely.
                 */

                const contentType =
                    response.headers.get(
                        'content-type'
                    ) || '';


                let data;


                if (
                    contentType.includes(
                        'application/json'
                    )
                ) {

                    data =
                        await response.json();

                } else {

                    throw new Error(
                        `Unexpected response type: ${contentType}`
                    );

                }


                /*
                 * Remove typing indicator.
                 */

                hideTyping();


                /*
                 * API / AI error.
                 */

                if (
                    !response.ok ||
                    !data.success
                ) {

                    addBotMessage(
                        data.message ||
                        'I’m sorry, something went wrong. Please try again.'
                    );

                    return;

                }


                /*
                 * Display AI response.
                 */

                if (
                    data.message
                ) {

                    addBotMessage(
                        data.message
                    );

                }


                /*
                 * Inquiry readiness.
                 *
                 * IMPORTANT:
                 * Only show the Inquiry form when the backend
                 * explicitly says the visitor is ready.
                 *
                 * Pass the extracted AI information so the form
                 * can be pre-populated.
                 */

                if (
                    data.ready_for_inquiry === true
                ) {

                    showInquiryForm(
                        data.extracted || {}
                    );

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

                /*
                 * IMPORTANT:
                 *
                 * If the Inquiry form has appeared,
                 * NEVER restore the chatbot input.
                 */

                if (
                    !inquiryFormVisible
                ) {

                    send.disabled =
                        false;

                    input.disabled =
                        false;

                    input.focus();

                }

            }

        }


        /* ----------------------------------------------------------
         * SEND BUTTON
         * ---------------------------------------------------------- */

        send.addEventListener(
            'click',
            function(event) {

                event.preventDefault();

                sendMessage();

            }
        );


        /* ----------------------------------------------------------
         * ENTER KEY
         * ---------------------------------------------------------- */

        input.addEventListener(
            'keydown',
            function(event) {

                if (
                    event.key === 'Enter' &&
                    !event.shiftKey &&
                    !inquiryFormVisible
                ) {

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
                    'Chatbot inquiry form is now visible.'
                );

            }
        );


    })();
</script>

@stack('scripts')
