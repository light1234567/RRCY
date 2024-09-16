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
            $table->string('month', 50)->nullable();
            $table->string('school_year', 50)->nullable();
            $table->string('learner_name', 100)->nullable();
            $table->string('grade', 20)->nullable();
            $table->string('lrn', 20)->nullable();
            $table->string('status', 50)->nullable();
            $table->json('skills')->nullable();
            $table->text('observation_feedback')->nullable();
            $table->string('learner_signature', 100)->nullable();
            $table->string('category_adviser_signature', 100)->nullable();
            $table->string('educational_section_head_signature', 100)->nullable();
            $table->string('center_head_signature', 100)->nullable();
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
