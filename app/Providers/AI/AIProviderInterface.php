<?php

namespace App\Providers\AI;

interface AIProviderInterface
{
    /**
     * Generate a response from the AI provider.
     */
    public function generate(string $prompt): string;
}
