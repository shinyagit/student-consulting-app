<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_teacher_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();
            $table->string('subject');
            $table->timestamps();

            $table->unique(['student_id', 'teacher_id', 'subject']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_teacher_subjects');
    }
};