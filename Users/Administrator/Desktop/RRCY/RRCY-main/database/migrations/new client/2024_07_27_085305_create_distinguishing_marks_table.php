<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistinguishingMarksTable extends Migration
{
    public function up()
    {
        Schema::create('distinguishing_marks', function (Blueprint $table) {
            $table->id('distinguishing_marks_id');
            $table->unsignedBigInteger('client_id');
            $table->string('tattoo_scars', 100);
            $table->decimal('height', 5, 2);
            $table->decimal('weight', 5, 2);
            $table->string('colour_of_eye', 50);
            $table->string('skin', 50);
            $table->timestamps();

            $table->foreign('client_id')->references('client_id')->on('clients')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('distinguishing_marks');
    }
}
