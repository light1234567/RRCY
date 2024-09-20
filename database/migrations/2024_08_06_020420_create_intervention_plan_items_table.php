<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterventionPlanItemsTable extends Migration
{
    public function up()
    {
        Schema::create('intervention_plan_items', function (Blueprint $table) {
            $table->unsignedMediumInteger('id', false)->autoIncrement();
            $table->unsignedMediumInteger('plan_id');
            $table->string('objectives', 50); 
            $table->string('activities', 50); 
            $table->string('time_frame', 20); 
            $table->string('responsible_person', 50); 
            $table->string('expected_outcome', 100); 
            $table->string('remarks', 150)->nullable(); 
            $table->timestamps();
        
            $table->foreign('plan_id')->references('id')->on('intervention_plans')->onDelete('cascade');
        });        
    }

    public function down()
    {
        Schema::dropIfExists('intervention_plan_items');
    }
}
