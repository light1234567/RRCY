<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade'); // Foreign key to clients table
            $table->foreignId('folder_id')->nullable()->constrained()->onDelete('cascade'); // Foreign key to folders table
            $table->string('filename');
            $table->string('updated_by')->nullable(); // Add updated_by field
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('files');
    }
}
