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
            $table->string('client_resident')->nullable(); // Nullable client_resident
            $table->string('parent_guardian')->nullable(); // Nullable parent_guardian
            $table->string('case_manager')->nullable(); // Nullable case_manager
            $table->timestamps();
            
            // Define foreign key constraint if applicable
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kasabutans');
    }
}
