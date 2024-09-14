<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsSubmittedTable extends Migration
{
    public function up()
    {
        Schema::create('documents_submitted', function (Blueprint $table) {
            $table->id(); // Creates an auto-incrementing ID column
            $table->unsignedBigInteger('admission_id'); // Foreign key for admissions table
            $table->json('document_name')->nullable(); // Stores JSON data and allows null values
            $table->boolean('submitted')->default(false); // Marks whether the document has been submitted
            $table->timestamps(); // Automatically creates created_at and updated_at columns

            // Adding the foreign key constraint
            $table->foreign('admission_id')
                ->references('id')
                ->on('admissions')
                ->onDelete('cascade'); // Cascade delete on admission deletion
        });
    }

    public function down()
    {
        Schema::dropIfExists('documents_submitted'); // Drops the table if it exists
    }
}
