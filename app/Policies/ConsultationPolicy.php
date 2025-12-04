<?php

namespace App\Policies;

use App\Models\Consultation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ConsultationPolicy
{
    /**
     * Memberikan izin super-admin sebelum method lain dicek.
     * Jika user adalah admin, ia langsung diizinkan melakukan apa saja.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->is_admin) {
            return true;
        }

        return null; // Lanjutkan ke pengecekan method di bawah jika bukan admin
    }

    /**
     * Tentukan apakah pengguna bisa melihat konsultasi.
     */
    public function view(User $user, Consultation $consultation): bool
    {
        return $user->id === $consultation->user_id;
    }

    /**
     * Tentukan apakah pengguna bisa membuat konsultasi.
     */
    public function create(User $user): bool
    {
        return true; // Semua user yang login boleh membuat konsultasi
    }

    /**
     * Tentukan apakah pengguna bisa mengupdate konsultasi.
     */
    public function update(User $user, Consultation $consultation): bool
    {
        return $user->id === $consultation->user_id;
    }

    /**
     * Tentukan apakah pengguna bisa menghapus konsultasi.
     */
    public function delete(User $user, Consultation $consultation): bool
    {
        return $user->id === $consultation->user_id;
    }
}
