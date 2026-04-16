<?php

namespace App\Http\Controllers;

use App\Models\GuidanceRecord;
use App\Models\Student;
use App\Models\Teacher;

class DashboardController extends Controller
{
    public function index()
    {
        $studentQuery = Student::query();
        $recordQuery = GuidanceRecord::query();

        if (auth()->user()->role === 'staff') {
            $studentQuery->where('consultant_user_id', auth()->id());

            $recordQuery->whereHas('student', function ($query) {
                $query->where('consultant_user_id', auth()->id());
            });
        }

        $studentCount = $studentQuery->count();
        $teacherCount = Teacher::count();
        $recordCount = $recordQuery->count();

        $recentRecords = $recordQuery
            ->with([
                'student' => function ($query) {
                    $query->withCount('guidanceRecords')
                        ->with('consultant');
                },
                'user',
            ])
            ->latest('consulted_at')
            ->limit(8)
            ->get();

        return view('dashboard.index', compact(
            'studentCount',
            'teacherCount',
            'recordCount',
            'recentRecords'
        ));
    }
}