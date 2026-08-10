<?php

namespace App\Services;

use App\Services\AI\AIProviderFactory;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class ChatbotService
{
    /**
     * Fields the chatbot attempts to collect.
     */
    private const REQUIRED_FIELDS = [
        'service_interest',
        'business_need',
        'requirements',
        'timeline',
        'budget_range',
    ];

    /**
     * Process one visitor message.
     */
    public function respond(
        string $message,
        array $state
    ): array {
        $history = $state['history'] ?? [];
        $extracted = $state['extracted'] ?? [];

        $history[] = [
            'role' => 'user',
            'content' => $message,
        ];

        $prompt = $this->buildPrompt(
            $message,
            $history,
            $extracted
        );

        $provider = AIProviderFactory::make();

        $response = $provider->generate($prompt);

        $result = $this->parseResponse($response);

        /*
         * Merge newly extracted information with
         * everything already known.
         */
        $merged = $this->mergeExtractedData(
            $extracted,
            $result['extracted'] ?? []
        );

        /*
         * Keep the latest AI response in conversation history.
         */
        $history[] = [
            'role' => 'assistant',
            'content' => $result['message'],
        ];

        /*
         * The AI determines whether we are ready.
         */
        $awaitingConfirmation =
            (bool) ($result['confirmation_required'] ?? false);

        $readyForInquiry =
            (bool) ($result['ready_for_inquiry'] ?? false);

        return [
            'message' => $result['message'],
            'extracted' => $merged,
            'missing' => $this->getMissingFields($merged),
            'confirmation_required' => $awaitingConfirmation,
            'ready_for_inquiry' => $readyForInquiry,
            'show_inquiry_form' => $readyForInquiry,
            'history' => $history,
        ];
    }

    /**
     * Build the conversational AI prompt.
     */
    private function buildPrompt(
        string $message,
        array $history,
        array $extracted
    ): string {
        $historyText = $this->formatHistory($history);

        $stateJson = json_encode(
            $extracted,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );

        return <<<PROMPT
You are Oola Systems' AI website assistant.

Your role is to have a natural, concise conversation with a potential
business customer and qualify a project inquiry.

You are NOT a form.
Do NOT ask a question merely because a field is empty.
First determine what information has already been provided.

IMPORTANT CONVERSATION RULE:

If information has already been provided anywhere in the conversation,
DO NOT ask for it again.

For example:

Visitor:
"We expect to start within three months."

Then:
timeline = "Within three months"

You MUST NOT later ask:
"What is your timeline?"

Similarly, if the visitor provides architecture, development,
testing and deployment requirements, do not ask them again.

--------------------------------------------------
CURRENT EXTRACTED INFORMATION
--------------------------------------------------

{$stateJson}

--------------------------------------------------
CONVERSATION HISTORY
--------------------------------------------------

{$historyText}

--------------------------------------------------
LATEST VISITOR MESSAGE
--------------------------------------------------

{$message}

--------------------------------------------------
INFORMATION TO EXTRACT
--------------------------------------------------

Extract information whenever it appears naturally.

Fields:

1. service_interest
   The primary Oola service or solution the visitor is interested in.

2. business_need
   The business problem or objective.

3. requirements
   Specific requirements, capabilities or requested services.

4. timeline
   Expected start date, timeframe, urgency or deadline.

5. budget_range
   Budget or approximate investment range.

--------------------------------------------------
CONVERSATION RULES
--------------------------------------------------

1. Preserve information already known.

2. Never replace known information with null,
   empty string, "Not specified", or "Unknown".

3. Extract information from the ENTIRE conversation,
   not only the latest message.

4. One visitor message may contain several fields.
   Extract ALL of them.

5. Do not ask for information that is already known.

6. Ask for only ONE missing important piece of information
   at a time.

7. Keep questions conversational and concise.

8. Do not interrogate the visitor.

9. If enough information is available for a preliminary
   project discussion, ask for confirmation ONCE.

10. Confirmation wording should be similar to:
    "I have enough context to start a preliminary discussion.
     Would you like to connect with our team and submit the
     full project inquiry?"

11. If the visitor confirms YES to that question:
    - do NOT ask for confirmation again
    - set ready_for_inquiry to true
    - set confirmation_required to false

12. If the visitor says NO:
    continue the conversation naturally.

13. Never invent budget, timeline, company details,
    requirements or other facts.

--------------------------------------------------
READINESS
--------------------------------------------------

The visitor does not need to provide every field.

Consider the conversation ready for inquiry when you have
enough meaningful business context, normally including:

- service_interest
- business_need or requirements
- timeline OR a clear indication that timing is flexible

Budget is useful but is NOT mandatory.

--------------------------------------------------
OUTPUT
--------------------------------------------------

Return ONLY valid JSON.

Use exactly this structure:

{
    "message": "",
    "extracted": {
        "service_interest": null,
        "business_need": null,
        "requirements": [],
        "timeline": null,
        "budget_range": null
    },
    "confirmation_required": false,
    "ready_for_inquiry": false
}

Rules for extracted:

- Use null only when the information has never been provided.
- Use [] only when no requirements have been provided.
- Preserve previously known values.
- Do not erase previously known values.
- requirements must be an array of strings.

The "message" must be the natural conversational response
to the visitor.

Return JSON only.
PROMPT;
    }

    /**
     * Format conversation history for the AI.
     */
    private function formatHistory(array $history): string
    {
        if (!$history) {
            return '(No previous conversation.)';
        }

        return collect($history)
            ->map(function (array $item) {
                $role = $item['role'] === 'user'
                    ? 'Visitor'
                    : 'Assistant';

                return "{$role}: {$item['content']}";
            })
            ->implode("\n");
    }

    /**
     * Merge newly extracted information into existing state.
     */
    private function mergeExtractedData(
        array $existing,
        array $new
    ): array {
        $merged = [
            'service_interest' =>
                $existing['service_interest'] ?? null,

            'business_need' =>
                $existing['business_need'] ?? null,

            'requirements' =>
                $existing['requirements'] ?? [],

            'timeline' =>
                $existing['timeline'] ?? null,

            'budget_range' =>
                $existing['budget_range'] ?? null,
        ];

        foreach ([
            'service_interest',
            'business_need',
            'timeline',
            'budget_range',
        ] as $field) {
            $value = $new[$field] ?? null;

            if (
                is_string($value) &&
                trim($value) !== ''
            ) {
                $merged[$field] = trim($value);
            }
        }

        /*
         * Merge requirements rather than replacing them.
         */
        if (isset($new['requirements']) &&
            is_array($new['requirements'])) {

            $merged['requirements'] = array_values(
                array_unique(
                    array_filter(
                        array_merge(
                            $merged['requirements'],
                            $new['requirements']
                        ),
                        fn ($value) =>
                            is_string($value) &&
                            trim($value) !== ''
                    )
                )
            );
        }

        return $merged;
    }

    /**
     * Determine fields still missing.
     */
    private function getMissingFields(
        array $extracted
    ): array {
        $missing = [];

        foreach (self::REQUIRED_FIELDS as $field) {
            $value = $extracted[$field] ?? null;

            if ($field === 'requirements') {
                if (empty($value)) {
                    $missing[] = $field;
                }

                continue;
            }

            if (
                $value === null ||
                trim((string) $value) === ''
            ) {
                $missing[] = $field;
            }
        }

        return $missing;
    }

    /**
     * Parse and validate AI JSON.
     */
    private function parseResponse(
        string $response
    ): array {
        $response = trim($response);

        /*
         * Remove accidental markdown fences.
         */
        $response = preg_replace(
            '/^```json\s*/i',
            '',
            $response
        );

        $response = preg_replace(
            '/\s*```$/',
            '',
            $response
        );

        $data = json_decode(
            trim($response),
            true
        );

        if (!is_array($data)) {
            Log::error(
                'Invalid chatbot AI response.',
                [
                    'response' => $response,
                ]
            );

            throw new RuntimeException(
                'AI returned an invalid chatbot response.'
            );
        }

        if (
            !isset($data['message']) ||
            !is_string($data['message'])
        ) {
            throw new RuntimeException(
                'AI chatbot response is missing message.'
            );
        }

        return [
            'message' => trim($data['message']),

            'extracted' =>
                is_array($data['extracted'] ?? null)
                    ? $data['extracted']
                    : [],

            'confirmation_required' =>
                (bool) ($data['confirmation_required'] ?? false),

            'ready_for_inquiry' =>
                (bool) ($data['ready_for_inquiry'] ?? false),
        ];
    }
}
