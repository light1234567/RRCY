<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralIntakeSheetsTable extends Migration
{
    public function up()
    {
        Schema::create('general_intake_sheets', function (Blueprint $table) {
            $table->unsignedMediumInteger('id', false)->autoIncrement();
            $table->unsignedMediumInteger('client_id');
            $table->date('date')->nullable();
            $table->string('occupation', 20)->nullable();
            $table->string('highest_educ_att', 20)->nullable();
            $table->string('school_name', 50)->nullable();
            $table->string('class_adviser', 50)->nullable();
            $table->text('problem_presented')->nullable();
            $table->text('brief_physical_description')->nullable();
            $table->json('major_life_event')->nullable();
            $table->json('enduring_life_strain')->nullable();
            $table->json('life_transition')->nullable();
            $table->json('development_changes')->nullable();
            $table->json('normalization')->nullable();
            $table->json('behaviour_towards_incident')->nullable();
            $table->json('attachments')->nullable();
            $table->json('skills')->nullable();
            $table->json('resources')->nullable();
            $table->string('earnings_income', 20)->nullable();
            $table->json('source_of_income_in_street')->nullable();
            $table->string('hrs_stay_in_street', 10)->nullable();
            $table->string('length_stay_in_street', 10)->nullable();
            $table->string('common_substance_used', 20)->nullable();
            $table->text('initial_assessment')->nullable();
            $table->text('recommendations')->nullable();
            $table->string('first_intake_case_manager', 50)->nullable();
            $table->timestamps();
        
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });        
    }

    public function down()
    {
        Schema::dropIfExists('general_intake_sheets');
    }
}
