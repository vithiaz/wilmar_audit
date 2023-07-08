<?php

use App\Http\Livewire\Audit;
use App\Http\Livewire\LoginPage;
use App\Http\Livewire\UsersPage;
use App\Http\Livewire\CategoryPage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\AuditReportPage;


Route::get('/', LoginPage::class)->name('login');
Route::get('/logout', function () {
    Auth::logout();
    return redirect()->back();
})->name('logout');

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/kategori', CategoryPage::class)->name('categories');
    Route::get('/daftar-user', UsersPage::class)->name('users');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/audit', Audit::class)->name('audit');
    Route::get('/laporan', AuditReportPage::class)->name('audit-report');
});
