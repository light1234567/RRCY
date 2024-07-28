<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsSubmittedTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('documents_submitted');

        Schema::create('documents_submitted', function (Blueprint $table) {
            $table->id();
            $table->boolean('scsr')->default(false);
            $table->boolean('courtOrder')->default(false);
            $table->boolean('medicalCertificates')->default(false);
            $table->boolean('consConsent')->default(false);
            $table->boolean('schoolRecords')->default(false);
            $table->boolean('others')->default(false);
            $table->unsignedBigInteger('admission_id');
            $table->unsignedBigInteger('client_id'); // Add client_id
            $table->timestamps();

            $table->foreign('admission_id')->references('id')->on('admissions')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade'); // Add foreign key constraint
        });
    }

    public function down()
    {
        Schema::dropIfExists('documents_submitted');
    }
}

