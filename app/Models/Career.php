<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $fillable = [
        'title',
        'department',
        'location',
        'employment_type',
        'experience',
        'description',
        'requirements',
        'responsibilities',
        'status',
    ];
}
