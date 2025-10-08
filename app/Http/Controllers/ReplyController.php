<?php

namespace App\Http\Controllers;

use App\Models\Discussions;
use App\Models\Replies;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ReplyController extends Controller
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
    public function store(Request $request, $discussionId)
    {
        try {
            $validatedData = $request->validate([
                'content' => ['required', 'string'],
            ]);

           
            $reply = Replies::create([
                'discussion_id' => $discussionId,
                'user_id' => $request->user()->id,
                'content' => $validatedData['content'],
            ]);

            return response()->json([
                'message' => 'Balasan berhasil dikirim.',
                'reply' => $reply,
                'status' => 201
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Gagal mengirim balasan karena validasi input.',
                'errors' => $e->errors(),
                'status' => 422
            ], 422);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan server saat menyimpan balasan.'.$th->getMessage(),
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
