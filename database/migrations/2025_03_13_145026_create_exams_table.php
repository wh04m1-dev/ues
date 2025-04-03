<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('department_id'); // Foreign key referencing department
            $table->date('exam_date'); // Exam date
            $table->integer('duration'); // Exam duration (in minutes)
            $table->integer('total_marks'); // Total marks for the exam
            $table->integer('passing_marks');
            $table->timestamps();

            $table->foreign('department_id')->references('id')->on('departments')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
