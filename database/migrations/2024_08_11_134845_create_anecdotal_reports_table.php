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
            $table->string('drn')->nullable();
            $table->string('color')->nullable();
            $table->text('physical')->nullable();
            $table->text('emotional')->nullable();
            $table->text('behavioral')->nullable();
            $table->text('spiritual')->nullable();
            $table->text('recommendation')->nullable();
            $table->string('noted_by')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('prepared_by')->nullable();
            $table->string('house_parents')->nullable();
            $table->string('house_parents_signature')->nullable(); // Signature file path for House Parents
            $table->string('residents')->nullable();
            $table->string('residents_signature')->nullable(); // Signature file path for Residents
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('anecdotal_reports');
    }
}
