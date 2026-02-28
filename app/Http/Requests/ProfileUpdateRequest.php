<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth; // Pastikan ini ditambahkan

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function authorize(): bool
    {
        return true; // pastikan user yang login bisa akses
    }

    public function rules(): array
    {
        // Dapatkan user yang sedang login untuk mendapatkan ID-nya
        $user = Auth::user();
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'phone' => ['sometimes', 'string', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'gender' => ['sometimes', 'string', 'in:Laki-laki,Perempuan'],
            'date_of_birth' => ['sometimes', 'date'],
            'address' => ['sometimes', 'string'],
            'profile_photo' => ['sometimes', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }
}
