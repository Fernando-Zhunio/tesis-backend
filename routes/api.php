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

Route::get('home', 'HomeController@indexApi')->name('homeApi');

Route::get('/events', 'EventController@index');
Route::get('/events/favorites', 'EventController@getFavorite');
Route::get('/events/{event}', 'EventController@show');
Route::post('/events', 'EventController@store');
Route::put('/events/{id}', 'EventController@update');
Route::delete('/events/{id}', 'EventController@delete');
Route::get('/events/{event}/waypoints', 'EventController@getWaypointsForMap');
Route::post('/events/{event}/favorite', 'EventController@toggleFavorite');

