<?php

namespace App\Jobs;

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
     * Seconds before retrying.
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
    public function handle(AILeadService $aiLeadService): void
    {
        $inquiry = Inquiry::find($this->inquiryId);

        if (!$inquiry) {
            Log::warning('AI analysis skipped: inquiry not found.', [
                'inquiry_id' => $this->inquiryId,
            ]);

            return;
        }

        $inquiry->update([
            'ai_status' => 'Processing',
        ]);

        Log::info('AI lead analysis started.', [
            'inquiry_id' => $inquiry->id,
            'attempt' => $this->attempts(),
        ]);

        /*
         * Let exceptions bubble up to Laravel's queue system.
         * Laravel will automatically retry the job.
         */
        $aiLeadService->analyze($inquiry);

        $inquiry->update([
            'ai_status' => 'Completed',
        ]);

        Log::info('AI lead analysis completed.', [
            'inquiry_id' => $inquiry->id,
        ]);
    }

    /**
     * Handle a job that has permanently failed
     * after all retry attempts.
     */
    public function failed(Throwable $exception): void
    {
        $inquiry = Inquiry::find($this->inquiryId);

        if ($inquiry) {
            $inquiry->update([
                'ai_status' => 'Failed',
            ]);
        }

        Log::error('AI lead analysis permanently failed.', [
            'inquiry_id' => $this->inquiryId,
            'error' => $exception->getMessage(),
        ]);
    }
}
