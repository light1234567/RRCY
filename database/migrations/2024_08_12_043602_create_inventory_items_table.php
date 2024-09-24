<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryItemsTable extends Migration
{
    public function up()
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->unsignedMediumInteger('id', false)->autoIncrement();
            $table->unsignedMediumInteger('client_id');  
            $table->unsignedMediumInteger('monthly_inventory_id');
            $table->string('name', 20);
            $table->string('description', 50)->nullable();
            $table->integer('qty')->nullable();
            $table->string('brand', 20)->nullable();
            $table->string('size', 4)->nullable();
            $table->string('color', 10)->nullable();
            $table->string('old', 10)->nullable();
            $table->string('new', 10)->nullable();
            $table->string('remarks', 100)->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('monthly_inventory_id')->references('id')->on('monthly_inventories')->onDelete('cascade');
        });        
    }

    public function down()
    {
        Schema::dropIfExists('inventory_items');
    }
}

