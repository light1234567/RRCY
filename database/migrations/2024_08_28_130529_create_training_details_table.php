<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('training_details', function (Blueprint $table) {
            $table->unsignedMediumInteger('id', false)->autoIncrement();
            $table->unsignedMediumInteger('training_needs_assessment_id');              
            $table->string('title', 50);
            $table->string('duration', 20)->nullable();
            $table->string('location_outside', 50)->nullable();
            $table->string('location_inside', 50)->nullable();
            $table->timestamps();

            $table->foreign('training_needs_assessment_id')->references('id')->on('training_needs_assessments')->onDelete('cascade');

        });        
    }

    public function down()
    {
        Schema::dropIfExists('training_details');
    }
}

