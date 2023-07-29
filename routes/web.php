<?php

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

Auth::routes(['register' => false]);

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

Route::middleware(['is.admin'])->group(function () {
    Route::get('/all-user', [App\Http\Controllers\UserController::class, 'index'])->name('all.user');
    Route::get('/add-user', [App\Http\Controllers\UserController::class, 'create'])->name('add.user');
    Route::get('/edit-user/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('edit.user');
    Route::post('/create-user', [App\Http\Controllers\UserController::class, 'store'])->name('create.user');
    Route::post('/update-user', [App\Http\Controllers\UserController::class, 'update'])->name('update.user');
    Route::delete('/users/{id}', [App\Http\Controllers\UserController::class, 'deleteUser'])->name('users.delete');
    Route::post('/toggle-active', [App\Http\Controllers\UserController::class, 'toggleActive'])->name('users.toggleActive');

});