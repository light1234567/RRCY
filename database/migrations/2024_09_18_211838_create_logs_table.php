<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->string('model'); // The name of the model (e.g., 'Admission')
            $table->unsignedBigInteger('record_id'); // The ID of the record
            $table->string('action'); // Action type ('created', 'updated', 'deleted')
            $table->text('changes')->nullable(); // Optional: Store changes made to the record
            $table->string('updated_by'); // The user who performed the action
            $table->string('client_full_name')->nullable();
            $table->string('user_role')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
