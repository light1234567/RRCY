<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingsAttendedTable extends Migration
{
    public function up()
    {
        Schema::create('trainings_attended', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('performance_observation_reports')->onDelete('cascade');
            $table->string('title');
            $table->date('date_of_attendance')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('trainings_attended');
    }
}
