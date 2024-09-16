<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingNeedsAssessmentsTable extends Migration
{
    public function up()
    {
        Schema::create('training_needs_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->string('birthplace', 100)->nullable();
            $table->string('social_worker', 100)->nullable();
            $table->string('houseparent', 100)->nullable();
            $table->string('father', 100)->nullable();
            $table->string('mother', 100)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('center_duration', 50)->nullable();
            $table->string('for_the', 50)->nullable();
            $table->date('date_of_admission')->nullable();
            $table->timestamps();
        });        
    }

    public function down()
    {
        Schema::dropIfExists('training_needs_assessments');
    }
}


