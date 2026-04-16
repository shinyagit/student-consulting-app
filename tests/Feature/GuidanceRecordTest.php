<?php

namespace Tests\Feature;

use App\Models\GuidanceRecord;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuidanceRecordTest extends TestCase
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

        $response->assertStatus(200);
        $response->assertSee('学習記録登録');
        $response->assertSee('山田 太郎');
    }

    public function test_guidance_record_create_page_requires_student_id(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($user)->get(route('guidance-records.create'));

        $response->assertForbidden();
    }

    public function test_staff_can_store_guidance_record(): void
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

        $response = $this->actingAs($user)->post(route('guidance-records.store'), [
            'student_id' => $student->id,
            'consulted_at' => now()->format('Y-m-d H:i:s'),
            'growth_point' => '順調',
            'challenge_point' => '復習不足',
            'self_score' => 80,
        ]);

        $response->assertRedirect(route('students.show', $student));

        $this->assertDatabaseHas('guidance_records', [
            'student_id' => $student->id,
            'user_id' => $user->id,
            'self_score' => 80,
        ]);
    }

    public function test_admin_can_view_guidance_record_edit_page(): void
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

        $record = GuidanceRecord::create([
            'student_id' => $student->id,
            'user_id' => $user->id,
            'consulted_at' => now(),
            'growth_point' => '順調',
            'challenge_point' => '復習不足',
            'self_score' => 70,
            'note' => 'テスト用',
            'next_plan_date' => now()->addWeek()->toDateString(),
            'subject1_name' => '数学',
            'subject1_detail' => '例題の復習',
            'subject2_name' => '英語',
            'subject2_detail' => '長文1題',
            'subject3_name' => '化学',
            'subject3_detail' => '暗記',
            'other_plan' => '毎日記録',
        ]);

        $response = $this->actingAs($user)->get(route('guidance-records.edit', $record));

        $response->assertStatus(200);
        $response->assertSee('学習記録編集');
        $response->assertSee('数学');
    }

    public function test_admin_can_update_guidance_record(): void
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

        $record = GuidanceRecord::create([
            'student_id' => $student->id,
            'user_id' => $user->id,
            'consulted_at' => now(),
            'growth_point' => '順調',
            'challenge_point' => '復習不足',
            'self_score' => 70,
            'note' => 'テスト用',
            'next_plan_date' => now()->addWeek()->toDateString(),
            'subject1_name' => '数学',
            'subject1_detail' => '例題の復習',
            'subject2_name' => '英語',
            'subject2_detail' => '長文1題',
            'subject3_name' => '化学',
            'subject3_detail' => '暗記',
            'other_plan' => '毎日記録',
        ]);

        $response = $this->actingAs($user)->put(route('guidance-records.update', $record), [
            'student_id' => $student->id,
            'consulted_at' => now()->format('Y-m-d H:i:s'),
            'growth_point' => '学習習慣がさらに安定した。',
            'challenge_point' => '英語の語彙が弱い。',
            'self_score' => 82,
            'note' => '次回模試対策を実施。',
            'next_plan_date' => now()->addDays(10)->format('Y-m-d'),
            'subject1_name' => '英語',
            'subject1_detail' => '単語帳の反復。',
            'subject2_name' => '数学',
            'subject2_detail' => '確率の復習。',
            'subject3_name' => '国語',
            'subject3_detail' => '現代文記述。',
            'other_plan' => '日曜に1週間の振り返り。',
        ]);

        $response->assertRedirect(route('students.show', $student));

        $this->assertDatabaseHas('guidance_records', [
            'id' => $record->id,
            'user_id' => $user->id,
            'self_score' => 82,
            'subject1_name' => '英語',
            'subject3_name' => '国語',
        ]);
    }

    public function test_admin_can_open_guidance_record_pdf(): void
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

        $record = GuidanceRecord::create([
            'student_id' => $student->id,
            'user_id' => $user->id,
            'consulted_at' => now(),
            'growth_point' => '順調',
            'challenge_point' => '復習不足',
            'self_score' => 70,
            'note' => 'テスト用',
            'next_plan_date' => now()->addWeek()->toDateString(),
            'subject1_name' => '数学',
            'subject1_detail' => '例題の復習',
            'subject2_name' => '英語',
            'subject2_detail' => '長文1題',
            'subject3_name' => '化学',
            'subject3_detail' => '暗記',
            'other_plan' => '毎日記録',
        ]);

        $response = $this->actingAs($user)->get(route('guidance-records.pdf', $record));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_guest_is_redirected_from_guidance_record_pdf(): void
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

        $record = GuidanceRecord::create([
            'student_id' => $student->id,
            'user_id' => $user->id,
            'consulted_at' => now(),
        ]);

        $response = $this->get(route('guidance-records.pdf', $record));

        $response->assertRedirect('/login');
    }
}