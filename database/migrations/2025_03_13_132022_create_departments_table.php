<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->unsignedTinyInteger('id', true)->primary();
            $table->string('name')->unique();
            $table->string('image')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
