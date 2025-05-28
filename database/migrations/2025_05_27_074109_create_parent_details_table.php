<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parent_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('registration_id');

            $table->string('fathername');
            $table->string('father_job')->nullable();
            $table->boolean('father_alive')->default(true);

            $table->string('mothername');
            $table->string('mother_job')->nullable();
            $table->boolean('mother_alive')->default(true);

            $table->timestamps();

            $table->foreign('registration_id')->references('id')->on('registrations')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parent_details');
    }
};
