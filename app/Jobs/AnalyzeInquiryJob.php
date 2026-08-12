<?php

namespace App\Jobs;

use App\Exceptions\AI\AINonRetryableException;
use App\Exceptions\AI\AIRetryableException;
use App\Models\Inquiry;
use App\Services\AILeadService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Throwable;

class AnalyzeInquiryJob implements ShouldQueue
{
    use Queueable;

    /**
     * Maximum number of attempts.
     */
    public int $tries = 3;

    /**
     * Default backoff.
     *
     * Specific AI retry delays are handled by
     * AIRetryableException.
     */
    public int $backoff = 30;

    /**
     * Inquiry ID.
     */
    public function __construct(
        public int $inquiryId
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(
        AILeadService $aiLeadService
    ): void {

        $inquiry = Inquiry::find($this->inquiryId);

        if (!$inquiry) {

            Log::warning(
                'AI analysis skipped: inquiry not found.',
                [
                    'inquiry_id' => $this->inquiryId,
                ]
            );

            return;
        }

        $inquiry->update([
            'ai_status' => 'Processing',
        ]);

        Log::info(
            'AI lead analysis started.',
            [
                'inquiry_id' => $inquiry->id,
                'attempt' => $this->attempts(),
            ]
        );

        try {

            $aiLeadService->analyze($inquiry);

        } catch (AINonRetryableException $exception) {

            /*
             * Configuration / permanent API errors should
             * not consume additional queue attempts.
             */
            $inquiry->update([
                'ai_status' => 'Failed',
            ]);

            Log::error(
                'AI lead analysis failed permanently.',
                [
                    'inquiry_id' => $inquiry->id,
                    'attempt' => $this->attempts(),
                    'error' => $exception->getMessage(),
                ]
            );

            /*
             * Mark the queue job as failed immediately.
             * Laravel will invoke failed().
             */
            $this->fail($exception);

            return;

        } catch (AIRetryableException $exception) {

            /*
             * Temporary Gemini/network problem.
             *
             * Release the job back to the queue instead
             * of throwing immediately.
             */
            $delay = max(
                1,
                $exception->retryAfter
            );

            Log::warning(
                'AI lead analysis temporarily unavailable. ' .
                'Job will be retried.',
                [
                    'inquiry_id' => $inquiry->id,
                    'attempt' => $this->attempts(),
                    'retry_after' => $delay,
                    'error' => $exception->getMessage(),
                ]
            );

            $inquiry->update([
                'ai_status' => 'Processing',
            ]);

            $this->release($delay);

            return;
        }

        /*
         * AI analysis succeeded.
         *
         * AILeadService has already persisted the actual
         * analysis fields and ai_processed_at.
         */
        $inquiry->update([
            'ai_status' => 'Completed',
        ]);

        Log::info(
            'AI lead analysis completed.',
            [
                'inquiry_id' => $inquiry->id,
            ]
        );
    }

    /**
     * Handle a job that has permanently failed.
     */
    public function failed(
        Throwable $exception
    ): void {

        $inquiry = Inquiry::find($this->inquiryId);

        if ($inquiry) {

            $inquiry->update([
                'ai_status' => 'Failed',
            ]);
        }

        Log::error(
            'AI lead analysis permanently failed.',
            [
                'inquiry_id' => $this->inquiryId,
                'error' => $exception->getMessage(),
            ]
        );
    }
}