<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsSubmittedTable extends Migration
{
    public function up()
    {
        Schema::create('documents_submitted', function (Blueprint $table) {
            $table->id('documents_submitted_id');
            $table->unsignedBigInteger('client_id');
            $table->string('documents_submitted_type', 50);
            $table->timestamps();

            $table->foreign('client_id')->references('client_id')->on('clients')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('documents_submitted');
    }
}