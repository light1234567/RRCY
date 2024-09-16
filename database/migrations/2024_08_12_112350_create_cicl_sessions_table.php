<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCiclSessionsTable extends Migration
{
    public function up()
    {
        Schema::create('cicl_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->string('drn', 100)->nullable();
            $table->string('session', 100)->nullable();
            $table->string('title', 150)->nullable();
            $table->date('date_conducted')->nullable();
            $table->text('objective')->nullable();
            $table->text('methodology')->nullable();
            $table->text('highlight')->nullable();
            $table->text('outcome')->nullable();
            $table->string('prepared_by', 100)->nullable();
            $table->string('noted_by', 100)->nullable();
            $table->string('approved_by', 100)->nullable();
            $table->string('updated_by')->nullable(); // Add updated_by field
            $table->timestamps();
        });        
    }

    public function down()
    {
        Schema::dropIfExists('cicl_sessions');
    }
}
