<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLearnerAssessmentFormsTable extends Migration
{
    public function up()
    {
        Schema::create('learner_assessment_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->string('school_year')->nullable();
            $table->string('grading_period')->nullable();
            $table->string('grade')->nullable();
            $table->date('date')->nullable();
            $table->text('recommendations')->nullable();
            $table->string('prepared_by')->nullable();
            $table->string('noted_by')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('learner_assessment_forms');
    }
}
