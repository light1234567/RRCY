<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWritingAssessmentsTable extends Migration
{
    public function up()
    {
        Schema::create('writing_assessments', function (Blueprint $table) {
            $table->unsignedMediumInteger('id', false)->autoIncrement();
            $table->unsignedMediumInteger('learner_assessment_form_id');             
            $table->json('punctuation')->nullable();
            $table->string('punctuation_remarks', 100)->nullable();
            $table->json('capitalization')->nullable();
            $table->string('capitalization_remarks', 100)->nullable();
            $table->json('grammar')->nullable();
            $table->string('grammar_remarks', 100)->nullable();
            $table->json('content_ideas')->nullable();
            $table->string('content_ideas_remarks', 100)->nullable();
            $table->json('spelling')->nullable();
            $table->string('spelling_remarks', 100)->nullable();
            $table->timestamps();

            $table->foreign('learner_assessment_form_id')->references('id')->on('learner_assessment_forms')->onDelete('cascade');
        });        
    }

    public function down()
    {
        Schema::dropIfExists('writing_assessments');
    }
}

