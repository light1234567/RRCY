<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmissionsTable extends Migration
{
    public function up()
    {
        Schema::create('admissions', function (Blueprint $table) {
            $table->id(); // Automatically creates an 'id' column
            $table->unsignedBigInteger('client_id');
            $table->string('committing_court');
            $table->string('crim_case_number');
            $table->string('offense_committed');
            $table->date('date_admitted');
            $table->integer('days_in_jail');
            $table->integer('days_in_detention_center');
            $table->string('action_taken');
            $table->string('general_impression');
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('admissions');
    }
}
