<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecklistsTable extends Migration
{
    public function up()
    {
        Schema::create('checklists', function (Blueprint $table) {
            // $table->id(); // Remove this line
            $table->unsignedBigInteger('client_id');
            $table->string('document');
            $table->boolean('yes')->default(false);
            $table->boolean('no')->default(false);
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->primary(['client_id', 'document']);
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('checklists');
    }
}
