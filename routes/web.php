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
Route::get('/events', [App\Http\Controllers\EventAdminController::class, 'index'])->name('events.index');
Route::get('/events/create', [App\Http\Controllers\EventAdminController::class, 'create'])->name('events.create');
Route::get('/events/{event}', [App\Http\Controllers\EventAdminController::class, 'show'])->name('events.show');
Route::get('/events/{event}/edit', [App\Http\Controllers\EventAdminController::class, 'edit'])->name('events.edit');
Route::put('/events/{event}', [App\Http\Controllers\EventAdminController::class, 'update'])->name('events.update');
Route::post('/events', [App\Http\Controllers\EventAdminController::class, 'store'])->name('events.store');
Route::get('/waypoints', [App\Http\Controllers\EventAdminController::class, 'getWaypointsForMap'])->name('events.getWaypointsForMap');


Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
Route::post('/users', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
Route::put('/users/{id}/admin', [App\Http\Controllers\UserController::class, 'beAdmin'])->name('users.be.admin');
Route::put('/users/{id}/quit-admin', [App\Http\Controllers\UserController::class, 'quitAdmin'])->name('users.quit.admin');
Route::delete('/users/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');


#endregion eventos
