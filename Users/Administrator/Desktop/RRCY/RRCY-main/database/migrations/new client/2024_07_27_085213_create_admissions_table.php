<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmissionsTable extends Migration
{
    public function up()
    {
        Schema::create('admissions', function (Blueprint $table) {
            $table->id('admission_id');
            $table->unsignedBigInteger('client_id');
            $table->string('committing_court', 100);
            $table->string('crim_case_number', 50);
            $table->string('offense_committed', 100);
            $table->date('date_admitted');
            $table->smallInteger('days_in_jail');
            $table->smallInteger('days_in_detention_center');
            $table->text('general_impression');
            $table->text('action_taken');
            $table->timestamps();

            $table->foreign('client_id')->references('client_id')->on('clients')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('admissions');
    }
}