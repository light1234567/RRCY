<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataPrivacyConsentsTable extends Migration
{
    public function up()
    {
        Schema::create('data_privacy_consents', function (Blueprint $table) {
            $table->unsignedMediumInteger('id', false)->autoIncrement();
            $table->unsignedMediumInteger('client_id');
            $table->string('client_signature', 50)->nullable();
            $table->date('date')->nullable();
            $table->string('guardian_signature', 50)->nullable();
            $table->timestamps();
        
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });        
    }

    public function down()
    {
        Schema::dropIfExists('data_privacy_consents');
    }
}
