<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsSubmittedTable extends Migration
{
    public function up()
    {
        Schema::create('documents_submitted', function (Blueprint $table) {
            $table->id(); // Automatically creates an 'id' column
            $table->unsignedBigInteger('admission_id');
            $table->string('document_name');
            $table->boolean('submitted')->default(false);
            $table->timestamps();

            $table->foreign('admission_id')->references('id')->on('admissions')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('documents_submitted');
    }
}
