<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupWorkAssessmentsTable extends Migration
{
    public function up()
    {
        Schema::create('group_work_assessments', function (Blueprint $table) {
            $table->unsignedMediumInteger('id', false)->autoIncrement();
            $table->unsignedMediumInteger('learner_assessment_form_id');             
            $table->json('participation')->nullable();
            $table->string('participation_remarks', 100)->nullable();
            $table->json('focus')->nullable();
            $table->string('focus_remarks', 100)->nullable();
            $table->json('help')->nullable();
            $table->string('help_remarks', 100)->nullable();
            $table->json('questions')->nullable();
            $table->string('questions_remarks', 100)->nullable();
            $table->json('ideas')->nullable();
            $table->string('ideas_remarks', 100)->nullable();
            $table->json('feedback')->nullable();
            $table->string('feedback_remarks', 100)->nullable();
            $table->timestamps();

            $table->foreign('learner_assessment_form_id')->references('id')->on('learner_assessment_forms')->onDelete('cascade');
        });        
    }

    public function down()
    {
        Schema::dropIfExists('group_work_assessments');
    }
}
