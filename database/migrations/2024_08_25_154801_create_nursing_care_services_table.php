<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNursingCareServicesTable extends Migration
{
    public function up()
    {
        Schema::create('nursing_care_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->date('date_of_admission');
            $table->string('current_medical_status')->nullable();
            $table->float('temperature')->nullable();
            $table->integer('pulse_rate')->nullable();
            $table->integer('respiratory_rate')->nullable();
            $table->string('blood_pressure')->nullable();
            $table->float('height_cm')->nullable();
            $table->float('weight_kg')->nullable();
            $table->float('bmi')->nullable();
            $table->string('bmi_remarks')->nullable();
            $table->string('eyes_status')->nullable();
            $table->string('nails_status')->nullable();
            $table->string('ears_status')->nullable();
            $table->string('skin_status')->nullable();
            $table->string('mouth_teeth_status')->nullable();
            $table->string('hair_status')->nullable();
            $table->text('services_given')->nullable();
            $table->text('remarks')->nullable();
            $table->string('prepared_by')->nullable();
            $table->string('noted_by')->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('nursing_care_services');
    }
}
