<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\Parents;
use App\Models\Personal;
use App\Models\Registration; // Include the Registration model
use App\Models\Exam; // Include the Exam model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class InformationRegisterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'fathername' => 'required|string|max:255',
            'job' => 'nullable|string|max:255',
            'father_alive' => 'required|in:1,2',  // Accept 1 for Yes, 2 for No
            'mothername' => 'required|string|max:255',
            'mother_job' => 'nullable|string|max:255',
            'mother_alive' => 'required|in:1,2',  // Accept 1 for Yes, 2 for No
            'phonenumber' => 'required|string|max:20',
            'education_name' => 'required|string|max:255',
            'education_date' => 'nullable|date',
            'education_location' => 'nullable|string|max:255',
            'education_grade' => 'nullable|string|max:255',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'certification' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:15',
            'exam_id' => 'required|exists:exams,id', // Make sure the exam_id is valid
        ]);

        // Get the authenticated user
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Convert '1' to true and '2' to false for both father_alive and mother_alive
        $father_alive = $request->father_alive == 1 ? true : false;
        $mother_alive = $request->mother_alive == 1 ? true : false;

        // Store parents data
        $parents = Parents::create([
            'user_id' => $user->id,
            'fathername' => $request->fathername,
            'job' => $request->job,
            'father_alive' => $father_alive,  // Store boolean true/false
            'mothername' => $request->mothername,
            'mother_job' => $request->mother_job,
            'mother_alive' => $mother_alive,  // Store boolean true/false
            'phonenumber' => $request->phonenumber,
        ]);

        // Store education data
        $education = Education::create([
            'education_name' => $request->education_name,
            'education_date' => $request->education_date,
            'education_location' => $request->education_location,
            'education_grade' => $request->education_grade,
            'user_id' => $user->id,
        ]);

        // Store personal data
        $personal = new Personal();
        $personal->user_id = $user->id;
        $personal->picture = $request->picture ? $request->file('picture')->store('picture', 'public') : null;
        $personal->certification = $request->certification;
        $personal->dob = $request->dob;
        $personal->gender = $request->gender;
        $personal->address = $request->address;
        $personal->phone = $request->phone;
        $personal->save();

        // Store registration data
        $registration = Registration::create([
            'user_id' => $user->id,
            'exam_id' => $request->exam_id,
        ]);

        return response()->json([
            'message' => 'All information records created successfully!',
            'personal' => $personal,
            'parents' => $parents,
            'education' => $education,
            'registration' => $registration  // Return the registration data
        ], 201);
    }

    public function index()
    {
        $user = Auth::user();
        // $personal = Personal::where('user_id', $user->id)->get();
        // $parents = Parents::where('user_id', $user->id)->get();
        // $education = Education::where('user_id', $user->id)->get();
        $registrations = Registration::where('user_id', $user->id)->get();  // Fetch registration details

        return response()->json([
            // 'personal' => $personal,
            // 'parents' => $parents,
            // 'education' => $education,
            'registrations' => $registrations
        ]);
    }
}
