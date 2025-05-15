<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    // List all registrations for the authenticated user
    public function index()
    {
        $user_id = Auth::id();
        $registrations = Registration::with('exam')->where('user_id', $user_id)->get();

        return response()->json([
            'message' => 'Registrations retrieved successfully!',
            'registrations' => $registrations->map(function ($registration) {
                return [
                    'id' => $registration->id,
                    'exam_id' => $registration->exam_id,
                    'exam_date' => $registration->exam->exam_date ?? null,
                    'total_marks' => $registration->exam->total_marks ?? null,
                    'registered_at' => $registration->created_at,
                ];
            })
        ]);
    }

    // Store a new registration
    public function store(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
        ]);

        $user_id = Auth::id();

        // Prevent duplicate registration
        $exists = Registration::where('user_id', $user_id)
            ->where('exam_id', $request->exam_id)
            ->exists();

        if ($exists) {
            return response()->json(['error' => 'You have already registered for this exam.'], 409);
        }

        $registration = Registration::create([
            'user_id' => $user_id,
            'exam_id' => $request->exam_id,
        ]);

        return response()->json([
            'message' => 'Registered successfully!',
            'registration' => $registration
        ], 201);
    }

    // Delete a registration (unregister)
    public function destroy($id)
    {
        $registration = Registration::find($id);

        if (!$registration) {
            return response()->json(['error' => 'Registration not found'], 404);
        }

        // Optional: only allow users to delete their own registration
        if ($registration->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $registration->delete();

        return response()->json(['message' => 'Registration deleted successfully!']);
    }

    public function update(Request $request, $id)
    {
        $registration = Registration::find($id);

        if (!$registration) {
            return response()->json(['error' => 'Registration not found'], 404);
        }

        $request->validate([
            'exam_id' => 'required|exists:exams,id',
        ]);

        $registration->exam_id = $request->exam_id;
        $registration->save();

        return response()->json([
            'message' => 'Registration updated successfully!',
            'registration' => $registration
        ]);
    }

}
