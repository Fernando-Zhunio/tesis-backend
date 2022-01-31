<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect()->route('home');
});

// Auth::routes();
Route::get('/login',[App\Http\Controllers\Auth\LoginController::class,'showLoginForm'])->name('show-login');
Route::post('/login',[App\Http\Controllers\Auth\LoginController::class,'login'])->name('login');
Route::post('/logout',[App\Http\Controllers\Auth\LoginController::class,'logout'])->name('logout');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

#region eventos
Route::get('/events', [App\Http\Controllers\EventController::class, 'indexOnlyAdmins'])->name('events.index');
Route::get('/events/create', [App\Http\Controllers\EventController::class, 'create'])->name('events.create');
Route::get('/events/{event}/edit', [App\Http\Controllers\EventController::class, 'edit'])->name('events.edit');
Route::put('/events/{event}', [App\Http\Controllers\EventController::class, 'update'])->name('events.update');
Route::post('/events', [App\Http\Controllers\EventController::class, 'store'])->name('events.store');

#endregion eventos