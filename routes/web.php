<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/users', [UserController::class, 'index'])->name('users');
Route::get('/filter-users', [UserController::class, 'filter'])->name('filter-users');
Route::get('/user/{user}', [UserController::class, 'edit'])->name('user.edit');
Route::put('/user/setrole/{user}', [UserController::class, 'assignRole'])->name('user.setrole');
Route::put('/user/deleterole/{user}', [UserController::class, 'deleteRole'])->name('user.deleterole');


require __DIR__.'/auth.php';
