<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('training_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_needs_assessment_id')->constrained('training_needs_assessments')->onDelete('cascade');
            $table->string('title', 150);
            $table->string('duration', 50)->nullable();
            $table->string('location_outside', 100)->nullable();
            $table->string('location_inside', 100)->nullable();
            $table->string('updated_by')->nullable(); // Add updated_by field
            $table->timestamps();
        });        
    }

    public function down()
    {
        Schema::dropIfExists('training_details');
    }
}

