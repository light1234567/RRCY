<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKasabutansTable extends Migration
{
    public function up()
    {
        Schema::create('kasabutans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->string('client_resident', 100)->nullable(); 
            $table->string('parent_guardian', 100)->nullable(); 
            $table->string('case_manager', 100)->nullable(); 
            $table->timestamps();
    
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kasabutans');
    }
}
