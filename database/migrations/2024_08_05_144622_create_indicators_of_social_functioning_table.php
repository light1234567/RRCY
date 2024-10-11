<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndicatorsOfSocialFunctioningTable extends Migration
{
    public function up()
    { 
        Schema::dropIfExists('indicators_of_social_functionings');

        Schema::create('indicators_of_social_functionings', function (Blueprint $table) {
            $table->unsignedMediumInteger('id', false)->autoIncrement();
            $table->unsignedMediumInteger('client_id');
            $table->unsignedMediumInteger('admission_id');
            $table->date('date_administered')->nullable();
            $table->integer('physical_raw_score1')->nullable();
            $table->decimal('physical_score_per_area1')->nullable();
            $table->integer('physical_raw_score2')->nullable();
            $table->integer('emotional_raw_score1')->nullable();
            $table->decimal('emotional_score_per_area1')->nullable();
            $table->integer('emotional_raw_score2')->nullable();
            $table->integer('emotional_raw_score3')->nullable();
            $table->integer('emotional_raw_score4')->nullable();
            $table->integer('emotional_raw_score5')->nullable();
            $table->integer('emotional_raw_score6')->nullable();
            $table->integer('social_raw_score1')->nullable();
            $table->decimal('social_score_per_area1')->nullable();
            $table->integer('social_raw_score2')->nullable();
            $table->integer('social_raw_score3')->nullable();
            $table->integer('social_raw_score4')->nullable();
            $table->integer('social_raw_score5')->nullable();
            $table->integer('social_raw_score6')->nullable();
            $table->integer('social_raw_score7')->nullable();
            $table->integer('social_raw_score8')->nullable();
            $table->integer('spiritual_raw_score1')->nullable();
            $table->decimal('spiritual_score_per_area1')->nullable();
            $table->integer('educational_raw_score')->nullable();
            $table->decimal('educational_score_per_area')->nullable();
            $table->integer('economic_raw_score')->nullable();
            $table->decimal('economic_score_per_area')->nullable();
            $table->decimal('general_score')->nullable();
            $table->text('interpretation')->nullable();
            $table->json('indicators_level')->nullable();
            $table->string('prepared_by', 50)->nullable();
            $table->string('indicators_case_manager', 50)->nullable();
            $table->string('discussed_with', 50)->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('admission_id')->references('id')->on('admissions')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('indicators_of_social_functioning');
    }
}
