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
            $table->date('assessment_date');
            $table->string('trainings_attended', 50)->nullable();
            $table->text('general_remarks')->nullable();
            $table->string('prepared_by', 50)->nullable();
            $table->string('noted_by', 50)->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');

        });        
    }

    public function down()
    {
        Schema::dropIfExists('performance_observation_reports');
    }
}
