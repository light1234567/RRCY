<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('education_details', function (Blueprint $table) {
            $table->unsignedMediumInteger('id', false)->autoIncrement();
            $table->unsignedMediumInteger('training_needs_assessment_id');            
            $table->string('education_level', 30);
            $table->string('year_or_grade', 30)->nullable();
            $table->timestamps();

            $table->foreign('training_needs_assessment_id')->references('id')->on('training_needs_assessments')->onDelete('cascade');
        });        
    }

    public function down()
    {
        Schema::dropIfExists('education_details');
    }
}
