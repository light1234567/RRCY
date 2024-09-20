<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingSectorDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('training_sector_details', function (Blueprint $table) {
            $table->unsignedMediumInteger('id', false)->autoIncrement();
            $table->unsignedMediumInteger('training_needs_assessment_id');              
            $table->string('sector', 50);
            $table->string('name', 50);
            $table->integer('rank')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('training_needs_assessment_id')->references('id')->on('training_needs_assessments')->onDelete('cascade');
        });        
    }

    public function down()
    {
        Schema::dropIfExists('training_sector_details');
    }
}

