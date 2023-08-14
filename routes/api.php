<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('categories', 'App\Http\Controllers\Api\CategoryController@index');
Route::get('articles', 'App\Http\Controllers\Api\ArticleController@index');
Route::get('articles/category/{category_id}', 'App\Http\Controllers\Api\ArticleController@getByCategory');
Route::get('articles/slug/{slug}', 'App\Http\Controllers\Api\ArticleController@getBySlug');
