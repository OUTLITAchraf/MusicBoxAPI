<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\SongController;
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
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/artists', [ArtistController::class, 'index']);
    Route::get('/artist/{artist}', [ArtistController::class, 'show']);
    Route::post('/create-artist', [ArtistController::class, 'store']);
    Route::put('/update-artist/{artist}', [ArtistController::class, 'update']);
    Route::delete('/delete-artist/{artist}', [ArtistController::class, 'destroy']);

    Route::get('/albums', [AlbumController::class, 'index']);
    Route::get('/album/{album}', [AlbumController::class, 'show']);
    Route::post('/create-album', [AlbumController::class, 'store']);
    Route::put('/update-album/{album}', [AlbumController::class, 'update']);
    Route::delete('/delete-album/{album}', [AlbumController::class, 'destroy']);

    Route::get('/songs', [SongController::class, 'index']);
    Route::get('/song/{song}', [SongController::class, 'show']);
    Route::get('/songs/search', [SongController::class, 'search']);
    Route::post('/create-song', [SongController::class, 'store']);
    Route::put('/update-song/{song}', [SongController::class, 'update']);
    Route::delete('/delete-song/{song}', [SongController::class, 'destroy']);

});
