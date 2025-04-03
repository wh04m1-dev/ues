<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Personal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PersonalController extends Controller
{
    public function store(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'certification' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:15',
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Validation failed.',
            ], 400);
        }
    
        $user = Auth::user();

        // Handle picture upload if provided
        $picturePath = null;
        if ($request->hasFile('picture')) {
            $picturePath = $request->file('picture')->store('pictures', 'public');
        }

        // Create a new personal record
        $personal = new Personal();
        $personal->user_id = $user->id; // Use authenticated user's ID
        $personal->picture = $picturePath ? asset('storage/' . $picturePath) : null;
        $personal->certification = $request->certification;
        $personal->dob = $request->dob;
        $personal->gender = $request->gender;
        $personal->address = $request->address;
        $personal->phone = $request->phone;

        $personal->save();

        return response()->json([
            'message' => 'Personal data created successfully.',
            'data' => $personal
        ], 201);
    }

    public function index(){
        $personal = Personal::all();

        return response()->json([
            'personal' => $personal
        ]);
    }
}
