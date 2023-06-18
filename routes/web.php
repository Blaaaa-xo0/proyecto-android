<?php

use App\Http\Controllers\MapaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
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

Route::get('/dashboard', [MapaController::class, 'index']
)->middleware(['auth', 'verified'])->name('dashboard');

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

Route::get('/roles', [RoleController::class, 'index'])->name('roles');
Route::get('/role/{role}', [RoleController::class, 'editRole'])->name('role.edit');
Route::put('role/update/{role}', [RoleController::class, 'updateRole'])->name('role.update');

Route::post('map/store', [MapaController::class, 'store'])->name('map.store');
Route::put('map/update/{mapa}', [MapaController::class, 'update'])->name('map.update');
Route::delete('map/{mapa}', [MapaController::class, 'destroy'])->name('map.destroy');


require __DIR__.'/auth.php';
