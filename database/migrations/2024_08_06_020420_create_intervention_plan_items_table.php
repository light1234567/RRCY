<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterventionPlanItemsTable extends Migration
{
    public function up()
    {
        Schema::create('intervention_plan_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plan_id');
            $table->string('objectives', 255); 
            $table->string('activities', 255); 
            $table->string('time_frame', 100); 
            $table->string('responsible_person', 100); 
            $table->string('expected_outcome', 255); 
            $table->string('remarks', 255)->nullable(); 
            $table->string('updated_by')->nullable(); // Add updated_by field
            $table->timestamps();
        
            $table->foreign('plan_id')->references('id')->on('intervention_plans')->onDelete('cascade');
        });        
    }

    public function down()
    {
        Schema::dropIfExists('intervention_plan_items');
    }
}
