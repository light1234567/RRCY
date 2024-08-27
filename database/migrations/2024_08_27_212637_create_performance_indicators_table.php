<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerformanceIndicatorsTable extends Migration
{
    public function up()
    {
        // Drop the table if it exists to avoid conflicts
        Schema::dropIfExists('performance_indicators');

        // Create the table
        Schema::create('performance_indicators', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('section_id'); // Ensure this matches the `id` in `performance_sections`
            $table->string('description');
            $table->integer('self_rating')->nullable();
            $table->integer('mdo_rating')->nullable();
            $table->timestamps();

            // Define the foreign key constraint
            $table->foreign('section_id')
                  ->references('id')
                  ->on('performance_sections')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('performance_indicators');
    }
}
