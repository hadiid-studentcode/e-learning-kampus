<?php

namespace App\Http\Controllers;

use App\Models\Materials;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MaterialController extends Controller
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
                'file' => ['required', 'file', 'max:10240', 'mimes:pdf,doc,docx,ppt,pptx,zip'],
            ]);

            $filePath = null;

            if ($request->hasFile('file')) {
                $folder = 'course_materials/' . $validatedData['course_id'];
                $filePath = $request->file('file')->store($folder, 'public');
            }

            $material = Materials::create([
                'course_id' => $validatedData['course_id'],
                'title' => $validatedData['title'],
                'file_path' => $filePath,
            ]);

            return response()->json([
                'message' => 'Materi berhasil diunggah.',
                'material' => $material,
                'file_url' => asset('storage/' . $filePath),
                'status' => 201
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Gagal mengunggah karena validasi input.',
                'errors' => $e->errors(),
                'status' => 422
            ], 422);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server saat memproses unggahan.',
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
