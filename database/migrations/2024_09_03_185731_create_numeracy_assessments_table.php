<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNumeracyAssessmentsTable extends Migration
{
    public function up()
    {
        Schema::create('numeracy_assessments', function (Blueprint $table) {
            $table->unsignedMediumInteger('id', false)->autoIncrement();
            $table->unsignedMediumInteger('learner_assessment_form_id');             
            $table->string('advance_remarks', 100)->nullable();
            $table->timestamps();

            $table->foreign('learner_assessment_form_id')->references('id')->on('learner_assessment_forms')->onDelete('cascade');
        });        
    }

    public function down()
    {
        Schema::dropIfExists('numeracy_assessments');
    }
}

