<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupWorkAssessmentsTable extends Migration
{
    public function up()
    {
        Schema::create('group_work_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learner_assessment_form_id')->constrained()->onDelete('cascade');
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
            $table->string('updated_by')->nullable(); // Add updated_by field
            $table->timestamps();
        });        
    }

    public function down()
    {
        Schema::dropIfExists('group_work_assessments');
    }
}
