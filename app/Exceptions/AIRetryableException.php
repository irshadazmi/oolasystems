<?php

namespace App\Exceptions\AI;

use RuntimeException;

class AIRetryableException extends RuntimeException
{
    /**
     * Number of seconds to wait before retrying.
     */
    public function __construct(
        string $message,
        public readonly int $retryAfter = 30,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, 0, $previous);
    }
}