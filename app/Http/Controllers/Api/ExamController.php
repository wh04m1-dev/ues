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

        if ($user->role === 'admin') {
            // Admin can see all exams
            $exams = Exam::with('registration.user')->get();
        } else {
            // Regular user can see only their own exams
            $exams = Exam::with('registration.user')
                ->whereHas('registration', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->get();
        }

        return response()->json($exams, 200);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $validator = Validator::make($request->all(), [
            'registration_id' => 'required|exists:registrations,id',
            'exam_date'       => 'required|date',
            'total_marks'     => 'required|integer',
            'pass_status'     => 'required|in:pass,fail',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $exam = Exam::create([
            'registration_id' => $request->registration_id,
            'exam_date'       => $request->exam_date,
            'total_marks'     => $request->total_marks,
            'pass_status'     => $request->pass_status,
        ]);

        return response()->json($exam, 201);
    }

    public function show($id)
    {
        $exam = Exam::with(['registration.user'])->findOrFail($id);

        $user = Auth::user();

        // Admin can see all, user can see only their own exams
        if ($user->role !== 'admin' && $exam->registration->user_id !== $user->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return response()->json($exam, 200);
    }

    public function update(Request $request, $id)
    {
        $exam = Exam::with('registration')->findOrFail($id);
        $user = Auth::user();

        // Only admin can update
        if ($user->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

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
        $exam = Exam::with('registration')->findOrFail($id);
        $user = Auth::user();

        // Only admin can delete
        if ($user->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $exam->delete();

        return response()->json(null, 204);
    }
}
