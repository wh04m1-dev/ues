<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::with('department')->get();

        return response()->json([
            'message' => 'Exams retrieved successfully!',
            'exams' => $exams->map(function ($exam) {
                return [
                    'id' => $exam->id,
                    'department_id' => $exam->department_id,
                    'department_name' => $exam->department->name ?? null,
                    'exam_date' => $exam->exam_date,
                    'duration' => $exam->duration,
                    'total_marks' => $exam->total_marks,
                    'passing_marks' => $exam->passing_marks,
                    'created_at' => $exam->created_at,
                    'updated_at' => $exam->updated_at,
                ];
            })
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'exam_date' => 'required|date',
            'duration' => 'required|integer',
            'total_marks' => 'required|integer',
            'passing_marks' => 'required|integer',
        ]);

        $exam = Exam::create($request->only([
            'department_id',
            'exam_date',
            'duration',
            'total_marks',
            'passing_marks',
        ]));

        return response()->json([
            'message' => 'Exam created successfully!',
            'exam' => $exam
        ], 201);
    }

    public function show($id)
    {
        $exam = Exam::with('department')->find($id);

        if (!$exam) {
            return response()->json(['error' => 'Exam not found'], 404);
        }

        return response()->json([
            'exam' => [
                'id' => $exam->id,
                'department_id' => $exam->department_id,
                'department_name' => $exam->department->name ?? null,
                'exam_date' => $exam->exam_date,
                'duration' => $exam->duration,
                'total_marks' => $exam->total_marks,
                'passing_marks' => $exam->passing_marks,
                'created_at' => $exam->created_at,
                'updated_at' => $exam->updated_at,
            ]
        ]);
    }

    public function update(Request $request, $id)
    {
        $exam = Exam::find($id);

        if (!$exam) {
            return response()->json(['error' => 'Exam not found'], 404);
        }

        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'exam_date' => 'required|date',
            'duration' => 'required|integer',
            'total_marks' => 'required|integer',
            'passing_marks' => 'required|integer',
        ]);

        $exam->update($request->only([
            'department_id',
            'exam_date',
            'duration',
            'total_marks',
            'passing_marks',
        ]));

        return response()->json([
            'message' => 'Exam updated successfully!',
            'exam' => $exam
        ]);
    }

    public function destroy($id)
    {
        $exam = Exam::find($id);

        if (!$exam) {
            return response()->json(['error' => 'Exam not found'], 404);
        }

        $exam->delete();

        return response()->json(['message' => 'Exam deleted successfully!']);
    }
}
