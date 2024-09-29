<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterventionPlansTable extends Migration
{
    public function up()
    {
        Schema::create('intervention_plans', function (Blueprint $table) {
            $table->unsignedMediumInteger('id', false)->autoIncrement();
            $table->unsignedMediumInteger('client_id');
            $table->string('period', 15)->nullable(); 
            $table->date('date_prepared')->nullable();
            $table->string('prepared_by', 50)->nullable(); 
            $table->string('conformed_by', 50)->nullable(); 
            $table->string('noted_by', 50)->nullable();
            $table->json('items')->nullable(); // Store items as JSON
            $table->timestamps();
        
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });        
    }

    public function down()
    {
        Schema::dropIfExists('intervention_plans');
    }
}
