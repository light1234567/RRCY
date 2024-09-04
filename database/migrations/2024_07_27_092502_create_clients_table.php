<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id(); // Automatically creates an 'id' column
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('suffix')->nullable();
            $table->string('sex');
            $table->date('date_of_birth');
            $table->string('place_of_birth');
            $table->string('province');
            $table->string('city');
            $table->string('barangay');
            $table->string('street')->nullable();
            $table->string('religion')->nullable();
            $table->string('child_status')->nullable();
            $table->timestamps();
        });
    }

    public function down()
{
    Schema::disableForeignKeyConstraints();

    Schema::dropIfExists('clients');

    Schema::enableForeignKeyConstraints();
}

}