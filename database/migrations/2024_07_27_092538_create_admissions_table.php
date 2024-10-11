<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmissionsTable extends Migration
{
    public function up()
    {
        Schema::create('admissions', function (Blueprint $table) {
            $table->unsignedMediumInteger('id', false)->autoIncrement();
            $table->unsignedMediumInteger('client_id');
            $table->string('committing_court', 50);
            $table->string('crim_case_number', 25);
            $table->string('offense_committed', 100);
            $table->date('date_admitted');
            $table->integer('days_in_jail');
            $table->integer('days_in_detention_center');
            $table->string('action_taken', 150);
            $table->text('general_impression');
            $table->string('case_status', 25);
            $table->string('referring_party_name', 50)->nullable();
            $table->string('admitting_officer', 50)->nullable();
            $table->string('designation_id_contact', 50)->nullable();
            $table->string('designation', 50)->nullable();
            $table->string('office_address', 50)->nullable();
            $table->dateTime('date_time')->nullable();
            $table->timestamps();
            
            // Foreign key definition
            $table->foreign('client_id')
                  ->references('id')
                  ->on('clients')
                  ->onDelete('cascade');
        });
    }

    public function down()
{
    Schema::disableForeignKeyConstraints();

    Schema::table('admissions', function (Blueprint $table) {
        $table->dropForeign(['client_id']);
    });

    Schema::dropIfExists('admissions');

    Schema::enableForeignKeyConstraints();
}

}