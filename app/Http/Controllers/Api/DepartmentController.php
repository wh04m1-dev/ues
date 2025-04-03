<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    //
    public function store(Request $request){
        if (Auth::user()->role_id !== 1) { 
            return response()->json(['error' => 'Unauthorized'], 403); // Unauthorized if not an admin
        }
        
        $request->validate([
            'name' => 'required|unique:departments,name|max:255',
            'image' => 'nullable|mimes:jpeg,jpg,png|max:2048',
        ]);

       $department = new Department();
       $department->name = $request->name;
       if ($request->hasFile('image')) {
        $department->image = $request->file('image')->store('departments', 'public'); // Store image in 'public/pictures'
    }
       $department->save();


        return response()->json([
            'message' => 'Department created successfully!',
            'department' => $department
        ], 201);
    }


    public function index()
    {
        $departments = Department::all();
        return response()->json( [
            'message' => 'Departments Retrieved successfully!',
            'departments' => $departments ]
        );
    }

    public function update(Request $request, $id)
    {
        $department = Department::find($id);
    
        if (!$department) {
            return response()->json(['error' => 'Department not found'], 404);
        }
    
        // Adjusted validation for unique name (exclude current department)
        $request->validate([
            'name' => 'required|unique:departments,name,' . $id . '|max:255',  // Unique check with exclusion of current department
            'image' => 'nullable|mimes:jpeg,jpg,png|max:2048',
        ]);
    
        $department->name = $request->name;
    
        if ($request->hasFile('image')) {
            $department->image = $request->file('image')->store('departments', 'public');
        }
    
        $department->save();
    
        return response()->json([
            'message' => 'Department updated successfully!',
            'department' => $department
        ], 200);
    }



    public function destroy($id)
{

    $department = Department::find($id);

    if (!$department) {
        return response()->json(['error' => 'Department not found'], 404);
    }

    $department->delete();
    return response()->json([
        'message' => 'Department deleted successfully!'
    ], 200);
}

    

}
