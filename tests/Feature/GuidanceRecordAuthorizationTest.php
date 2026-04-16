<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuidanceRecordAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_guidance_record_create_page_with_student_id(): void
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

        $response = $this->actingAs($user)->get(route('guidance-records.create', [
            'student_id' => $student->id,
        ]));

        $response->assertOk();
    }

    public function test_staff_can_view_guidance_record_create_page_with_student_id(): void
    {
        $user = User::factory()->create([
            'role' => 'staff',
        ]);

        $student = Student::create([
            'name' => '山田 太郎',
            'name_kana' => 'ヤマダ タロウ',
            'school_name' => '広島第一高校',
            'grade' => '高1',
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->get(route('guidance-records.create', [
            'student_id' => $student->id,
        ]));

        $response->assertOk();
    }

    public function test_guidance_record_create_page_requires_student_id(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($user)->get(route('guidance-records.create'));

        $response->assertForbidden();
    }
}