<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();

            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('suffix')->nullable();

            $table->date('dob');
            $table->unsignedTinyInteger('age'); // Better as integer

            $table->enum('gender', ['Male', 'Female', 'Other']);

            $table->string('contact_number', 20);
            $table->string('email')->unique();

            $table->string('address')->nullable();

            $table->string('username')->unique(); // Username should be unique
            $table->string('password'); // Don't limit password length

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('patients');
    }
};
