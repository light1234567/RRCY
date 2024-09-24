<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrnsTable extends Migration
{
    public function up()
    {
        Schema::create('drns', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->unsignedMediumInteger('client_id');
            $table->string('drn', 50); // Change length as needed
            $table->timestamps();

            // Foreign key constraint linking to clients table
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('drns');
    }
}
