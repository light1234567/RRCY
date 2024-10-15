<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidentReportsTable extends Migration
{
    public function up()
    {
        Schema::create('incident_reports', function (Blueprint $table) {
            $table->unsignedMediumInteger('id', false)->autoIncrement();
            $table->unsignedMediumInteger('client_id');              
            $table->string('drn', 20)->nullable();
            $table->text('incident')->nullable();
            $table->date('date_of_incident')->nullable();
            $table->time('time_of_incident')->nullable();
            $table->text('involved')->nullable();
            $table->text('location')->nullable();
            $table->text('action_taken')->nullable();
            $table->text('agreements')->nullable();
            $table->text('corrective_measure')->nullable();
            $table->string('prepared_by', 50)->nullable();
            $table->string('incident_report_shp', 50)->nullable();
            $table->string('approved_by', 50)->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');

        });        
    }

    public function down()
    {
        Schema::dropIfExists('incident_reports');
    }
}
