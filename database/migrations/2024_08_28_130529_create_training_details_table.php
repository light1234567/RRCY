<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('training_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_needs_assessment_id')->constrained('training_needs_assessments')->onDelete('cascade');
            $table->string('title');
            $table->string('duration')->nullable();
            $table->string('location_outside')->nullable();
            $table->string('location_inside')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('training_details');
    }
}

