<?php

namespace App\Services\AI;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class GeminiProvider implements AIProviderInterface
{
    /**
     * Generate a response using Gemini.
     */
    public function generate(string $prompt): string
    {
        $baseUrl = rtrim(
            config('ai.gemini.base_url'),
            '/'
        );

        $apiKey = config('ai.gemini.api_key');

        $model = config('ai.gemini.model');

        if (empty($apiKey)) {
            throw new RuntimeException(
                'Gemini API key is not configured.'
            );
        }

        $url = sprintf(
            '%s/models/%s:generateContent',
            $baseUrl,
            $model
        );

        $response = Http::timeout(120)
            ->withHeaders([
                'x-goog-api-key' => $apiKey,
                'Content-Type' => 'application/json',
            ])
            ->post($url, [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => $prompt,
                            ],
                        ],
                    ],
                ],
            ]);

        if ($response->failed()) {
            throw new RuntimeException(
                'Gemini request failed: ' .
                $response->body()
            );
        }

        $data = $response->json();

        $text = $data['candidates'][0]['content']['parts'][0]['text']
            ?? null;

        if ($text === null) {
            throw new RuntimeException(
                'Gemini returned an invalid response.'
            );
        }

        return trim($text);
    }
}
