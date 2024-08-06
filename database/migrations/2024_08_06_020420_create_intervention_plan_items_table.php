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
            $table->string('objectives');
            $table->string('activities');
            $table->string('time_frame');
            $table->string('responsible_person');
            $table->string('expected_outcome');
            $table->string('remarks')->nullable();
            $table->timestamps();

            $table->foreign('plan_id')->references('id')->on('intervention_plans')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('intervention_plan_items');
    }
}
