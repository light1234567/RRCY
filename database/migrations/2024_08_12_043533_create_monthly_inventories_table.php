<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthlyInventoriesTable extends Migration
{
    public function up()
    {
        Schema::create('monthly_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->string('month', 50)->nullable();
            $table->string('drn', 50)->nullable();
            $table->string('resident_name', 100)->nullable();
            $table->string('houseparent_name', 100)->nullable();
            $table->string('updated_by')->nullable(); // Add updated_by field
            $table->timestamps();
        });        
    }

    public function down()
    {
        Schema::dropIfExists('monthly_inventories');
    }
}
