<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecondIntakeSheetsTable extends Migration
{
    public function up()
    {
        Schema::create('second_intake_sheets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->date('date')->nullable();
            $table->string('occupation')->nullable();
            $table->string('highest_educ_att')->nullable();
            $table->string('school_name')->nullable();
            $table->string('class_adviser')->nullable();
            $table->json('vices')->nullable();
            $table->text('school_activities_achievement')->nullable();
            $table->string('occupation_of_mother')->nullable();
            $table->string('occupation_of_father')->nullable();
            $table->json('siblings')->nullable();
            $table->string('responsible_for_households_chores')->nullable();
            $table->string('detention_days')->nullable();
            $table->json('community')->nullable();
            $table->string('house_made_of')->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('second_intake_sheets');
    }
}
