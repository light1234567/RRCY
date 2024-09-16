<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryItemsTable extends Migration
{
    public function up()
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('monthly_inventory_id')->constrained('monthly_inventories')->onDelete('cascade');
            $table->string('name', 100);
            $table->string('description', 100)->nullable();
            $table->integer('qty')->nullable();
            $table->string('brand', 50)->nullable();
            $table->string('size', 50)->nullable();
            $table->string('color', 50)->nullable();
            $table->string('old', 50)->nullable();
            $table->string('new', 50)->nullable();
            $table->string('remarks', 100)->nullable();
            $table->timestamps();
        });        
    }

    public function down()
    {
        Schema::dropIfExists('inventory_items');
    }
}

