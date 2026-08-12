<?php

namespace App\Providers\AI;

use App\Exceptions\AI\AINonRetryableException;
use App\Exceptions\AI\AIRetryableException;
use Illuminate\Support\Facades\Http;

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

        /*
         * Configuration errors should NOT be retried.
         */
        if (empty($apiKey)) {
            throw new AINonRetryableException(
                'Gemini API key is not configured.'
            );
        }

        if (empty($model)) {
            throw new AINonRetryableException(
                'Gemini model is not configured.'
            );
        }

        if (empty($baseUrl)) {
            throw new AINonRetryableException(
                'Gemini base URL is not configured.'
            );
        }

        $url = sprintf(
            '%s/models/%s:generateContent',
            $baseUrl,
            $model
        );

        try {

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

        } catch (\Throwable $exception) {

            /*
             * Network/connection/timeout errors are normally
             * temporary and should be retried.
             */
            throw new AIRetryableException(
                'Gemini connection failed: ' .
                $exception->getMessage(),
                30,
                $exception
            );
        }

        $status = $response->status();

        /*
         * 429 = quota/rate limit.
         *
         * Retry, but with a longer delay. We deliberately
         * avoid hammering the Gemini API.
         */
        if ($status === 429) {

            $retryAfter = 60;

            $retryAfterHeader = $response->header(
                'Retry-After'
            );

            if (
                is_numeric($retryAfterHeader) &&
                (int) $retryAfterHeader > 0
            ) {
                $retryAfter = (int) $retryAfterHeader;
            }

            throw new AIRetryableException(
                'Gemini quota/rate limit exceeded: ' .
                $response->body(),
                $retryAfter
            );
        }

        /*
         * Temporary Gemini service failures.
         */
        if (
            $status === 500 ||
            $status === 502 ||
            $status === 503 ||
            $status === 504
        ) {

            throw new AIRetryableException(
                'Gemini temporary service failure (' .
                $status .
                '): ' .
                $response->body(),
                30
            );
        }

        /*
         * Other 4xx errors are normally configuration,
         * authentication, validation, or request errors.
         *
         * Do NOT waste queue retries on them.
         */
        if ($response->failed()) {

            throw new AINonRetryableException(
                'Gemini request failed (' .
                $status .
                '): ' .
                $response->body()
            );
        }

        $data = $response->json();

        $text =
            $data['candidates'][0]['content']['parts'][0]['text']
            ?? null;

        /*
         * Invalid AI output can be transient, so allow
         * the queue to retry it.
         */
        if ($text === null) {

            throw new AIRetryableException(
                'Gemini returned an invalid response.',
                30
            );
        }

        return trim($text);
    }
}