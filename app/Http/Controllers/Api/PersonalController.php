<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Personal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PersonalController extends Controller
{
    // 📥 Index: Get all personal records
    public function index()
    {
        $personal = Personal::all();

        return response()->json([
            'personal' => $personal
        ]);
    }

    // 📤 Store: Create new personal info
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'certification' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = Auth::user();

        $picturePath = null;
        if ($request->hasFile('picture')) {
            $picturePath = $request->file('picture')->store('pictures', 'public');
        }

        $personal = Personal::create([
            'user_id' => $user->id,
            'picture' => $picturePath ? asset('storage/' . $picturePath) : null,
            'certification' => $request->certification,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        return response()->json([
            'message' => 'Personal data created successfully.',
            'data' => $personal
        ], 201);
    }

    // 📄 Show: Get single personal record by ID
    public function show($id)
    {
        $personal = Personal::find($id);

        if (!$personal) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(['personal' => $personal]);
    }

    // ✏️ Update: Update personal info
    public function update(Request $request, $id)
    {
        $personal = Personal::find($id);

        if (!$personal) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'certification' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        if ($request->hasFile('picture')) {
            $picturePath = $request->file('picture')->store('pictures', 'public');
            $personal->picture = asset('storage/' . $picturePath);
        }

        $personal->certification = $request->certification ?? $personal->certification;
        $personal->dob = $request->dob ?? $personal->dob;
        $personal->gender = $request->gender ?? $personal->gender;
        $personal->address = $request->address ?? $personal->address;
        $personal->phone = $request->phone ?? $personal->phone;

        $personal->save();

        return response()->json([
            'message' => 'Personal data updated successfully.',
            'data' => $personal
        ]);
    }

    // ❌ Delete: Delete personal info
    public function destroy($id)
    {
        $personal = Personal::find($id);

        if (!$personal) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $personal->delete();

        return response()->json(['message' => 'Personal record deleted successfully']);
    }
}
