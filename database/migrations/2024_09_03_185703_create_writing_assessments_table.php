<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWritingAssessmentsTable extends Migration
{
    public function up()
    {
        Schema::create('writing_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learner_assessment_form_id')->constrained()->onDelete('cascade');
            $table->json('punctuation')->nullable(); // Stores [Excellent, Good, Fair, Needs Improvement] as JSON
            $table->string('punctuation_remarks')->nullable();
            $table->json('capitalization')->nullable();
            $table->string('capitalization_remarks')->nullable();
            $table->json('grammar')->nullable();
            $table->string('grammar_remarks')->nullable();
            $table->json('content_ideas')->nullable();
            $table->string('content_ideas_remarks')->nullable();
            $table->json('spelling')->nullable();
            $table->string('spelling_remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('writing_assessments');
    }
}

