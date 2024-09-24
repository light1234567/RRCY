<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSwappingFormsTable extends Migration
{
    public function up()
    {
        Schema::create('swapping_forms', function (Blueprint $table) {
            $table->unsignedMediumInteger('id', false)->autoIncrement();
            $table->unsignedMediumInteger('client_id');              
            $table->string('drn', 25)->nullable();
            $table->date('date_of_filing')->nullable();
            $table->string('requesting_party_name', 50)->nullable();
            $table->string('requesting_party_position', 50)->nullable();
            $table->string('requested_by_position', 50)->nullable();
            $table->string('accepted_by_position', 50)->nullable();
            $table->date('date_of_duty')->nullable();
            $table->time('time_of_duty')->nullable();
            $table->string('sod_name', 50)->nullable();
            $table->date('sod_date_of_duty')->nullable();
            $table->string('sod_position', 50)->nullable();
            $table->string('sod_shift_time', 20)->nullable();
            $table->text('purpose')->nullable();
            $table->string('requested_by', 50)->nullable();
            $table->string('accepted_by', 50)->nullable();
            $table->string('noted_by', 50)->default('VAN M. DE LEON');
            $table->string('approved_by', 50)->default('ANGELIC B. PAÑA');
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });        
    }

    public function down()
    {
        Schema::dropIfExists('swapping_forms');
    }
}
