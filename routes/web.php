<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\ChangePasswordController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', HomeController::class);
Route::get('/user/change-password', ChangePasswordController::class)->middleware(['auth', 'verified'])->name('user.change.password');
Route::post('/user/change-password/update', [ChangePasswordController::class, 'save'])->middleware(['auth', 'verified'])->name('user.change.password.save');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
