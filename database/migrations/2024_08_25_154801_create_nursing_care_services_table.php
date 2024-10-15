<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNursingCareServicesTable extends Migration
{
    public function up()
    {
        Schema::create('nursing_care_services', function (Blueprint $table) {
            $table->unsignedMediumInteger('id', false)->autoIncrement();
            $table->unsignedMediumInteger('client_id')->nullable();
            $table->string('selectedMonth', 15)->nullable();
            $table->string('current_medical_status', 50)->nullable();
            $table->float('temperature')->nullable();
            $table->integer('pulse_rate')->nullable();
            $table->integer('respiratory_rate')->nullable();
            $table->string('blood_pressure', 20)->nullable();
            $table->float('height_cm')->nullable();
            $table->float('weight_kg')->nullable();
            $table->float('bmi')->nullable();
            $table->string('bmi_remarks', 100)->nullable();
            $table->string('eyes_status', 50)->nullable();
            $table->string('nails_status', 50)->nullable();
            $table->string('ears_status', 50)->nullable();
            $table->string('skin_status', 50)->nullable();
            $table->string('mouth_teeth_status', 50)->nullable();
            $table->string('hair_status', 50)->nullable();
            $table->text('services_given')->nullable();
            $table->text('remarks')->nullable();
            $table->string('prepared_by', 50)->nullable();
            $table->string('profile_image', 150)->nullable();
            $table->timestamps();
        
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });        
    }

    public function down()
    {
        Schema::dropIfExists('nursing_care_services');
    }
}
