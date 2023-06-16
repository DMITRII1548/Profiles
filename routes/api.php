<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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

Route::middleware(['auth:sanctum', 'verified'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('user')->group(function () {
    Route::patch('/', [UserController::class, 'update']);
})->middleware(['auth:sanctum', 'verified']);

Route::prefix('profiles')->group(function () {
    Route::get('/show', [ProfileController::class, 'showProfileOfCurrentUser']);
    Route::get('/{profile}', [ProfileController::class, 'show']);
    Route::post('/', [ProfileController::class, 'store']);
})->middleware(['auth:sanctum', 'verified']);
