<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $table) {

            $table->id();

            $table->string('name');
            $table->string('email');
            $table->string('project_type');
            $table->text('message');

            $table->string('status')->default('New');
            $table->text('response')->nullable();

            // AI Lead Analysis
            $table->string('ai_status')->default('Pending');
            $table->unsignedTinyInteger('lead_score')->nullable();
            $table->string('lead_temperature', 20)->nullable();
            $table->string('service_interest')->nullable();
            $table->string('timeline')->nullable();
            $table->string('budget_range')->nullable();

            $table->text('ai_summary')->nullable();
            $table->text('ai_recommendation')->nullable();
            $table->timestamp('ai_processed_at')->nullable();

            // Lead Management
            $table->string('lead_status')->default('New');
            $table->date('follow_up_date')->nullable();
            $table->timestamp('last_contacted_at')->nullable();
            $table->text('follow_up_notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
