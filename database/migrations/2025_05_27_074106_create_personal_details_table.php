<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personal_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('registration_id');

            $table->string('firstname');
            $table->string('lastname');
            $table->string('picture')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->date('dob')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('phonenumber', 20);

            $table->timestamps();

            $table->foreign('registration_id')->references('id')->on('registrations')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_details');
    }
};
