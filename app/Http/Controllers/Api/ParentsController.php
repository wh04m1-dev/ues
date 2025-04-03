<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Parents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ParentsController extends Controller
{

    public function index()
    {
        $parents = Parents::all();  // Changed from Parent to ParentModel

        return response()->json([
            'parents' => $parents
        ]);
    }

    //
    public function store(Request $request)
{
    // Validate incoming request
    $request->validate([
        'fathername' => 'required|string|max:255',
        'job' => 'nullable|string|max:255',
        'father_alive' => 'required|boolean',
        'mothername' => 'required|string|max:255',
        'mother_job' => 'nullable|string|max:255',
        'mother_alive' => 'required|boolean',
        'phonenumber' => 'required|string|max:20',
    ]);

    // Get the authenticated user
    $user = Auth::user();

  
    $parent = Parents::create([
        'user_id' => $user->id,
        'fathername' => $request->fathername,
        'job' => $request->job,
        'father_alive' => $request->father_alive,
        'mothername' => $request->mothername,
        'mother_job' => $request->mother_job,
        'mother_alive' => $request->mother_alive,
        'phonenumber' => $request->phonenumber,
    ]);

    
    return response()->json([
        'message' => 'Parent record created successfully!',
        'parent' => $parent
    ], 201);
}


}
