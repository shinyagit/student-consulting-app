<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_students_index(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($user)->get(route('students.index'));

        $response->assertOk();
    }

    public function test_admin_can_view_student_create_page(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($user)->get(route('students.create'));

        $response->assertOk();
    }

    public function test_staff_can_view_student_create_page(): void
    {
        $user = User::factory()->create([
            'role' => 'staff',
        ]);

        $response = $this->actingAs($user)->get(route('students.create'));

        $response->assertOk();
    }

    public function test_admin_can_view_student_show_page(): void
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

        $response = $this->actingAs($user)->get(route('students.show', $student));

        $response->assertOk();
        $response->assertSee('山田 太郎');
    }

    public function test_staff_can_view_student_show_page(): void
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
            'consultant_user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->get(route('students.show', $student));

        $response->assertOk();
        $response->assertSee('山田 太郎');
    }

    public function test_staff_cannot_view_unassigned_student_show_page(): void
    {
        $user = User::factory()->create([
            'role' => 'staff',
        ]);

        $otherUser = User::factory()->create([
            'role' => 'staff',
        ]);

        $student = Student::create([
            'name' => '山田 太郎',
            'name_kana' => 'ヤマダ タロウ',
            'school_name' => '広島第一高校',
            'grade' => '高1',
            'status' => 'active',
            'consultant_user_id' => $otherUser->id,
        ]);

        $response = $this->actingAs($user)->get(route('students.show', $student));

        $response->assertForbidden();
    }

    public function test_admin_can_update_student_status_and_profile_fields(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $teacher = Teacher::create([
            'name' => '田中 一郎',
            'department' => '広島大学教育学部',
            'school_year' => '3年',
            'age' => 21,
            'email' => 'tanaka@example.com',
            'status' => 'active',
        ]);

        $student = Student::create([
            'name' => '山田 太郎',
            'name_kana' => 'ヤマダ タロウ',
            'school_name' => '広島第一高校',
            'grade' => '高1',
            'status' => 'active',
            'course_type' => 'science',
            'exam_subjects' => ['英語', '数学IA'],
            'desired_schools' => ['広島大学'],
            'note' => '初期メモ',
        ]);

        $response = $this->actingAs($user)->put(route('students.update', $student), [
            'name' => '山田 花子',
            'name_kana' => 'ヤマダ ハナコ',
            'school_name' => '広島第二高校',
            'grade' => '高2',
            'status' => 'leave',
            'course_type' => 'liberal_arts',
            'exam_subjects' => ['英語', '国語'],
            'desired_schools' => ['広島大学', '岡山大学'],
            'note' => '休会中',
            'teacher_assignments' => [
                [
                    'teacher_id' => $teacher->id,
                    'subjects' => ['英語', '国語'],
                ],
            ],
        ]);

        $response->assertRedirect(route('students.show', $student));

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'name' => '山田 花子',
            'status' => 'leave',
            'course_type' => 'liberal_arts',
        ]);

        $this->assertDatabaseHas('student_teacher', [
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
        ]);

        $this->assertDatabaseHas('student_teacher_subjects', [
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'subject' => '英語',
        ]);

        $this->assertDatabaseHas('student_teacher_subjects', [
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'subject' => '国語',
        ]);
    }
}