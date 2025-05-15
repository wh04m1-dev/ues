<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();

        $results = Result::with('exam')->where('user_id', $user_id)->get();

        return response()->json([
            'message' => 'Results retrieved successfully!',
            'results' => $results->map(function ($result) {
                return [
                    'id' => $result->id,
                    'exam_id' => $result->exam_id,
                    'exam_date' => $result->exam->exam_date ?? null,
                    'pass_status' => $result->pass_status,
                    'created_at' => $result->created_at,
                ];
            }),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'pass_status' => 'required|string|in:pass,fail'
        ]);

        $user_id = Auth::id();

        $result = Result::create([
            'user_id' => $user_id,
            'exam_id' => $request->exam_id,
            'pass_status' => $request->pass_status,
        ]);

        return response()->json([
            'message' => 'Result submitted successfully!',
            'result' => $result
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $result = Result::find($id);

        if (!$result) {
            return response()->json(['error' => 'Result not found'], 404);
        }

        if ($result->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'exam_id' => 'sometimes|exists:exams,id',
            'pass_status' => 'required|string|in:pass,fail'
        ]);

        $result->update([
            'exam_id' => $request->exam_id ?? $result->exam_id,
            'pass_status' => $request->pass_status
        ]);

        return response()->json([
            'message' => 'Result updated successfully!',
            'result' => $result
        ]);
    }

    public function destroy($id)
    {
        $result = Result::find($id);

        if (!$result) {
            return response()->json(['error' => 'Result not found'], 404);
        }

        if ($result->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $result->delete();

        return response()->json(['message' => 'Result deleted successfully!']);
    }
}
