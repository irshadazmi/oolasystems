{{-- ==========================================================
     OOLA AI CHATBOT
=========================================================== --}}

<div
    id="oolaChatbot"
    class="oola-chatbot"
    aria-hidden="true"
>

    {{-- ======================================================
         CHATBOT PANEL
    ======================================================= --}}

    <div
        class="oola-chatbot-panel"
        role="dialog"
        aria-modal="false"
        aria-labelledby="oolaChatbotTitle"
    >

        {{-- Header --}}

        <div class="oola-chatbot-header">

            <div class="d-flex align-items-center gap-2">

                <div class="oola-chatbot-avatar">
                    <i class="bi bi-robot"></i>
                </div>

                <div>

                    <div
                        id="oolaChatbotTitle"
                        class="oola-chatbot-title"
                    >
                        Oola AI Assistant
                    </div>

                    <div class="oola-chatbot-status">
                        <span class="oola-chatbot-status-dot"></span>
                        Online
                    </div>

                </div>

            </div>


            <button
                type="button"
                id="oolaChatbotClose"
                class="oola-chatbot-close"
                aria-label="Close AI Assistant"
            >
                <i class="bi bi-x-lg"></i>
            </button>

        </div>


        {{-- Conversation --}}

        <div
            id="oolaChatbotMessages"
            class="oola-chatbot-messages"
        >

            {{-- AI welcome message --}}

            <div class="oola-chat-message oola-chat-message-ai">

                <div class="oola-chat-avatar oola-chat-avatar-small">
                    <i class="bi bi-robot"></i>
                </div>

                <div class="oola-chat-bubble">

                    <div class="oola-chat-bubble-text">

                        Hi! 👋 I'm Oola's AI assistant.

                        <br><br>

                        I can help you explore our technology
                        services or help you start an inquiry.

                    </div>

                </div>

            </div>


            {{-- Prompt --}}

            <div class="oola-chat-message oola-chat-message-ai">

                <div class="oola-chat-avatar oola-chat-avatar-small">
                    <i class="bi bi-robot"></i>
                </div>

                <div class="oola-chat-bubble">

                    <div class="oola-chat-bubble-text">

                        What are you looking for?

                    </div>

                </div>

            </div>


            {{-- Quick replies --}}

            <div
                id="oolaChatbotQuickReplies"
                class="oola-chatbot-quick-replies"
            >

                <button
                    type="button"
                    class="oola-chatbot-option"
                    data-chat-option="AI & Machine Learning"
                >
                    <i class="bi bi-stars"></i>
                    AI & Machine Learning
                </button>


                <button
                    type="button"
                    class="oola-chatbot-option"
                    data-chat-option="Software Development"
                >
                    <i class="bi bi-code-slash"></i>
                    Software Development
                </button>


                <button
                    type="button"
                    class="oola-chatbot-option"
                    data-chat-option="Cloud & DevOps"
                >
                    <i class="bi bi-cloud"></i>
                    Cloud & DevOps
                </button>


                <button
                    type="button"
                    class="oola-chatbot-option"
                    data-chat-option="Digital Transformation"
                >
                    <i class="bi bi-diagram-3"></i>
                    Digital Transformation
                </button>


                <button
                    type="button"
                    class="oola-chatbot-option"
                    data-chat-option="Something else"
                >
                    <i class="bi bi-three-dots"></i>
                    Something else
                </button>

            </div>

        </div>


        {{-- Input area --}}

        <div class="oola-chatbot-input-area">

            <div class="oola-chatbot-input-wrapper">

                <input
                    type="text"
                    id="oolaChatbotInput"
                    class="oola-chatbot-input"
                    placeholder="Type your message..."
                    autocomplete="off"
                    aria-label="Chat message"
                >

                <button
                    type="button"
                    id="oolaChatbotSend"
                    class="oola-chatbot-send"
                    aria-label="Send message"
                >
                    <i class="bi bi-arrow-up"></i>
                </button>

            </div>


            <div class="oola-chatbot-disclaimer">

                AI assistant • Your conversation helps us
                understand your requirements.

            </div>

        </div>

    </div>


    {{-- ======================================================
         FLOATING LAUNCHER
    ======================================================= --}}

    <button
        type="button"
        id="oolaChatbotLauncher"
        class="oola-chatbot-launcher"
        aria-label="Open Oola AI Assistant"
        aria-expanded="false"
    >

        <span class="oola-chatbot-launcher-icon">
            <i class="bi bi-robot"></i>
        </span>

        <span class="oola-chatbot-launcher-close">
            <i class="bi bi-x-lg"></i>
        </span>

    </button>


    {{-- Proactive invitation --}}

    <div
        id="oolaChatbotInvite"
        class="oola-chatbot-invite"
        role="status"
    >

        <button
            type="button"
            id="oolaChatbotInviteClose"
            class="oola-chatbot-invite-close"
            aria-label="Dismiss"
        >
            <i class="bi bi-x"></i>
        </button>

        <div class="oola-chatbot-invite-title">
            Need help with your technology initiative?
        </div>

        <div class="oola-chatbot-invite-text">
            I can help you find the right Oola Systems solution.
        </div>

        <button
            type="button"
            id="oolaChatbotInviteOpen"
            class="btn btn-sm btn-primary mt-2"
        >
            Let's talk
        </button>

    </div>

</div>
