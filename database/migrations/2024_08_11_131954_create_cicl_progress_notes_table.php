<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCiclProgressNotesTable extends Migration
{
    public function up()
    {
        Schema::create('cicl_progress_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('admission_id')->constrained('admissions')->onDelete('cascade');
            $table->string('intervention_period', 100)->nullable();
            $table->text('problem_behavior_log')->nullable();
            $table->text('interventions_conducted')->nullable();
            $table->text('progress_notes')->nullable();
            $table->string('prepared_by', 100)->nullable();
            $table->string('noted_by', 100)->nullable();
            $table->string('updated_by')->nullable(); // Add updated_by field
            $table->timestamps();
        });        
    }

    public function down()
    {
        Schema::dropIfExists('cicl_progress_notes');
    }
}

