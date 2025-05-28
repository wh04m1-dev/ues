<?php

namespace App\Http\Controllers\Api;

use App\Models\Exam;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExamController extends Controller
{
    public function index()
    {
        return response()->json(Exam::with('user')->get(), 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'exam_date' => 'required|date',
            'total_marks' => 'required|integer',
            'pass_status' => 'required|in:pass,fail'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $exam = Exam::create($request->all());
        return response()->json($exam, 201);
    }

    public function show($id)
    {
        $exam = Exam::with('user')->findOrFail($id);
        return response()->json($exam, 200);
    }

    public function update(Request $request, $id)
    {
        $exam = Exam::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'user_id' => 'exists:users,id',
            'exam_date' => 'date',
            'total_marks' => 'integer',
            'pass_status' => 'in:pass,fail'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $exam->update($request->all());
        return response()->json($exam, 200);
    }

    public function destroy($id)
    {
        Exam::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
