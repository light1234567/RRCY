<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCiclProgressNotesTable extends Migration
{
    public function up()
    {
        Schema::create('cicl_progress_notes', function (Blueprint $table) {
            $table->unsignedMediumInteger('id', false)->autoIncrement();
            $table->unsignedMediumInteger('client_id');             
            $table->unsignedMediumInteger('admission_id');             
            $table->string('intervention_period', 20)->nullable();
            $table->text('problem_behavior_log')->nullable();
            $table->text('interventions_conducted')->nullable();
            $table->text('progress_notes')->nullable();
            $table->string('prepared_by', 50)->nullable();
            $table->string('noted_by', 50)->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('admission_id')->references('id')->on('admissions')->onDelete('cascade');
        });        
    }

    public function down()
    {
        Schema::dropIfExists('cicl_progress_notes');
    }
}

