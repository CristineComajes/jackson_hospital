<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pharmacists', function (Blueprint $table) {
            $table->id();

            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');

            $table->string('license_number')->unique(); // PRC license #
            $table->string('contact_number');
            $table->string('email')->unique();

            $table->string('username')->unique();
            $table->string('password');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pharmacists');
    }
};
