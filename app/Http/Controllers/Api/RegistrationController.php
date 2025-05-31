<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Build base query with relationships
        $query = Registration::with(['personalDetail', 'parentDetail', 'educationDetail', 'user', 'department']);

        // Apply filter if the user is NOT an admin
        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }

        // Get the registrations
        $registrations = $query->get();

        // Format image URLs
        foreach ($registrations as $registration) {
            if ($registration->personalDetail && $registration->personalDetail->picture) {
                $registration->personalDetail->picture = asset('storage/' . $registration->personalDetail->picture);
            }
            if ($registration->educationDetail && $registration->educationDetail->education_image) {
                $registration->educationDetail->education_image = asset('storage/' . $registration->educationDetail->education_image);
            }
        }

        return response()->json($registrations, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'department_id'   => 'required|exists:departments,id',
            'firstname'       => 'required|string',
            'lastname'        => 'required|string',
            'picture'         => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gender'          => 'required|in:male,female',
            'phonenumber'     => 'required|string',
            'fathername'      => 'required|string',
            'mothername'      => 'required|string',
            'education_name'  => 'required|string',
            'education_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $picturePath = $request->file('picture')->store('pictures', 'public');
            $educationImagePath = $request->file('education_image')->store('education_images', 'public');
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'File upload failed',
                'message' => $e->getMessage()
            ], 500);
        }

        $registration = Registration::create([
            'user_id'       => Auth::id(),
            'department_id' => $request->department_id,
        ]);

        $registration->personalDetail()->create([
            'firstname'   => $request->firstname,
            'lastname'    => $request->lastname,
            'picture'     => $picturePath,
            'gender'      => $request->gender,
            'dob'         => $request->dob,
            'address'     => $request->address,
            'phone'       => $request->phone,
            'phonenumber' => $request->phonenumber,
        ]);

        $registration->parentDetail()->create([
            'fathername'   => $request->fathername,
            'father_job'   => $request->father_job,
            'father_alive' => $request->father_alive,
            'mothername'   => $request->mothername,
            'mother_job'   => $request->mother_job,
            'mother_alive' => $request->mother_alive,
        ]);

        $registration->educationDetail()->create([
            'education_name'     => $request->education_name,
            'education_image'    => $educationImagePath,
            'education_date'     => $request->education_date,
            'education_location' => $request->education_location,
            'education_grade'    => $request->education_grade,
        ]);

        $registration->load(['personalDetail', 'parentDetail', 'educationDetail']);

        if ($registration->personalDetail && $registration->personalDetail->picture) {
            $registration->personalDetail->picture = asset('storage/' . $registration->personalDetail->picture);
        }

        if ($registration->educationDetail && $registration->educationDetail->education_image) {
            $registration->educationDetail->education_image = asset('storage/' . $registration->educationDetail->education_image);
        }

        return response()->json($registration, 201);
    }

    public function show($id)
    {
        $registration = Registration::with(['personalDetail', 'parentDetail', 'educationDetail', 'user', 'department'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($registration->personalDetail && $registration->personalDetail->picture) {
            $registration->personalDetail->picture = asset('storage/' . $registration->personalDetail->picture);
        }

        if ($registration->educationDetail && $registration->educationDetail->education_image) {
            $registration->educationDetail->education_image = asset('storage/' . $registration->educationDetail->education_image);
        }

        return response()->json($registration, 200);
    }

    public function update(Request $request, $id)
    {
        $registration = Registration::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $validator = Validator::make($request->all(), [
            'department_id'   => 'sometimes|exists:departments,id',
            'picture'         => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'education_image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $registration->update($request->only(['department_id']));

        try {
            if ($request->hasFile('picture')) {
                $picturePath = $request->file('picture')->store('pictures', 'public');
                $request->merge(['picture' => $picturePath]);
            }

            if ($request->hasFile('education_image')) {
                $educationImagePath = $request->file('education_image')->store('education_images', 'public');
                $request->merge(['education_image' => $educationImagePath]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'File upload failed',
                'message' => $e->getMessage()
            ], 500);
        }

        if ($registration->personalDetail) {
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
        }

        if ($registration->parentDetail) {
            $registration->parentDetail->update($request->only([
                'fathername',
                'father_job',
                'father_alive',
                'mothername',
                'mother_job',
                'mother_alive'
            ]));
        }

        if ($registration->educationDetail) {
            $registration->educationDetail->update($request->only([
                'education_name',
                'education_image',
                'education_date',
                'education_location',
                'education_grade'
            ]));
        }

        $registration->load(['personalDetail', 'parentDetail', 'educationDetail']);

        if ($registration->personalDetail && $registration->personalDetail->picture) {
            $registration->personalDetail->picture = asset('storage/' . $registration->personalDetail->picture);
        }

        if ($registration->educationDetail && $registration->educationDetail->education_image) {
            $registration->educationDetail->education_image = asset('storage/' . $registration->educationDetail->education_image);
        }

        return response()->json($registration, 200);
    }

    public function destroy($id)
    {
        $registration = Registration::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $registration->delete();

        return response()->json(null, 204);
    }
}
