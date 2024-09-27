<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecklistsTable extends Migration
{
    public function up()
    
    {
        Schema::create('checklists', function (Blueprint $table) {
            $table->unsignedMediumInteger('id', false)->autoIncrement();
            $table->unsignedMediumInteger('client_id');
            $table->string('admitting_officer', 50)->nullable(); 
            $table->string('checklist_case_manager', 50)->nullable(); 
            $table->json('documents')->nullable(); 
            $table->json('rrcy_forms')->nullable(); 
            $table->timestamps();

            // Foreign key constraint on client_id
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('checklists');
    }
}
