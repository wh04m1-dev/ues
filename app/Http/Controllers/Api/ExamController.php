<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function store(Request $request)
    {
        // Validate incoming data (this will automatically return an error response if validation fails)
        $request->validate([
            'department_id' => 'required|exists:departments,id',  // Ensure the department exists
        
            'exam_date' => 'required|date',
            'duration' => 'required|integer',
            'total_marks' => 'required|integer',
            'passing_marks' => 'required|integer',
        ]);

        // If validation passes, create the exam record
        $exam = Exam::create([
            'department_id' => $request->department_id,
      
            'exam_date' => $request->exam_date,
            'duration' => $request->duration,
            'total_marks' => $request->total_marks,
            'passing_marks' => $request->passing_marks,
        ]);

        // Return success response with the created exam data
        return response()->json([
            'message' => 'Exam created successfully!',
            'exam' => $exam
        ], 201);
    }
    public function index()
    {
        
        $exams = Exam::with('department')->get();

        
        return response()->json([
            'message' => 'Exams retrieved successfully!',
            'exams' => $exams->map(function($exam) {
                // Add department_name to each exam
                return [
                    'id' => $exam->id,
                    // 'department_id' => $exam->department_id,
                    'department_name' => $exam->department->name,  // Get the department name from the related department
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
}
