{{-- ==========================================================
     AI CHATBOT WIDGET
     Phase 2G-1
=========================================================== --}}

<div id="ai-chatbot" class="ai-chatbot">

    {{-- ======================================================
         SURPRISE GREETING
    ======================================================= --}}
    <div
        id="ai-chatbot-greeting"
        class="ai-chatbot-greeting">

        <strong>Need help with your project?</strong>

        <br>

        I can help you explore our services or start an inquiry.

    </div>


    {{-- ======================================================
         FLOATING BUTTON
    ======================================================= --}}
    <button
        type="button"
        id="ai-chatbot-toggle"
        class="ai-chatbot-toggle"
        aria-label="Open AI Assistant"
        aria-expanded="false">

        <i class="bi bi-robot"></i>

    </button>


    {{-- ======================================================
         CHAT PANEL
    ======================================================= --}}
    <div
        id="ai-chatbot-panel"
        class="ai-chatbot-panel"
        aria-hidden="true">


        {{-- ==================================================
             HEADER
        =================================================== --}}
        <div class="ai-chatbot-header">

            <div class="d-flex align-items-center gap-2">

                <div class="ai-chatbot-avatar">
                    <i class="bi bi-robot"></i>
                </div>

                <div>

                    <div class="fw-semibold">
                        Oola AI Assistant
                    </div>

                    <small class="opacity-75">
                        How can we help you?
                    </small>

                </div>

            </div>


            <button
                type="button"
                id="ai-chatbot-close"
                class="ai-chatbot-close"
                aria-label="Close AI Assistant">

                <i class="bi bi-x-lg"></i>

            </button>

        </div>


        {{-- ==================================================
             CHAT MESSAGES
        =================================================== --}}
        <div
            id="ai-chatbot-messages"
            class="ai-chatbot-messages">

            <div class="ai-chatbot-message ai-chatbot-message-bot">

                <div class="ai-chatbot-message-content">

                    Hi! 👋

                    <br>

                    I'm Oola's AI Assistant.

                    <br>

                    Are you looking for help with a project,
                    service, or would you like to make an inquiry?

                </div>

            </div>

        </div>


        {{-- ==================================================
             CHATBOT INQUIRY FORM TEMPLATE
             --------------------------------------------------
             IMPORTANT:
             The form is kept inside <template> so its
             form-field IDs do not exist in the DOM until
             the visitor actually reaches the inquiry stage.
        =================================================== --}}

        <template id="ai-chatbot-inquiry-template">

            @include('components.forms.inquiry-form', [
                'mode' => 'chatbot',
                'showHeading' => false,
            ])

        </template>


        {{-- ==================================================
             CHATBOT INQUIRY FORM CONTAINER
        =================================================== --}}
        <div
            id="ai-chatbot-inquiry-form"
            class="ai-chatbot-inquiry-form d-none">

        </div>


        {{-- ==================================================
             CHAT INPUT
        =================================================== --}}
        <div class="ai-chatbot-input-area">

            <input
                type="text"
                id="ai-chatbot-input"
                class="form-control"
                placeholder="Type your message..."
                autocomplete="off">

            <button
                type="button"
                id="ai-chatbot-send"
                class="ai-chatbot-send"
                aria-label="Send message">

                <i class="bi bi-send-fill"></i>

            </button>

        </div>

    </div>

</div>
