<?php

use App\Http\Controllers\Api\Category\Controller as CategoryController;
use App\Http\Controllers\Api\Genre\Controller as GenreController;
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

Route::resource('categories', CategoryController::class, ['except' => ['create', 'edit']]);
Route::resource('genre', GenreController::class, ['except' => ['create', 'edit']]);
