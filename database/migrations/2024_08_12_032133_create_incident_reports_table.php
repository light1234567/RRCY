<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidentReportsTable extends Migration
{
    public function up()
    {
        Schema::create('incident_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->string('drn', 100)->nullable();
            $table->text('incident')->nullable();
            $table->date('date_of_incident')->nullable();
            $table->time('time_of_incident')->nullable();
            $table->text('involved')->nullable();
            $table->text('location')->nullable();
            $table->text('action_taken')->nullable();
            $table->text('agreements')->nullable();
            $table->text('corrective_measure')->nullable();
            $table->string('prepared_by', 100)->nullable();
            $table->string('reviewed_by', 100)->nullable();
            $table->string('approved_by', 100)->nullable();
            $table->timestamps();
        });        
    }

    public function down()
    {
        Schema::dropIfExists('incident_reports');
    }
}
