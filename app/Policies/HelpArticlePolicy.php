<?php

namespace App\Policies;

use App\Models\HelpArticle;
use App\Models\User;

class HelpArticlePolicy
{
    /**
     * Memberikan izin super-admin sebelum method lain dicek.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->is_admin) {
            return true; // Izinkan admin melakukan apa saja
        }
        return null; // Untuk user biasa, lanjutkan ke aturan di bawah
    }

    /**
     * Aturan default untuk pengguna biasa (non-admin).
     * Kita return false agar hanya admin (yang sudah lolos dari 'before') yang bisa.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }
    public function view(User $user, HelpArticle $helpArticle): bool
    {
        return false;
    }
    public function create(User $user): bool
    {
        return false;
    }
    public function update(User $user, HelpArticle $helpArticle): bool
    {
        return false;
    }
    public function delete(User $user, HelpArticle $helpArticle): bool
    {
        return false;
    }
}
