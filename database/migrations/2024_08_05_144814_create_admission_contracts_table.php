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
            $table->unsignedBigInteger('client_id')->nullable();
            $table->string('signed_day')->nullable();
            $table->string('signed_month')->nullable();
            $table->string('parent_custodian_name')->nullable();
            $table->string('lgu_worker_name')->nullable();
            $table->string('rrcy_officer')->nullable();
            $table->string('houseparent_on_duty')->nullable();
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
