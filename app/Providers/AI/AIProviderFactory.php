<?php

namespace App\Providers\AI;

use InvalidArgumentException;

class AIProviderFactory
{
    /**
     * Create the configured AI provider.
     */
    public static function make(): AIProviderInterface
    {
        return match (config('ai.provider')) {

            'ollama' => new OllamaProvider(),

            'gemini' => new GeminiProvider(),

            default => throw new InvalidArgumentException(
                'Unsupported AI provider: ' .
                config('ai.provider')
            ),
        };
    }
}
