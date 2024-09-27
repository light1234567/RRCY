<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTalambuhaysTable extends Migration
{
    public function up()
    {
        Schema::create('talambuhays', function (Blueprint $table) {
            $table->unsignedMediumInteger('id', false)->autoIncrement();
            $table->unsignedMediumInteger('client_id');
            $table->text('about_my_family')->nullable();
            $table->text('about_my_self')->nullable();
            $table->text('about_my_case')->nullable();
            $table->string('talambuhay_case_manager', 50)->nullable();
            $table->date('date')->nullable();
            $table->timestamps();
        
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });        
    }

    public function down()
    {
        Schema::dropIfExists('talambuhays');
    }
}
?>
