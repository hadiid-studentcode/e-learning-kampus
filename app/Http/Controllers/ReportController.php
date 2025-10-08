<?php

namespace App\Http\Controllers;

use App\Models\Assignments;
use App\Models\Courses;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function courseStats(Request $request)
    {


        $courses = Courses::withCount('courseStudents')
            ->get();

        $report = $courses->map(function ($course) {
            return [
                'course_id' => $course->id,
                'course_name' => $course->name,
                'total_students' => $course->students_count,
            ];
        });

        return response()->json([
            'message' => 'Statistik mahasiswa per mata kuliah berhasil diambil.',
            'data' => $report,
            'status' => 200
        ]);
    }

    public function assignmentStats(Request $request)
    {


        $assignments = Assignments::withCount(['submissions as graded_count' => function ($query) {
            $query->whereNotNull('score');
        }])
            ->withCount(['submissions as ungraded_count' => function ($query) {
                $query->whereNull('score');
            }])
            ->withCount('submissions as total_submissions')
            ->get();

        $report = $assignments->map(function ($assignment) {
            return [
                'assignment_id' => $assignment->id,
                'title' => $assignment->title,
                'total_submissions' => $assignment->total_submissions,
                'graded_submissions' => $assignment->graded_count,
                'ungraded_submissions' => $assignment->ungraded_count,
            ];
        });

        return response()->json([
            'message' => 'Statistik penilaian tugas berhasil diambil.',
            'data' => $report,
            'status' => 200
        ]);
    }

    public function studentStats(Request $request, $id)
    {


        $student = User::with(['submissions.assignment', 'submissions' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])
            ->where('role', 'mahasiswa')
            ->findOrFail($id);

        $averageScore = $student->submissions->avg('score');

        $report = [
            'student_id' => $student->id,
            'student_name' => $student->name,
            'total_assignments_submitted' => $student->submissions->count(),
            'average_score' => round($averageScore, 2) ?? 'N/A',
            'details' => $student->submissions->map(function ($submission) {
                return [
                    'assignment_id' => $submission->assignment_id,
                    'assignment_title' => $submission->assignment->title ?? 'Tugas Dihapus',
                    'deadline' => $submission->assignment->deadline ?? 'N/A',
                    'submission_date' => $submission->created_at,
                    'score' => $submission->score ?? 'Belum Dinilai',
                ];
            }),
        ];

        return response()->json([
            'message' => 'Statistik mahasiswa berhasil diambil.',
            'data' => $report,
            'status' => 200
        ]);
    }
}
