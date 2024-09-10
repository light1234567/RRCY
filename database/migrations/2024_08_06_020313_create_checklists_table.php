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
            $table->string('admitting_officer')->nullable();
            $table->string('case_manager')->nullable();
            $table->json('documents')->nullable(); // Store the checklist of documents in JSON format
            $table->json('rrcy_forms')->nullable(); // Store RRCY forms in JSON format
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
