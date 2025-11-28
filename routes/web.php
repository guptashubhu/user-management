<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ShortUrlController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::get('/{shortCode}', [ShortUrlController::class, 'redirect'])->where('shortCode', '[a-zA-Z0-9]{6}')->name('url.redirect');
Route::get('export-url', [ShortUrlController::class, 'export'])->name('export.url');

Route::middleware('guest')->group(function () {
    Route::get('login',[AuthController::class,'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // all short URLs
    Route::resource('urls', ShortUrlController::class)->except(['edit', 'update']);

    // all invitation URLs
    Route::middleware('role:super_admin,admin')->group(function () {
        Route::resource('invitations', InvitationController::class)->only(['index', 'create', 'store']);
    });

    // all compnies URLs
    Route::middleware('role:super_admin')->group(function () {
        Route::resource('companies', CompanyController::class)->only(['index', 'create', 'store']);
    });

});
