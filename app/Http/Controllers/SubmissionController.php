<?php

namespace App\Http\Controllers;

use App\Models\Submissions;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;



class SubmissionController extends Controller
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
                'assignment_id' => ['required', 'integer', 'exists:assignments,id'],
                'file' => ['required', 'file', 'max:10240', 'mimes:pdf,doc,docx,zip'],
            ]);

            $assignmentId = $validatedData['assignment_id'];
            $studentId = $request->user()->id;

            $existingSubmission = Submissions::where('assignment_id', $assignmentId)
                ->where('student_id', $studentId)
                ->first();

            if ($existingSubmission) {
                return response()->json([
                    'message' => 'Anda sudah mengunggah jawaban untuk tugas ini. Silakan gunakan endpoint update jika ingin mengubahnya.',
                    'status' => 409
                ], 409);
            }

            $filePath = null;
            if ($request->hasFile('file')) {
                $folder = 'submissions/' . $assignmentId . '/' . $studentId;
                $filePath = $request->file('file')->store($folder, 'public');
            }

            $submission = Submissions::create([
                'assignment_id' => $assignmentId,
                'student_id' => $studentId,
                'file_path' => $filePath,
            ]);

            return response()->json([
                'message' => 'Jawaban berhasil diunggah.',
                'submission' => $submission,
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

    public function grade(Request $request, $id)
    {

        try {
            $validatedData = $request->validate([
                'score' => ['required', 'integer', 'min:0', 'max:100'],
            ]);

            $submission = Submissions::findOrFail($id);

            $submission->update([
                'score' => $validatedData['score']
            ]);

            return response()->json([
                'message' => 'Nilai berhasil diberikan.',
                'submission' => $submission,
                'status' => 200
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Submission dengan ID ' . $id . ' tidak ditemukan.',
                'status' => 404
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Gagal memberikan nilai karena validasi input.',
                'errors' => $e->errors(),
                'status' => 422
            ], 422);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server saat memproses pemberian nilai.',
                'status' => 500
            ], 500);
        }
    }
}
