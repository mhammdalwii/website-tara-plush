<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $messages = [
            'name.required' => 'Nama wajib diisi.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.unique' => 'Nomor telepon ini sudah terdaftar, silakan gunakan nomor lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ];

        try {

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'date_of_birth' => 'required|date_format:Y-m-d',
                'gender' => 'required|string',
                'address' => 'required|string|max:255',
            ], $messages);

            $user = User::create([
                'name' => $validatedData['name'],
                'phone' => $validatedData['phone'],
                'password' => Hash::make($validatedData['password']),
                'date_of_birth' => $validatedData['date_of_birth'] ?? null,
                'gender' => $validatedData['gender'] ?? null,
                'address' => $validatedData['address'] ?? null,
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ], 201);
        } catch (ValidationException $e) { // <-- AKHIRI DENGAN BLOK CATCH
            return response()->json([
                'message' => 'Data yang diberikan tidak valid.',
                'errors' => $e->errors(), // Ini akan berisi pesan error spesifik
            ], 422);
        }
    }

    public function login(Request $request)
    {
        if (!Auth::attempt(['phone' => $request->phone, 'password' => $request->password])) {
            return response()->json(['message' => 'Login gagal, No. Telepon atau Password salah'], 401);
        }

        $user = User::where('phone', $request['phone'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }
}
