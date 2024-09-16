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
            $table->unsignedBigInteger('client_id')->nullable();
            $table->date('date_of_admission')->nullable();
            $table->string('current_medical_status', 255)->nullable();
            $table->float('temperature')->nullable();
            $table->integer('pulse_rate')->nullable();
            $table->integer('respiratory_rate')->nullable();
            $table->string('blood_pressure', 20)->nullable();
            $table->float('height_cm')->nullable();
            $table->float('weight_kg')->nullable();
            $table->float('bmi')->nullable();
            $table->string('bmi_remarks', 100)->nullable();
            $table->string('eyes_status', 100)->nullable();
            $table->string('nails_status', 100)->nullable();
            $table->string('ears_status', 100)->nullable();
            $table->string('skin_status', 100)->nullable();
            $table->string('mouth_teeth_status', 100)->nullable();
            $table->string('hair_status', 100)->nullable();
            $table->text('services_given')->nullable();
            $table->text('remarks')->nullable();
            $table->string('prepared_by', 100)->nullable();
            $table->string('noted_by', 100)->nullable();
            $table->string('profile_image')->nullable();
            $table->string('updated_by')->nullable(); // Add updated_by field
            $table->timestamps();
        
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });        
    }

    public function down()
    {
        Schema::dropIfExists('nursing_care_services');
    }
}
