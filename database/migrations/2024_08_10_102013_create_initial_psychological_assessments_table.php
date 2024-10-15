<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInitialPsychologicalAssessmentsTable extends Migration
{
    public function up()
    {
        Schema::create('initial_psychological_assessments', function (Blueprint $table) {
            $table->unsignedMediumInteger('id', false)->autoIncrement();
            $table->unsignedMediumInteger('client_id');             
            $table->unsignedMediumInteger('admission_id');            
            $table->string('nickname', 15)->nullable();
            $table->date('report_date')->nullable();
            $table->string('prepared_by', 50)->nullable();
            $table->text('educational_attainment')->nullable();
            $table->text('reason_for_referral')->nullable();
            $table->text('family_history')->nullable();
            $table->text('sexual_development')->nullable();
            $table->text('medical_history')->nullable();
            $table->text('school_history')->nullable();
            $table->text('social_history')->nullable();
            $table->text('personal_characteristics')->nullable();
            $table->text('assessment_interview')->nullable();
            $table->text('test_result')->nullable();
            $table->text('clinical_impression')->nullable();
            $table->text('plan_of_action')->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('admission_id')->references('id')->on('admissions')->onDelete('cascade');
        });       
    }

    public function down()
    {
        Schema::dropIfExists('initial_psychological_assessments');
    }
}
