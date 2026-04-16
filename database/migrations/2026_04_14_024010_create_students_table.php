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
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('name_kana')->nullable();
            $table->string('school_name')->nullable();
            $table->string('grade')->nullable();
            $table->string('status')->default('active');

            $table->string('course_type')->nullable();

            $table->json('exam_subjects')->nullable();
            $table->json('desired_schools')->nullable();

            $table->text('note')->nullable();

            $table->timestamps();

            $table->index('name');
            $table->index('status');
            $table->index('course_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};