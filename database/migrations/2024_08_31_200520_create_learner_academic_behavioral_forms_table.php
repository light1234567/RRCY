<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('learner_academic_behavioral_forms', function (Blueprint $table) {
            $table->unsignedMediumInteger('id', false)->autoIncrement();
            $table->unsignedMediumInteger('client_id');             
            $table->string('month', 10)->nullable();
            $table->string('school_year', 10)->nullable();
            $table->string('learner_name', 50)->nullable();
            $table->string('grade', 20)->nullable();
            $table->string('lrn', 20)->nullable();
            $table->string('status', 20)->nullable();
            $table->json('skills')->nullable();
            $table->text('observation_feedback')->nullable();
            $table->string('category_adviser_signature', 150)->nullable();
            $table->string('educational_section_head_signature', 150)->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learner_academic_behavioral_forms');
    }
};
