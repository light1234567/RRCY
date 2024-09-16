<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('education_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_needs_assessment_id')->constrained('training_needs_assessments')->onDelete('cascade');
            $table->string('education_level', 100);
            $table->string('year_or_grade', 50)->nullable();
            $table->timestamps();
        });        
    }

    public function down()
    {
        Schema::dropIfExists('education_details');
    }
}
