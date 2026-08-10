<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Active AI Provider
    |--------------------------------------------------------------------------
    |
    | Supported providers:
    | - ollama
    | - gemini
    |
    */

    // 'provider' => env('AI_PROVIDER', 'ollama'),
    'provider' => env('AI_PROVIDER', 'gemini'),

    /*
    |--------------------------------------------------------------------------
    | Default AI Model
    |--------------------------------------------------------------------------
    */

    // 'model' => env('AI_MODEL', 'qwen2.5:7b'),
    'model' => env('GEMINI_MODEL', 'gemini-2.5-flash'),

    /*
    |--------------------------------------------------------------------------
    | Ollama Configuration
    |--------------------------------------------------------------------------
    */

    'ollama' => [

        'base_url' => env(
            'OLLAMA_BASE_URL',
            'http://127.0.0.1:11434'
        ),

        'model' => env(
            'OLLAMA_MODEL',
            'qwen2.5:7b'
        ),

    ],

    /*
    |--------------------------------------------------------------------------
    | Gemini Configuration
    |--------------------------------------------------------------------------
    */

    'gemini' => [

        'api_key' => env('GEMINI_API_KEY'),

        'base_url' => env(
            'GEMINI_BASE_URL',
            'https://generativelanguage.googleapis.com/v1beta'
        ),

        'model' => env(
            'GEMINI_MODEL',
            'gemini-2.5-flash'
        ),

    ],

];
