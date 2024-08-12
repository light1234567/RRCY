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
            $table->string('drn')->nullable();
            $table->date('date_of_filing')->nullable();
            $table->string('requesting_party_name')->nullable();
            $table->string('requesting_party_position')->nullable();
            $table->date('date_of_duty')->nullable();
            $table->time('time_of_duty')->nullable();
            $table->string('sod_name')->nullable();
            $table->date('sod_date_of_duty')->nullable();
            $table->string('sod_position')->nullable();
            $table->string('sod_shift_time')->nullable();
            $table->text('purpose')->nullable();
            $table->string('requested_by')->nullable();
            $table->string('accepted_by')->nullable();
            $table->string('noted_by')->default('VAN M. DE LEON');
            $table->string('approved_by')->default('ANGELIC B. PAÑA');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('swapping_forms');
    }
}
