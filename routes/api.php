<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

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

Route::post('/register', [RegisteredUserController::class, 'store']);

Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth:sanctum');

Route::get('/artists', [ArtistController::class, 'index'])->middleware('auth:sanctum');
Route::post('/create-artist',[ArtistController::class, 'store'])->middleware('auth:sanctum');
Route::put('/update-artist/{artist}',[ArtistController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/delete-artist/{artist}',[ArtistController::class,'destroy'])->middleware('auth:sanctum');

Route::get('/albums',[AlbumController::class, 'index'])->middleware('auth:sanctum');
Route::post('/create-album',[AlbumController::class, 'store'])->middleware('auth:sanctum');
Route::put('/update-album/{album}',[AlbumController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/delete-album/{album}',[AlbumController::class,'destroy'])->middleware('auth:sanctum');