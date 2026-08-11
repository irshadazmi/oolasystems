<?php

namespace App\Providers\AI;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class OllamaProvider implements AIProviderInterface
{
    /**
     * Generate a response using Ollama.
     */
    public function generate(string $prompt): string
    {
        $baseUrl = rtrim(
            config('ai.ollama.base_url'),
            '/'
        );

        $model = config('ai.ollama.model');

        $response = Http::timeout(120)
            ->post($baseUrl . '/api/generate', [
                'model' => $model,
                'prompt' => $prompt,
                'stream' => false,
            ]);

        if ($response->failed()) {
            throw new RuntimeException(
                'Ollama request failed: ' .
                $response->body()
            );
        }

        $data = $response->json();

        if (!isset($data['response'])) {
            throw new RuntimeException(
                'Ollama returned an invalid response.'
            );
        }

        return trim($data['response']);
    }
}
