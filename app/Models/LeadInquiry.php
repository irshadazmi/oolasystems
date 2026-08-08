<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadInquiry extends Model
{
    protected $table = 'lead_inquiries';

    protected $fillable = [
        'name',
        'email',
        'project_type',
        'message',
        'status' => 'New',
        'response',
        'lead_score',
        'lead_temperature',
        'service_interest',
        'timeline',
        'budget_range',
        'ai_summary',
        'ai_recommendation',
        'ai_processed_at',
    ];

    protected function casts(): array
    {
        return [
            'ai_processed_at' => 'datetime',
        ];
    }
}
