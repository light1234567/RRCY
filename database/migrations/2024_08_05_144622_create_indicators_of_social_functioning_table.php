<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndicatorsOfSocialFunctioningTable extends Migration
{
    public function up()
    {
        Schema::create('indicators_of_social_functioning', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->date('date_admission');
            $table->date('date_administered');
            $table->integer('physical_raw_score1')->nullable();
            $table->integer('physical_score_per_area1')->nullable();
            $table->integer('physical_raw_score2')->nullable();
            $table->integer('physical_score_per_area2')->nullable();
            $table->integer('emotional_raw_score1')->nullable();
            $table->integer('emotional_score_per_area1')->nullable();
            $table->integer('emotional_raw_score2')->nullable();
            $table->integer('emotional_score_per_area2')->nullable();
            $table->integer('emotional_raw_score3')->nullable();
            $table->integer('emotional_score_per_area3')->nullable();
            $table->integer('emotional_raw_score4')->nullable();
            $table->integer('emotional_score_per_area4')->nullable();
            $table->integer('emotional_raw_score5')->nullable();
            $table->integer('emotional_score_per_area5')->nullable();
            $table->integer('emotional_raw_score6')->nullable();
            $table->integer('emotional_score_per_area6')->nullable();
            $table->integer('social_raw_score1')->nullable();
            $table->integer('social_score_per_area1')->nullable();
            $table->integer('social_raw_score2')->nullable();
            $table->integer('social_score_per_area2')->nullable();
            $table->integer('social_raw_score3')->nullable();
            $table->integer('social_score_per_area3')->nullable();
            $table->integer('social_raw_score4')->nullable();
            $table->integer('social_score_per_area4')->nullable();
            $table->integer('social_raw_score5')->nullable();
            $table->integer('social_score_per_area5')->nullable();
            $table->integer('social_raw_score6')->nullable();
            $table->integer('social_score_per_area6')->nullable();
            $table->integer('social_raw_score7')->nullable();
            $table->integer('social_score_per_area7')->nullable();
            $table->integer('social_raw_score8')->nullable();
            $table->integer('social_score_per_area8')->nullable();
            $table->integer('spiritual_raw_score1')->nullable();
            $table->integer('spiritual_score_per_area1')->nullable();
            $table->integer('educational_raw_score')->nullable();
            $table->integer('educational_score_per_area')->nullable();
            $table->integer('economic_raw_score')->nullable();
            $table->integer('economic_score_per_area')->nullable();
            $table->integer('general_score')->nullable();
            $table->text('interpretation')->nullable();
            $table->string('prepared_by')->nullable();
            $table->string('discussed_with')->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('indicators_of_social_functioning');
    }
}
