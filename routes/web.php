<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialLoginController;

require_once __DIR__.'/admin.php';
require_once __DIR__.'/user.php';

Route::redirect('/', 'login');

Route::get('/dashboard', function () {
    return to_route('login');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// social login
Route::get('/auth/{provider}/redirect',[SocialLoginController::class,'redirect'])->name('sociallogin#redirect');
Route::get('/auth/{provider}/callback',[SocialLoginController::class,'callback'])->name('sociallogin#callback');

require __DIR__.'/auth.php';

