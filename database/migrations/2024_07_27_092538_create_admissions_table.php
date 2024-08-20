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

            // Foreign key definition
            $table->foreign('client_id')
                  ->references('id')
                  ->on('clients')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        // Check if the 'admissions' table exists before trying to drop the foreign key
        if (Schema::hasTable('admissions')) {
            Schema::table('admissions', function (Blueprint $table) {
                // Drop the foreign key constraint if it exists
                if (Schema::hasColumn('admissions', 'client_id')) {
                    $table->dropForeign(['client_id']);
                }
            });

            // Then drop the 'admissions' table
            Schema::dropIfExists('admissions');
        }
    }
}
