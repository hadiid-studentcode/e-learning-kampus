<?php

namespace App\Http\Controllers;

use App\Models\Assignments;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
                'course_id' => ['required', 'integer', 'exists:courses,id'],
                'title' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string'],
                'deadline' => ['required', 'date_format:Y-m-d H:i:s', 'after:now'],
            ]);

            $assignment = Assignments::create($validatedData);

            return response()->json([
                'message' => 'Tugas berhasil dibuat.',
                'assignment' => $assignment,
                'status' => 201
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Gagal membuat tugas karena validasi input.',
                'errors' => $e->errors(),
                'status' => 422
            ], 422);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server saat menyimpan data.',
                'status' => 500
            ], 500);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
