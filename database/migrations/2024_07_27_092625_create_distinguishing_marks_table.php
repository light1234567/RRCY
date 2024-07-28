<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistinguishingMarksTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('distinguishing_marks');

        Schema::create('distinguishing_marks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admission_id');
            $table->unsignedBigInteger('client_id'); // Add client_id
            $table->string('tattoo_scars')->nullable();
            $table->decimal('height', 5, 2);
            $table->decimal('weight', 5, 2);
            $table->string('colour_of_eye')->nullable();
            $table->string('skin')->nullable();
            $table->timestamps();

            $table->foreign('admission_id')->references('id')->on('admissions')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade'); // Add foreign key constraint
        });
    }

    public function down()
    {
        Schema::dropIfExists('distinguishing_marks');
    }
}
