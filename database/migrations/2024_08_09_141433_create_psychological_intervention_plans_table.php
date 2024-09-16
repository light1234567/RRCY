<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePsychologicalInterventionPlansTable extends Migration
{
    public function up()
    {
        Schema::create('psychological_intervention_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->date('as_of_date')->nullable();
            $table->text('progress_notes')->nullable();
            $table->string('prepared_by', 100)->nullable();
            $table->string('noted_by', 100)->nullable();
            $table->timestamps();
        
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });        
    }

    public function down()
    {
        Schema::dropIfExists('psychological_intervention_plans');
    }
}

