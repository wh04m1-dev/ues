<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{
    public function index()
    {
        $registrations = Registration::with(['personalDetail', 'parentDetail', 'educationDetail', 'user', 'department'])->get();
        return response()->json($registrations, 200);
    }

    public function store(Request $request)
    {
        // Validate main request
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'department_id' => 'required|exists:departments,id',

            'firstname' => 'required',
            'lastname' => 'required',
            'gender' => 'in:male,female',
            'phonenumber' => 'required',

            'fathername' => 'required',
            'mothername' => 'required',

            'education_name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Create registration
        $registration = Registration::create([
            'user_id' => $request->user_id,
            'department_id' => $request->department_id,
        ]);

        // Create related personal detail
        $registration->personalDetail()->create($request->only([
            'firstname',
            'lastname',
            'picture',
            'gender',
            'dob',
            'address',
            'phone',
            'phonenumber'
        ]));

        // Create related parent detail
        $registration->parentDetail()->create($request->only([
            'fathername',
            'father_job',
            'father_alive',
            'mothername',
            'mother_job',
            'mother_alive'
        ]));

        // Create related education detail
        $registration->educationDetail()->create($request->only([
            'education_name',
            'education_date',
            'education_location',
            'education_grade'
        ]));

        return response()->json($registration->load(['personalDetail', 'parentDetail', 'educationDetail']), 201);
    }

    public function show($id)
    {
        $registration = Registration::with(['personalDetail', 'parentDetail', 'educationDetail'])->findOrFail($id);
        return response()->json($registration, 200);
    }

    public function update(Request $request, $id)
    {
        $registration = Registration::findOrFail($id);
        $registration->update($request->only(['user_id', 'department_id']));

        $registration->personalDetail->update($request->only([
            'firstname',
            'lastname',
            'picture',
            'gender',
            'dob',
            'address',
            'phone',
            'phonenumber'
        ]));

        $registration->parentDetail->update($request->only([
            'fathername',
            'father_job',
            'father_alive',
            'mothername',
            'mother_job',
            'mother_alive'
        ]));

        $registration->educationDetail->update($request->only([
            'education_name',
            'education_date',
            'education_location',
            'education_grade'
        ]));

        return response()->json($registration->load(['personalDetail', 'parentDetail', 'educationDetail']), 200);
    }

    public function destroy($id)
    {
        $registration = Registration::findOrFail($id);
        $registration->delete(); // Related rows will cascade due to FK constraints
        return response()->json(null, 204);
    }
}
