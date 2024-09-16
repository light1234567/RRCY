<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNumeracyAssessmentsTable extends Migration
{
    public function up()
    {
        Schema::create('numeracy_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learner_assessment_form_id')->constrained()->onDelete('cascade');
            $table->string('advance_remarks', 100)->nullable();
            $table->timestamps();
        });        
    }

    public function down()
    {
        Schema::dropIfExists('numeracy_assessments');
    }
}

