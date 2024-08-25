<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCiclSessionsTable extends Migration
{
    public function up()
    {
        Schema::create('cicl_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->string('drn')->nullable();
            $table->string('session')->nullable();
            $table->string('title')->nullable();
            $table->date('date_conducted')->nullable();
            $table->text('objective')->nullable();
            $table->text('methodology')->nullable();
            $table->text('highlight')->nullable();
            $table->text('outcome')->nullable();
            $table->text('prepared_by')->nullable();
            $table->string('noted_by')->nullable();
            $table->string('approved_by')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cicl_sessions');
    }
}
