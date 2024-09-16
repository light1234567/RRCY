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
            $table->string('signed_day', 2)->nullable();
            $table->string('signed_month', 20)->nullable();
            $table->string('parent_custodian_name', 100)->nullable();
            $table->string('lgu_worker_name', 100)->nullable();
            $table->string('rrcy_officer', 100)->nullable();
            $table->string('houseparent_on_duty', 100)->nullable();
            $table->string('updated_by')->nullable(); // Add updated_by field
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
