<?php

namespace App\Http\Controllers\Api;

use App\Models\Exam;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $exams = Exam::with('user')->where('user_id', $user->id)->get();

        return response()->json($exams, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'exam_date'   => 'required|date',
            'total_marks' => 'required|integer',
            'pass_status' => 'required|in:pass,fail',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $exam = Exam::create([
            'user_id'     => Auth::user()->id,
            'exam_date'   => $request->exam_date,
            'total_marks' => $request->total_marks,
            'pass_status' => $request->pass_status,
        ]);

        return response()->json($exam, 201);
    }

    public function show($id)
    {
        $exam = Exam::with('user')->where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();

        return response()->json($exam, 200);
    }

    public function update(Request $request, $id)
    {
        $exam = Exam::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'exam_date'   => 'date',
            'total_marks' => 'integer',
            'pass_status' => 'in:pass,fail',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $exam->update($request->only(['exam_date', 'total_marks', 'pass_status']));

        return response()->json($exam, 200);
    }

    public function destroy($id)
    {
        $exam = Exam::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();
        $exam->delete();

        return response()->json(null, 204);
    }
}
