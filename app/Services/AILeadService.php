<?php

namespace App\Services;

use App\Models\Inquiry;
use App\Services\AI\AIProviderFactory;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class AILeadService
{
    /**
     * Analyze an inquiry using the configured AI provider.
     */
    public function analyze(Inquiry $inquiry): Inquiry
    {
        $prompt = $this->buildPrompt($inquiry);

        $provider = AIProviderFactory::make();

        $response = $provider->generate($prompt);

        $analysis = $this->parseResponse($response);

        $inquiry->update([
            'lead_score' => $analysis['lead_score'],
            'lead_temperature' => $analysis['lead_temperature'],
            'service_interest' => $analysis['service_interest'],
            'timeline' => $analysis['timeline'],
            'budget_range' => $analysis['budget_range'],
            'ai_summary' => $analysis['summary'],
            'ai_recommendation' => $analysis['recommendation'],
            'ai_processed_at' => now(),
        ]);

        return $inquiry->fresh();
    }

    /**
     * Build the lead-analysis prompt.
     */
    private function buildPrompt(Inquiry $inquiry): string
    {
        return <<<PROMPT
        You are an enterprise B2B lead qualification assistant for Oola Systems.

        Analyze the following business inquiry and return ONLY valid JSON.

        Inquiry:
        Name: {$inquiry->name}
        Email: {$inquiry->email}
        Project Type: {$inquiry->project_type}
        Message: {$inquiry->message}

        Evaluate the inquiry based on:
        - Business need
        - Service fit
        - Urgency
        - Timeline
        - Budget information
        - Potential business value

        Return exactly this JSON structure:

        {
            "lead_score": 0,
            "lead_temperature": "LOW",
            "service_interest": "",
            "timeline": "",
            "budget_range": "",
            "summary": "",
            "recommendation": ""
        }

        Rules:
        - lead_score must be an integer from 0 to 100.
        - lead_temperature must be one of: HOT, WARM, QUALIFIED, LOW.
        - Do not invent budget or timeline information.
        - Use "Not specified" when information is unavailable.
        - summary must be concise.
        - recommendation must specify the most appropriate next business action.
        - Return JSON only. No markdown. No explanation.
        PROMPT;
    }

    /**
     * Validate and normalize the AI response.
     */
    private function parseResponse(string $response): array
    {
        $response = trim($response);

        // Remove optional Markdown JSON fences.
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

        $data = json_decode($response, true);

        if (!is_array($data)) {
            Log::error('Invalid AI lead analysis response.', [
                'response' => $response,
            ]);

            throw new RuntimeException(
                'AI returned an invalid lead analysis response.'
            );
        }

        $required = [
            'lead_score',
            'lead_temperature',
            'service_interest',
            'timeline',
            'budget_range',
            'summary',
            'recommendation',
        ];

        foreach ($required as $field) {
            if (!array_key_exists($field, $data)) {
                throw new RuntimeException(
                    "AI response is missing field: {$field}"
                );
            }
        }

        $score = (int) $data['lead_score'];

        if ($score < 0 || $score > 100) {
            throw new RuntimeException(
                'AI returned an invalid lead score.'
            );
        }

        $temperature = strtoupper(
            trim((string) $data['lead_temperature'])
        );

        $allowedTemperatures = [
            'HOT',
            'WARM',
            'QUALIFIED',
            'LOW',
        ];

        if (!in_array($temperature, $allowedTemperatures, true)) {
            throw new RuntimeException(
                'AI returned an invalid lead temperature.'
            );
        }

        return [
            'lead_score' => $score,
            'lead_temperature' => $temperature,
            'service_interest' => trim(
                (string) $data['service_interest']
            ),
            'timeline' => trim(
                (string) $data['timeline']
            ),
            'budget_range' => trim(
                (string) $data['budget_range']
            ),
            'summary' => trim(
                (string) $data['summary']
            ),
            'recommendation' => trim(
                (string) $data['recommendation']
            ),
        ];
    }
}
