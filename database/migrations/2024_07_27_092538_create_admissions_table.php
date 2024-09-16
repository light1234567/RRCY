<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmissionsTable extends Migration
{
    public function up()
    {
        Schema::create('admissions', function (Blueprint $table) {
                        $table->id();
            $table->unsignedBigInteger('client_id');
            $table->string('committing_court', 100);
            $table->string('crim_case_number', 100);
            $table->string('offense_committed', 100);
            $table->date('date_admitted');
            $table->integer('days_in_jail');
            $table->integer('days_in_detention_center');
            $table->string('action_taken', 255);
            $table->text('general_impression');
            $table->string('case_status', 100);
            $table->string('referring_party_name', 100)->nullable();
            //$table->string('referring_party_signature')->nullable();
            $table->string('admitting_officer', 100)->nullable();
            $table->string('designation_id_contact', 100)->nullable();
            $table->string('designation', 100)->nullable();
            $table->string('office_address', 255)->nullable();
            $table->dateTime('date_time')->nullable();
            $table->string('noted_by', 100)->nullable();
            $table->string('updated_by')->nullable(); // Add updated_by field
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