<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInitialPsychologicalAssessmentsTable extends Migration
{
    public function up()
    {
        Schema::create('initial_psychological_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('admission_id')->constrained('admissions')->onDelete('cascade');
            $table->string('nickname')->nullable();
            $table->text('reason_for_referral')->nullable();
            $table->text('family_history')->nullable();
            $table->text('sexual_development')->nullable();
            $table->text('medical_history')->nullable();
            $table->text('school_history')->nullable();
            $table->text('social_history')->nullable();
            $table->text('personal_characteristics')->nullable();
            $table->text('review_systems')->nullable();
            $table->text('mental_status')->nullable();
            $table->text('assessment_interview')->nullable();
            $table->text('test_result')->nullable();
            $table->text('clinical_impression')->nullable();
            $table->text('plan_of_action')->nullable();
            $table->string('prepared_by')->nullable();
            $table->string('noted_by')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('initial_psychological_assessments');
    }
}
