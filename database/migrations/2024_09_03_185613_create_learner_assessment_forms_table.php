<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLearnerAssessmentFormsTable extends Migration
{
    public function up()
    {
        Schema::create('learner_assessment_forms', function (Blueprint $table) {
            $table->unsignedMediumInteger('id', false)->autoIncrement();
            $table->unsignedMediumInteger('client_id');             
            $table->string('school_year', 10)->nullable();
            $table->string('grading_period', 10)->nullable();
            $table->string('grade', 10)->nullable();
            $table->date('date')->nullable();
            $table->text('recommendations')->nullable();
            $table->string('prepared_by', 50)->nullable();
            $table->string('noted_by', 50)->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');

        });        
    }

    public function down()
    {
        Schema::dropIfExists('learner_assessment_forms');
    }
}

