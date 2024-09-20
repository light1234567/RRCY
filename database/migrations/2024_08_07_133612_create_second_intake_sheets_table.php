<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecondIntakeSheetsTable extends Migration
{
    public function up()
    {
        Schema::create('second_intake_sheets', function (Blueprint $table) {
            $table->unsignedMediumInteger('id', false)->autoIncrement();
            $table->unsignedMediumInteger('client_id');
            $table->unsignedMediumInteger('general_intake_id')->nullable();
            $table->date('date')->nullable();
            $table->json('vices')->nullable();
            $table->text('school_activities_achievement')->nullable(); 
            $table->string('occupation_of_mother', 50)->nullable(); 
            $table->string('occupation_of_father', 50)->nullable(); 
            $table->json('siblings')->nullable();
            $table->string('responsible_for_households_chores', 50)->nullable(); 
            $table->string('detention_days', 20)->nullable(); 
            $table->json('community')->nullable();
            $table->string('house_made_of', 100)->nullable(); 
            $table->timestamps();
        
            // Foreign key constraints
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('general_intake_id')->references('id')->on('general_intake_sheets')->onDelete('cascade');
        });        
    }

    public function down()
    {
        Schema::dropIfExists('second_intake_sheets');
    }
}
