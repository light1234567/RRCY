<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShpsTable extends Migration
{
    public function up()
    {
        Schema::create('shps', function (Blueprint $table) {
            $table->unsignedMediumInteger('id', false)->autoIncrement();
            $table->unsignedMediumInteger('client_id');
            $table->string('name', 50);
            $table->timestamps();

            // Foreign key constraint linking to clients table
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('shps');
    }
}