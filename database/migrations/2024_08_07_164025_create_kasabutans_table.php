<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKasabutansTable extends Migration
{
    public function up()
    {
        Schema::create('kasabutans', function (Blueprint $table) {
            $table->unsignedMediumInteger('id', false)->autoIncrement();
            $table->unsignedMediumInteger('client_id');
            $table->string('client_resident', 50)->nullable(); 
            $table->string('parent_guardian', 50)->nullable(); 
            $table->string('first_kasabutan_case_manager', 50)->nullable(); 
            $table->string('second_kasabutan_case_manager', 50)->nullable(); 
            $table->timestamps();
    
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kasabutans');
    }
}
