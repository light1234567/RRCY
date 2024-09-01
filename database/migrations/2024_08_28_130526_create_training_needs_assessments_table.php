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
            $table->string('birthplace')->nullable();
            $table->string('social_worker')->nullable();
            $table->string('houseparent')->nullable();
            $table->string('father')->nullable();
            $table->string('mother')->nullable();
            $table->string('address')->nullable();
            $table->string('center_duration')->nullable();
            $table->string('for_the')->nullable();
            $table->date('date_of_admission')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('training_needs_assessments');
    }
}


