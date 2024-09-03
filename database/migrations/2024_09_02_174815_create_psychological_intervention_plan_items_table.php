<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePsychologicalInterventionPlanItemsTable extends Migration
{
    public function up()
    {
        Schema::create('psychological_intervention_plan_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plan_id');
            $table->text('objectives')->nullable();
            $table->text('activities')->nullable();
            $table->string('responsible_person')->nullable();
            $table->string('time_frame')->nullable();
            $table->text('expected_output')->nullable();
            $table->text('progress')->nullable();
            $table->timestamps();

            $table->foreign('plan_id')->references('id')->on('psychological_intervention_plans')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('psychological_intervention_plan_items');
    }
}