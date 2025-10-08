<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'role' => ['required', 'string', 'in:dosen,mahasiswa'],
            ]);

            $validatedData['password'] = Hash::make($validatedData['password']);

            $user = User::create($validatedData);


            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'user' => $user,
                'role' => $user->roles()->first(),
                'token' => $token,
                'message' => 'User successfully registered.',
                'status' => 201
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
                'status' => 422
            ], 422);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An unexpected error occurred. ' . $th->getMessage(),
                'status' => 500
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'message' => 'Kredensial tidak valid (Email atau Password salah).',
                    'status' => 401
                ], 401);
            }

            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'user' => $user,
                'role' => $user->roles()->first(),
                'token' => $token,
                'message' => 'Login berhasil.',
                'status' => 200
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $e->errors(),
                'status' => 422
            ], 422);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan tak terduga.',
                'status' => 500
            ], 500);
        }
    }
    public function logout(Request $request)
    {

        try {
            $request->user()->tokens()->delete();

            return response()->json([
                'message' => 'User successfully logged out.',
                'status' => 200
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An unexpected error occurred. ' . $th->getMessage(),
                'status' => 500
            ], 500);
        }
    }
}
