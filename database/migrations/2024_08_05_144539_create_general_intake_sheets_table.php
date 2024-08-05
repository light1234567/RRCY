<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralIntakeSheetsTable extends Migration
{
    public function up()
    {
        Schema::create('general_intake_sheets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->date('date');
            $table->string('occupation');
            $table->string('highest_educ_att');
            $table->string('school_name');
            $table->string('class_adviser');
            $table->text('problem_presented');
            $table->text('brief_physical_description');
            $table->string('major_life_event');
            $table->string('enduring_life_strain');
            $table->string('life_transition');
            $table->string('development_changes');
            $table->string('normalization');
            $table->string('behaviour_towards_incident');
            $table->string('attachments');
            $table->string('skills');
            $table->string('resources');
            $table->string('earnings_income');
            $table->string('source_of_income_in_street');
            $table->string('hrs_stay_in_street');
            $table->string('length_stay_in_street');
            $table->string('common_substance_used');
            $table->string('initial_assessment');
            $table->string('recommendations');
            $table->string('vices');
            $table->string('school_activities_achievement');
            $table->text('occupation_of_mother');
            $table->text('occupation_of_father');
            $table->string('siblings');
            $table->text('responsible_for_households_chores');
            $table->string('water_source');
            $table->string('house_made_of');
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('general_intake_sheets');
    }
}
