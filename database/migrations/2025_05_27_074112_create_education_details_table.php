<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('education_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('registration_id');

            $table->string('education_name');
            $table->date('education_date')->nullable();
            $table->string('education_location')->nullable();
            $table->string('education_grade')->nullable();

            $table->timestamps();

            $table->foreign('registration_id')->references('id')->on('registrations')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('education_details');
    }
};
