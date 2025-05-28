<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        return response()->json(
            [
                'message' => 'Departments Retrieved successfully!',
                'departments' => $departments
            ]
        );
    }
}
