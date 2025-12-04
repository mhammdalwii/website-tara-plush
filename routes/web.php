<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes (Admin Only)
|--------------------------------------------------------------------------
|
| Semua akses ke halaman utama web akan dialihkan langsung ke
| Panel Admin Filament.
|
*/

Route::get('/', function () {
    return redirect('/admin');
});

// Redirect paksa jika ada link login nyasar
Route::get('/login', function () {
    return redirect('/admin/login');
})->name('login');
