<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuidanceRecordValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guidance_record_store_requires_consulted_at(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $student = Student::create([
            'name' => '山田 太郎',
            'name_kana' => 'ヤマダ タロウ',
            'school_name' => '広島第一高校',
            'grade' => '高1',
            'status' => 'active',
        ]);

        $teacher = Teacher::create([
            'name' => '田中 一郎',
            'email' => 'tanaka@example.com',
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->post(route('guidance-records.store'), [
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'consulted_at' => '',
            'self_score' => 75,
        ]);

        $response->assertSessionHasErrors(['consulted_at']);
    }

    public function test_guidance_record_store_rejects_self_score_over_100(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $student = Student::create([
            'name' => '山田 太郎',
            'name_kana' => 'ヤマダ タロウ',
            'school_name' => '広島第一高校',
            'grade' => '高1',
            'status' => 'active',
        ]);

        $teacher = Teacher::create([
            'name' => '田中 一郎',
            'email' => 'tanaka@example.com',
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->post(route('guidance-records.store'), [
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'consulted_at' => now()->format('Y-m-d H:i:s'),
            'self_score' => 101,
        ]);

        $response->assertSessionHasErrors(['self_score']);
    }
}