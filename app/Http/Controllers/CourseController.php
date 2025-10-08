<?php

namespace App\Http\Controllers;

use App\Models\Courses;
use App\Models\CourseStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return response()->json([
                'data' => Courses::all(),
                'message' => 'Success',
                'status' => 200
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An unexpected error occurred. ' . $th->getMessage(),
                'status' => 500
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string', 'max:255'],

            ]);

            $validatedData['lecturer_id'] = Auth::user()->id;

            $data = Courses::create($validatedData);

            return response()->json([
                'message' => 'Success',
                'status' => 200,
                'data' => $data

            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An unexpected error occurred. ' . $th->getMessage(),
                'status' => 500
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        try {
            $validatedData = $request->validate([
                'name' => ['string', 'max:255'],
                'description' => ['string', 'max:255'],
            ]);

            $data = Courses::find($id);
            $data->update($validatedData);
            return response()->json([
                'message' => 'Success',
                'status' => 200,
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An unexpected error occurred. ' . $th->getMessage(),
                'status' => 500
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $data = Courses::find($id);
            $data->delete();
            return response()->json([
                'message' => 'Success',
                'status' => 200,
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An unexpected error occurred. ' . $th->getMessage(),
                'status' => 500
            ]);
        }
    }

    public function enroll(string $id)
    {
        try {
            $data = CourseStudent::create([
                'student_id' => Auth::user()->id,
                'course_id' => $id
            ]);

            return response()->json([
                'message' => 'Success',
                'status' => 200,
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An unexpected error occurred. ' . $th->getMessage(),
                'status' => 500
            ]);
        }
    }
}
