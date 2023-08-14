<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ArticleController;

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

Route::get('/register', [RegisterController::class, 'create'])
    ->name('register');

Route::post('/register', [RegisterController::class, 'register']);

Route::get('login', [LoginController::class, 'create'])
    ->name('login');

Route::post('login', [LoginController::class, 'authenticate']);

Route::post('/logout', [Logoutcontroller::class, 'destroy'])
    ->middleware('auth')->name('logout');

Route::get('users', [UserController::class, 'index'])
    ->middleware(['can:manage-users', 'auth'])->name('users.index');

Route::get('categories', [CategoryController::class, 'index'])
    ->middleware(['can:manage-users', 'auth'])->name('categories.index');

Route::get('articles', [ArticleController::class, 'index'])
    ->middleware(['can:manage-users', 'auth'])->name('articles.index');

Route::get('articles/{slug}', [ArticleController::class, 'show'])
    ->middleware(['can:manage-users', 'auth'])->name('articles.show');
