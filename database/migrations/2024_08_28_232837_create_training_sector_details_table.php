<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingSectorDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('training_sector_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_needs_assessment_id')->constrained('training_needs_assessments')->onDelete('cascade');
            $table->string('sector');
            $table->string('name');
            $table->integer('rank')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('training_sector_details');
    }
}

