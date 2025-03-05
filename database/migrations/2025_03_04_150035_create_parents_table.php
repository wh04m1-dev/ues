<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('fathername');
            $table->string('job')->nullable();
            $table->boolean('father_alive')->default(true);
            $table->string('mothername');
            $table->string('mother_job')->nullable();
            $table->boolean('mother_alive')->default(true);
            $table->string('phonenumber', 20);

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parents');
    }
};
