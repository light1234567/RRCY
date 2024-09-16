<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerformanceSectionsTable extends Migration
{
    public function up()
    {
        Schema::create('performance_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('performance_observation_reports')->onDelete('cascade');
            $table->string('title', 150);
            $table->integer('sub_total')->nullable();
            $table->string('remarks', 255)->nullable();
            $table->string('updated_by')->nullable(); // Add updated_by field
            $table->timestamps();
        });        
    }

    public function down()
    {
        Schema::dropIfExists('performance_sections');
    }
}

