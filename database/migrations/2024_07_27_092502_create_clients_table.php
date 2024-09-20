<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->unsignedMediumInteger('id', false)->autoIncrement();
            $table->string('first_name', 20); 
            $table->string('middle_name', 15)->nullable(); 
            $table->string('last_name', 15); 
            $table->string('suffix', 3)->nullable(); 
            $table->string('sex', 6); 
            $table->date('date_of_birth');
            $table->string('place_of_birth', 50); 
            $table->string('province', 20); 
            $table->string('city', 30); 
            $table->string('barangay', 30); 
            $table->string('street', 60)->nullable(); 
            $table->string('religion', 20)->nullable(); 
            $table->string('child_status', 35)->nullable(); 
            $table->string('center_head', 50)->nullable();
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