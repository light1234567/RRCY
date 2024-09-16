<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterventionPlansTable extends Migration
{
    public function up()
    {
        Schema::create('intervention_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->string('period', 100); 
            $table->date('date_prepared');
            $table->string('prepared_by', 100)->nullable(); 
            $table->string('conformed_by', 100)->nullable(); 
            $table->string('noted_by', 100)->nullable(); 
            $table->string('updated_by')->nullable(); // Add updated_by field
            $table->timestamps();
        
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });        
    }

    public function down()
    {
        Schema::dropIfExists('intervention_plans');
    }
}
