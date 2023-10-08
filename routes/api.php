<?php

use App\Modules\Auth\Http\Controllers\AuthController;
use App\Modules\Blog\Http\Controllers\BlogController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/me', [AuthController::class, 'me'])->name('me');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::post('/blog/store', [BlogController::class, 'store'])->name('blog.store');
    Route::post('/blog/update', [BlogController::class, 'update'])->name('blog.update');
    Route::post('/blog/delete', [BlogController::class, 'delete'])->name('blog.delete');
});

Route::post('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog', [BlogController::class, 'show'])->name('blog.show');
