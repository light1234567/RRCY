<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmissionContractsTable extends Migration
{
    public function up()
    {
        Schema::create('admission_contracts', function (Blueprint $table) {
            $table->unsignedMediumInteger('id', false)->autoIncrement();
            $table->unsignedMediumInteger('client_id');
            $table->integer('signed_day')->nullable();
            $table->string('signed_month', 10)->nullable();
            $table->string('parent_custodian_name', 50)->nullable();
            $table->string('lgu_worker_name', 50)->nullable();
            $table->string('rrcy_officer', 50)->nullable();
            $table->string('houseparent_on_duty', 50)->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('admission_contracts');
    }
}
?>
