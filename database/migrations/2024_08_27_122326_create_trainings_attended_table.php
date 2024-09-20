<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingsAttendedTable extends Migration
{
    public function up()
    {
        Schema::create('trainings_attended', function (Blueprint $table) {
            $table->unsignedMediumInteger('id', false)->autoIncrement();
            $table->unsignedMediumInteger('report_id');             
            $table->string('title', 50);
            $table->date('date_of_attendance')->nullable();
            $table->string('status', 50)->nullable();
            $table->timestamps();
            $table->foreign('report_id')->references('id')->on('performance_observation_reports')->onDelete('cascade');
        });        
    }

    public function down()
    {
        Schema::dropIfExists('trainings_attended');
    }
}
