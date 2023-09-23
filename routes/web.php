<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\PostController;
use Brick\Math\RoundingMode;
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

Route::get('/test', [PostController::class, 'test']);

Route::get('/user/reset-password/{token}', function () {
    return view('index');
})->name('password.reset');

Route::get('/{page}', IndexController::class)->where('page', '.*');
