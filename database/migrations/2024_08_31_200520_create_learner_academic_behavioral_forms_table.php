<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('learner_academic_behavioral_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->string('month')->nullable();
            $table->string('school_year')->nullable();
            $table->string('learner_name')->nullable();
            $table->string('grade')->nullable();
            $table->string('lrn')->nullable();
            $table->string('status')->nullable();
            $table->json('skills')->nullable(); // Store skills data as JSON
            $table->text('observation_feedback')->nullable();
            $table->string('learner_signature')->nullable();
            $table->string('category_adviser_signature')->nullable();
            $table->string('educational_section_head_signature')->nullable();
            $table->string('center_head_signature')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learner_academic_behavioral_forms');
    }
};
