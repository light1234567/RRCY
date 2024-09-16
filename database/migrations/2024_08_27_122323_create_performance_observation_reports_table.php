<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerformanceObservationReportsTable extends Migration
{
    public function up()
    {
        Schema::create('performance_observation_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->date('assessment_date');
            $table->string('trainings_attended', 100)->nullable();
            $table->text('general_remarks')->nullable();
            $table->string('prepared_by', 100)->nullable();
            $table->string('noted_by', 100)->nullable();
            $table->timestamps();
        });        
    }

    public function down()
    {
        Schema::dropIfExists('performance_observation_reports');
    }
}
