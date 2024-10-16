<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnecdotalReportsTable extends Migration
{
    public function up()
    {
        Schema::create('anecdotal_reports', function (Blueprint $table) {
            $table->unsignedMediumInteger('id', false)->autoIncrement();
            $table->unsignedMediumInteger('client_id');              
            $table->date('date');
            $table->string('month', 20)->nullable();
            $table->string('drn', 20)->nullable();
            $table->string('color', 10)->nullable();
            $table->text('physical')->nullable();
            $table->text('emotional')->nullable();
            $table->text('behavioral')->nullable();
            $table->text('spiritual')->nullable();
            $table->text('recommendation')->nullable();
            $table->string('anecdotal_shp', 50)->nullable();
            $table->string('approved_by', 50)->nullable();
            $table->string('prepared_by', 50)->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');

        });        
    }

    public function down()
    {
        Schema::dropIfExists('anecdotal_reports');
    }
}
