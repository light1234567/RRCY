<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsSubmittedTable extends Migration
{
    public function up()
    {
        Schema::create('documents_submitted', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('admission_id'); 
            $table->json('document_name')->nullable(); 
            $table->boolean('submitted')->default(false); 
            $table->timestamps(); 

            // Adding the foreign key constraint
            $table->foreign('admission_id')
                ->references('id')
                ->on('admissions')
                ->onDelete('cascade'); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('documents_submitted'); // Drops the table if it exists
    }
}
