<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReadingAssessmentsTable extends Migration
{
    public function up()
    {
        Schema::create('reading_assessments', function (Blueprint $table) {
            $table->unsignedMediumInteger('id', false)->autoIncrement();
            $table->unsignedMediumInteger('learner_assessment_form_id');            
            $table->string('pronunciation_remarks', 100)->nullable();
            $table->string('fluency_remarks', 100)->nullable();
            $table->string('punctuation_remarks', 100)->nullable();
            $table->string('advance_remarks', 100)->nullable();
            $table->timestamps();

            $table->foreign('learner_assessment_form_id')->references('id')->on('learner_assessment_forms')->onDelete('cascade');
        });        
    }

    public function down()
    {
        Schema::dropIfExists('reading_assessments');
    }
}
