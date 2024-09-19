<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoldersTable extends Migration
{
    public function up()
    {
        Schema::create('folders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade'); // Foreign key to clients table
            $table->string('name');
            $table->string('updated_by')->nullable(); // Add updated_by field
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('folders');
    }
}