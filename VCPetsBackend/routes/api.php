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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('categories', 'App\Http\Controllers\CategoryController');
Route::resource('tags', 'App\Http\Controllers\TagController');
Route::resource('pets', 'App\Http\Controllers\PetController');

Route::get('pets/findByStatus/{status}', [\App\Http\Controllers\PetController::class, 'findByStatus'])->name("findByStatus");
