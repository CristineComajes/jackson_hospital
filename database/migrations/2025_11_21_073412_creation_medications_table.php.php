<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('medications', function (Blueprint $table) {
            $table->id();

            $table->string('name');                // Medication name (e.g., Paracetamol)
            $table->string('brand')->nullable();   // Optional brand name
            $table->string('dosage');              // e.g., "500 mg"
            $table->string('form');                // e.g., tablet, capsule, syrup
            $table->text('description')->nullable(); 
            $table->string('route')->nullable();   // e.g., oral, topical, injection

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('medications');
    }
};
