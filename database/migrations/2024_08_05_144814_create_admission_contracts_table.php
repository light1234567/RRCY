<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmissionContractsTable extends Migration
{
    public function up()
    {
        Schema::create('admission_contracts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admission_id');
            $table->unsignedBigInteger('client_id');
            $table->date('signed_date');
            $table->string('parent_custodian_signature');
            $table->string('lgu_worker_name');
            $table->string('rrcy_officer');
            $table->string('houseparent_on_duty');
            $table->timestamps();

            $table->foreign('admission_id')->references('id')->on('admissions')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('admission_contracts');
    }
}
