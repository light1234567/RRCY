<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecklistsTable extends Migration
{
    public function up()
    
    {
        Schema::create('checklists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->string('admitting_officer', 100)->nullable(); 
            $table->string('case_manager', 100)->nullable(); 
            $table->json('documents')->nullable(); 
            $table->json('rrcy_forms')->nullable(); 
            $table->string('updated_by')->nullable(); // Add updated_by field
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
