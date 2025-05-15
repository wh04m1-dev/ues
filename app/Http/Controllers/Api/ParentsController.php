<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Parents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParentsController extends Controller
{
    // GET /api/parents — list all
    public function index()
    {
        return response()->json([
            'parents' => Parents::all()
        ]);
    }

    // GET /api/parents/{id} — show one
    public function show($id)
    {
        $parent = parents::find($id);

        if (!$parent) {
            return response()->json(['message' => 'Parent record not found'], 404);
        }

        return response()->json(['parent' => $parent]);
    }

    // POST /api/parents — create
    public function store(Request $request)
    {
        $request->validate([
            'fathername' => 'required|string|max:255',
            'job' => 'nullable|string|max:255',
            'father_alive' => 'required|boolean',
            'mothername' => 'required|string|max:255',
            'mother_job' => 'nullable|string|max:255',
            'mother_alive' => 'required|boolean',
            'phonenumber' => 'required|string|max:20',
        ]);

        $parent = parents::create([
            'user_id' => Auth::id(),
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

    // PUT /api/parents/{id} — update
    public function update(Request $request, $id)
    {
        $parent = parents::find($id);

        if (!$parent) {
            return response()->json(['message' => 'Parent record not found'], 404);
        }

        $request->validate([
            'fathername' => 'sometimes|required|string|max:255',
            'job' => 'nullable|string|max:255',
            'father_alive' => 'sometimes|required|boolean',
            'mothername' => 'sometimes|required|string|max:255',
            'mother_job' => 'nullable|string|max:255',
            'mother_alive' => 'sometimes|required|boolean',
            'phonenumber' => 'sometimes|required|string|max:20',
        ]);

        $parent->update($request->all());

        return response()->json([
            'message' => 'Parent record updated successfully!',
            'parent' => $parent
        ]);
    }

    // DELETE /api/parents/{id} — delete
    public function destroy($id)
    {
        $parent = parents::find($id);

        if (!$parent) {
            return response()->json(['message' => 'Parent record not found'], 404);
        }

        $parent->delete();

        return response()->json(['message' => 'Parent record deleted successfully']);
    }
}
