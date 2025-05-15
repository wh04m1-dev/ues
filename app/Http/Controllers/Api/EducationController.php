<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EducationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'education_name' => 'required|string|max:255',
            'education_date' => 'nullable|date',
            'education_location' => 'nullable|string|max:255',
            'education_grade' => 'nullable|string|max:255',
        ]);

        $user_id = Auth::id();
        if (!$user_id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $education = Education::create([
            'education_name' => $request->education_name,
            'education_date' => $request->education_date,
            'education_location' => $request->education_location,
            'education_grade' => $request->education_grade,
            'user_id' => $user_id,
        ]);

        return response()->json([
            'message' => 'Education record created successfully!',
            'education' => $education
        ], 201);
    }

    public function index()
    {
        $user_id = Auth::id();
        $education = Education::where('user_id', $user_id)->get();
        return response()->json([
            'education' => $education
        ]);
    }

    public function update(Request $request, $id)
    {
        $education = Education::find($id);

        if (!$education || $education->user_id !== Auth::id()) {
            return response()->json(['error' => 'Not found or unauthorized'], 404);
        }

        $request->validate([
            'education_name' => 'required|string|max:255',
            'education_date' => 'nullable|date',
            'education_location' => 'nullable|string|max:255',
            'education_grade' => 'nullable|string|max:255',
        ]);

        $education->update($request->only([
            'education_name',
            'education_date',
            'education_location',
            'education_grade'
        ]));

        return response()->json([
            'message' => 'Education record updated successfully!',
            'education' => $education
        ]);
    }

    public function destroy($id)
    {
        $education = Education::find($id);

        if (!$education || $education->user_id !== Auth::id()) {
            return response()->json(['error' => 'Not found or unauthorized'], 404);
        }

        $education->delete();

        return response()->json([
            'message' => 'Education record deleted successfully!'
        ]);
    }

}
