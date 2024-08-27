<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerformanceSectionsTable extends Migration
{
    public function up()
    {
        Schema::create('performance_sections', function (Blueprint $table) {
            $table->id(); // This is an unsignedBigInteger by default
            $table->foreignId('report_id')->constrained('performance_observation_reports')->onDelete('cascade');
            $table->string('title');
            $table->integer('sub_total')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('performance_sections');
    }
}

