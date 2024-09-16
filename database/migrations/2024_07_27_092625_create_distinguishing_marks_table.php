<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistinguishingMarksTable extends Migration
{
    public function up()
    {
        Schema::create('distinguishing_marks', function (Blueprint $table) {
            $table->id(); // Automatically creates an 'id' column
            $table->unsignedBigInteger('admission_id');
            $table->string('tattoo_scars', 100)->nullable();
            $table->decimal('height', 5, 2)->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->string('colour_of_eye', 50)->nullable();
            $table->string('skin_colour', 50)->nullable();
            $table->timestamps();

            $table->foreign('admission_id')->references('id')->on('admissions')->onDelete('cascade');
        });
    }

    public function down()
{
    Schema::disableForeignKeyConstraints();

    // Drop foreign key constraints first
    Schema::table('distinguishing_marks', function (Blueprint $table) {
        if (Schema::hasColumn('distinguishing_marks', 'admission_id')) {
            $table->dropForeign(['admission_id']);
        }
    });

    // Then drop the table
    Schema::dropIfExists('distinguishing_marks');

    Schema::enableForeignKeyConstraints();
}

}
