<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCiclSessionsTable extends Migration
{
    public function up()
    {
        Schema::create('cicl_sessions', function (Blueprint $table) {
            $table->unsignedMediumInteger('id', false)->autoIncrement();
            $table->unsignedMediumInteger('client_id');              
            $table->string('drn', 20)->nullable();
            $table->string('session', 20)->nullable();
            $table->string('title', 50)->nullable();
            $table->date('date_conducted')->nullable();
            $table->text('objective')->nullable();
            $table->text('methodology')->nullable();
            $table->text('highlight')->nullable();
            $table->text('outcome')->nullable();
            $table->string('prepared_by', 50)->nullable();
            $table->string('session_shp', 50)->nullable();
            $table->string('approved_by', 50)->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');

        });        
    }

    public function down()
    {
        Schema::dropIfExists('cicl_sessions');
    }
}
