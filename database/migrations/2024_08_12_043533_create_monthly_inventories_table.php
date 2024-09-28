<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthlyInventoriesTable extends Migration
{
    public function up()
    {
        Schema::create('monthly_inventories', function (Blueprint $table) {
            $table->unsignedMediumInteger('id', false)->autoIncrement();
            $table->unsignedMediumInteger('client_id');             
            $table->string('month', 10)->nullable();
            $table->string('resident_name', 50)->nullable();
            $table->string('houseparent_name', 50)->nullable();
            $table->string('inventory_shp', 50)->nullable();
            $table->json('items')->nullable(); // Store items as JSON
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });        
    }

    public function down()
    {
        Schema::dropIfExists('monthly_inventories');
    }
}
