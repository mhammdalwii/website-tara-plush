<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Http\Resources\UserResource;

class ProfileController extends Controller
{
    /**
     * Menampilkan data user yang sedang login.
     */
    public function show(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();
        return new UserResource($user);
    }

    /**
     * Mengupdate data user yang sedang login.
     */
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'phone' => ['sometimes', 'string', 'max:15', Rule::unique('users')->ignore($user->id)],
            'date_of_birth' => 'sometimes|date',
            'gender' => 'sometimes|string|in:Laki-laki,Perempuan',
            'address' => 'sometimes|string',
            'profile_photo' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $validatedData['profile_photo_path'] = $path;
        }

        $user->update($validatedData);

        return response()->json([
            'message' => 'Profil berhasil diperbarui!',
            'user' => new UserResource($user->fresh())
        ]);
    }

    /**
     * Ganti password user yang sedang login.
     */
    public function changePassword(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        $validated = $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
            // pastikan request kirim field: new_password_confirmation juga
        ]);

        // cek password lama
        if (!Hash::check($validated['current_password'], $user->password)) {
            return response()->json([
                'message' => 'Password lama salah.'
            ], 401);
        }

        // update password baru
        $user->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        // opsional: revoke semua token lama supaya login ulang
        $user->tokens()->delete();

        return response()->json([
            'message' => 'Password berhasil diperbarui. Silakan login ulang.'
        ]);
    }
}
