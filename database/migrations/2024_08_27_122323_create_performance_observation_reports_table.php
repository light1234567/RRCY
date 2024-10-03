<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerformanceObservationReportsTable extends Migration
{
    public function up()
    {
        Schema::create('performance_observation_reports', function (Blueprint $table) {
            $table->unsignedMediumInteger('id', false)->autoIncrement();
            $table->unsignedMediumInteger('client_id');
            $table->string('period')->nullable();
            $table->date('assessment_date')->nullable();
            $table->string('trainings_attended')->nullable();
            $table->text('general_remarks')->nullable();
            $table->string('prepared_by_one')->nullable();
            $table->string('prepared_by_two')->nullable();
            
            // Store the 'sections' and 'trainings' as JSON
            $table->json('sections')->nullable();
            $table->json('trainings')->nullable();
    
            $table->timestamps();

            // Foreign key relationship
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('performance_observation_reports');
    }
}
