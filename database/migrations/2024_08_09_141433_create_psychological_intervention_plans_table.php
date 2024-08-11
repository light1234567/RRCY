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
            $table->text('objectives')->nullable();
            $table->text('activities')->nullable();
            $table->string('responsible_person')->nullable();
            $table->string('time_frame')->nullable();
            $table->text('expected_output')->nullable();
            $table->text('progress')->nullable();
            $table->string('prepared_by')->nullable();
            $table->string('noted_by')->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('psychological_intervention_plans');
    }
}
