<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('medication_id');

            $table->string('dosage');          // e.g., "500mg"
            $table->string('frequency');       // e.g., "3x a day"
            $table->string('route');           // e.g., "oral"
            $table->text('instructions')->nullable();
            $table->date('date_prescribed');   // no zero dates allowed

            $table->string('status')->default('Active'); 
            // Active, Completed, Cancelled

            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
            $table->foreign('medication_id')->references('id')->on('medications')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('prescriptions');
    }
};
