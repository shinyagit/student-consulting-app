<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guidance_records', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->dateTime('consulted_at')->nullable();

            $table->text('growth_point')->nullable();
            $table->text('challenge_point')->nullable();
            $table->unsignedTinyInteger('self_score')->nullable();
            $table->text('note')->nullable();

            $table->dateTime('next_plan_date')->nullable();

            $table->string('subject1_name')->nullable();
            $table->text('subject1_detail')->nullable();

            $table->string('subject2_name')->nullable();
            $table->text('subject2_detail')->nullable();

            $table->string('subject3_name')->nullable();
            $table->text('subject3_detail')->nullable();

            $table->text('other_plan')->nullable();

            $table->timestamps();

            $table->index(['student_id', 'consulted_at']);
            $table->index(['user_id', 'consulted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guidance_records');
    }
};