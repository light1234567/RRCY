<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsSubmittedTable extends Migration
{
    public function up()
    {
        Schema::create('documents_submitted', function (Blueprint $table) {
            $table->id('documents_submitted_id');
            $table->unsignedBigInteger('admission_id');
            $table->string('documents_submitted_type', 50);
            $table->timestamps();

            $table->foreign('admission_id')->references('admission_id')->on('admissions')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('documents_submitted');
    }
}
