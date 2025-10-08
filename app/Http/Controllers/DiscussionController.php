<?php

namespace App\Http\Controllers;

use App\Models\Discussions;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DiscussionController extends Controller
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
                'content' => ['required', 'string'],
            ]);

            $discussion = Discussions::create([
                'course_id' => $validatedData['course_id'],
                'user_id' => $request->user()->id,
                'content' => $validatedData['content'],
            ]);

            return response()->json([
                'message' => 'Diskusi berhasil dibuat.',
                'discussion' => $discussion,
                'status' => 201
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Gagal membuat diskusi karena validasi input.',
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
