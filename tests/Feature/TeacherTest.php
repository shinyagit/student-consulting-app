<?php

namespace Tests\Feature;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeacherTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_teachers_index(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($user)->get(route('teachers.index'));

        $response->assertOk();
    }

    public function test_staff_can_view_teachers_index(): void
    {
        $user = User::factory()->create([
            'role' => 'staff',
        ]);

        $response = $this->actingAs($user)->get(route('teachers.index'));

        $response->assertOk();
    }

    public function test_admin_can_view_teacher_show_page(): void
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

        $response = $this->actingAs($user)->get(route('teachers.show', $teacher));

        $response->assertOk();
        $response->assertSee('田中 一郎');
    }

    public function test_staff_can_view_teacher_show_page(): void
    {
        $user = User::factory()->create([
            'role' => 'staff',
        ]);

        $teacher = Teacher::create([
            'name' => '田中 一郎',
            'department' => '広島大学教育学部',
            'school_year' => '3年',
            'age' => 21,
            'email' => 'tanaka@example.com',
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->get(route('teachers.show', $teacher));

        $response->assertOk();
        $response->assertSee('田中 一郎');
    }

    public function test_guest_is_redirected_from_teachers_index(): void
    {
        $response = $this->get(route('teachers.index'));

        $response->assertRedirect('/login');
    }
}