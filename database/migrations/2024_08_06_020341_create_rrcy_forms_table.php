<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRrcyFormsTable extends Migration
{
    public function up()
    {
        Schema::create('rrcy_forms', function (Blueprint $table) {
            // $table->id(); // Remove this line
            $table->unsignedBigInteger('client_id');
            $table->string('form', 255);
            $table->boolean('yes')->default(false);
            $table->boolean('no')->default(false);
            $table->text('remarks', 255)->nullable();
            $table->timestamps();

            $table->primary(['client_id', 'form']);
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('rrcy_forms');
    }
}
