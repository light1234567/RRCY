<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingNeedsAssessmentsTable extends Migration
{
    public function up()
    {
        Schema::create('training_needs_assessments', function (Blueprint $table) {
            $table->unsignedMediumInteger('id', false)->autoIncrement();
            $table->unsignedMediumInteger('client_id');              
            $table->string('birthplace', 50)->nullable();
            $table->string('social_worker', 50)->nullable();
            $table->string('houseparent', 50)->nullable();
            $table->string('father', 50)->nullable();
            $table->string('mother', 50)->nullable();
            $table->string('address', 150)->nullable();
            $table->string('center_duration', 20)->nullable();
            $table->string('for_the', 10)->nullable();
            $table->date('date_of_admission')->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });        
    }

    public function down()
    {
        Schema::dropIfExists('training_needs_assessments');
    }
}


