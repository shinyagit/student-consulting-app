<?php

namespace Database\Seeders;

use App\Models\GuidanceRecord;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class GuidanceRecordSeeder extends Seeder
{
    public function run(): void
    {
        // if (app()->environment('production')) {
        //     throw new \RuntimeException(static::class.' cannot run in production.');
        // }
        
        $adminUser = User::where('role', 'admin')->first();

        if (! $adminUser) {
            return;
        }

        $students = Student::query()->orderBy('id')->get();

        foreach ($students as $index => $student) {
            $consultedAt = now()->subDays(7 + $index);

            GuidanceRecord::create([
                'student_id' => $student->id,
                'user_id' => $adminUser->id,
                'consulted_at' => $consultedAt,
                'growth_point' => '学習計画通りに進められる日が増えた。',
                'challenge_point' => '数学の演習量に波があり、難問で止まると全体の進度が落ちやすい。',
                'self_score' => 75,
                'note' => '模試日程を確認。',
                'next_plan_date' => (clone $consultedAt)->addWeek(),
                'subject1_name' => '数学',
                'subject1_detail' => '二次関数の復習。',
                'subject2_name' => '英語',
                'subject2_detail' => '長文読解の復習。',
                'subject3_name' => '化学',
                'subject3_detail' => '無機分野の暗記。',
                'other_plan' => '学習記録を毎日つける。',
            ]);
        }
    }
}