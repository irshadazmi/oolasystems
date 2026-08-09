<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadInquiry extends Model
{
    protected $fillable = [
        'name',
        'email',
        'project_type',
        'message',
        'status',
        'response',

        // AI Lead Analysis
        'lead_score',
        'lead_temperature',
        'service_interest',
        'timeline',
        'budget_range',
        'ai_summary',
        'ai_recommendation',
        'ai_processed_at',

        // Lead Management
        'lead_status',
        'follow_up_date',
        'last_contacted_at',
        'follow_up_notes',
    ];

    protected $casts = [
        'follow_up_date' => 'date',
        'last_contacted_at' => 'datetime',
        'ai_processed_at' => 'datetime',
    ];
}
