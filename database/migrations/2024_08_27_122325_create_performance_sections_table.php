<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerformanceSectionsTable extends Migration
{
    public function up()
{
    Schema::create('performance_sections', function (Blueprint $table) {
        $table->unsignedMediumInteger('id', false)->autoIncrement();
        $table->unsignedMediumInteger('report_id'); 
        $table->string('title', 50);
        $table->integer('sub_total')->nullable();
        $table->string('remarks', 150)->nullable();
        $table->timestamps();

        $table->foreign('report_id')->references('id')->on('performance_observation_reports')->onDelete('cascade');
    });
}

    public function down()
    {
        Schema::dropIfExists('performance_sections');
    }
}

