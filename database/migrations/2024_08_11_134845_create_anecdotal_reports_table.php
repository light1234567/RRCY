<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnecdotalReportsTable extends Migration
{
    public function up()
    {
        Schema::create('anecdotal_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->date('date');
            $table->string('drn', 100)->nullable();
            $table->string('color', 50)->nullable();
            $table->text('physical')->nullable();
            $table->text('emotional')->nullable();
            $table->text('behavioral')->nullable();
            $table->text('spiritual')->nullable();
            $table->text('recommendation')->nullable();
            $table->string('noted_by', 100)->nullable();
            $table->string('approved_by', 100)->nullable();
            $table->string('prepared_by', 100)->nullable();
            $table->string('house_parents', 100)->nullable();
            $table->string('house_parents_signature')->nullable();
            $table->string('residents', 100)->nullable();
            $table->string('residents_signature')->nullable();
            $table->timestamps();
        });        
    }

    public function down()
    {
        Schema::dropIfExists('anecdotal_reports');
    }
}
