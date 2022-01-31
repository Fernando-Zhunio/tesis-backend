<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('auth')->group(function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signUp');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
});

Route::prefix('events')->group(function () {
    Route::get('', 'EventController@index');
    Route::get('/{id}', 'EventController@show');
    Route::post('/', 'EventController@store');
    Route::put('/{id}', 'EventController@update');
    Route::delete('/{id}', 'EventController@delete');
    Route::get('{event}/waypoints', [App\Http\Controllers\EventController::class, 'getWaypoints'])->name('events.waypoints');
});
