<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateClientsTable extends Migration
{
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id('client_id');
            $table->string('name', 100);
            $table->tinyInteger('age');
            $table->enum('sex', ['male', 'female', 'other']);
            $table->string('address', 150);
            $table->date('date_of_birth');
            $table->string('place_of_birth', 100);
            $table->string('religion', 50);
            $table->string('highest_educ_att', 50);
            $table->string('school_name', 50);
            $table->string('class_adviser', 50);
            $table->string('occupation', 50);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
