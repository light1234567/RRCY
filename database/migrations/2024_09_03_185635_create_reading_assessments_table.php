<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReadingAssessmentsTable extends Migration
{
    public function up()
    {
        Schema::create('reading_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learner_assessment_form_id')->constrained()->onDelete('cascade');
            $table->string('pronunciation_remarks')->nullable();
            $table->string('fluency_remarks')->nullable();
            $table->string('punctuation_remarks')->nullable();
            $table->string('advance_remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reading_assessments');
    }
}
