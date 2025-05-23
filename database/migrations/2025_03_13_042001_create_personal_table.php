<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personals', function (Blueprint $table) {
            $table->id();
            $table->string('picture')->nullable(); 
            $table->string('certification')->nullable(); 
            $table->date('dob')->nullable(); 
            $table->enum('gender', ['male', 'female'])->nullable(); 
            $table->text('address')->nullable(); 
            $table->string('phone')->nullable(); 
            $table->timestamps();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal');
    }
};
