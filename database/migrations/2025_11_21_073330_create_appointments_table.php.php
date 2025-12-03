<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();

            // Foreign Keys
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('doctor_id');

            // Appointment Details
            $table->date('appointment_date');      // No zero dates allowed
            $table->time('appointment_time');      // Time slot
            $table->string('reason')->nullable();   // Optional reason for visit
            $table->string('status')->default('Scheduled'); 
            // Common statuses: Scheduled, Completed, Cancelled, No-show, Rescheduled

            $table->timestamps();

            // Add foreign key constraints
            $table->foreign('patient_id')
                  ->references('id')->on('patients')
                  ->onDelete('cascade');

            $table->foreign('doctor_id')
                  ->references('id')->on('doctors')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
    }
};
