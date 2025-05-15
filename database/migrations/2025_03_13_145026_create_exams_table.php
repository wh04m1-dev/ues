<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('department_id');
            $table->date('exam_date');
            $table->integer('duration');
            $table->integer('total_marks');
            $table->integer('passing_marks');
            $table->timestamps();

            $table->foreign('department_id')->references('id')->on('departments')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
