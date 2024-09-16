<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSwappingFormsTable extends Migration
{
    public function up()
    {
        Schema::create('swapping_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->string('drn', 100)->nullable();
            $table->date('date_of_filing')->nullable();
            $table->string('requesting_party_name', 100)->nullable();
            $table->string('requesting_party_position', 100)->nullable();
            $table->date('date_of_duty')->nullable();
            $table->time('time_of_duty')->nullable();
            $table->string('sod_name', 100)->nullable();
            $table->date('sod_date_of_duty')->nullable();
            $table->string('sod_position', 100)->nullable();
            $table->string('sod_shift_time', 50)->nullable();
            $table->text('purpose')->nullable();
            $table->string('requested_by', 100)->nullable();
            $table->string('accepted_by', 100)->nullable();
            $table->string('noted_by', 100)->default('VAN M. DE LEON');
            $table->string('approved_by', 100)->default('ANGELIC B. PAÑA');
            $table->timestamps();
        });        
    }

    public function down()
    {
        Schema::dropIfExists('swapping_forms');
    }
}
