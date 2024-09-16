<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 50); 
            $table->string('middle_name', 50)->nullable(); 
            $table->string('last_name', 50); 
            $table->string('suffix', 10)->nullable(); 
            $table->string('sex', 20); 
            $table->date('date_of_birth');
            $table->string('place_of_birth', 100); 
            $table->string('province', 50); 
            $table->string('city', 50); 
            $table->string('barangay', 50); 
            $table->string('street', 100)->nullable(); 
            $table->string('religion', 100)->nullable(); 
            $table->string('child_status', 50)->nullable(); 
            $table->string('updated_by')->nullable(); // Add updated_by field
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