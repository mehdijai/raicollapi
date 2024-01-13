<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\PlaylistController;
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
// ! AUTH
Route::prefix("auth")->name("auth.")->middleware(['cors', 'json.response'])->group(function () {
    Route::post('/logout', [ApiAuthController::class, 'logout'])->name('logout')->middleware('auth:api');
    Route::post('/login', [ApiAuthController::class, 'login'])->name('login');
    Route::post('/register', [ApiAuthController::class, 'register'])->name('register');
});

// ! Tracks
Route::prefix("tracks")->name("tracks.")->middleware(['cors', 'json.response', "auth:api"])->group(function () {
    Route::get('/', [TrackController::class, "index"])->name('list');
    Route::get('/stream', [TrackController::class, "stream"])->name('stream');
    Route::get('/range-request', [TrackController::class, "streamRange"])->name("stream-range");
    Route::get('/metadata/{id}', [TrackController::class, "metadata"])->name('metadata')->whereUuid("id");
    Route::post('/', [TrackController::class, "create"])->name('create');
    Route::put('/{id}', [TrackController::class, "update"])->name('update')->whereUuid("id");
    Route::delete('/{id}', [TrackController::class, "delete"])->name('delete')->whereUuid("id");
});

// ! Artists
Route::prefix("artists")->name("artists.")->middleware(['cors', 'json.response', "auth:api"])->group(function () {
    Route::get('/', [ArtistController::class, "index"])->name('index');
    Route::get('/{id}', [ArtistController::class, "view"])->name('view')->whereUuid("id");
    Route::post('/create', [ArtistController::class, "create"])->name('create');
    Route::put('/{id}', [ArtistController::class, "update"])->name('update')->whereUuid("id");
    Route::delete('/{id}', [ArtistController::class, "delete"])->name('delete')->whereUuid("id");
});

// ! Albums
Route::prefix("albums")->name("albums.")->middleware(['cors', 'json.response', "auth:api"])->group(function () {
    Route::get('/', [AlbumController::class, "index"])->name('index');
    Route::get('/{id}', [AlbumController::class, "view"])->name('view')->whereUuid("id");
    Route::post('/create', [AlbumController::class, "create"])->name('create');
    Route::put('/{id}', [AlbumController::class, "update"])->name('update')->whereUuid("id");
    Route::delete('/{id}', [AlbumController::class, "delete"])->name('delete')->whereUuid("id");
});
// ! Playlists
Route::prefix("playlists")->name("playlists.")->middleware(['cors', 'json.response', "auth:api"])->group(function () {
    Route::get('/', [PlaylistController::class, "myPlaylists"])->name('myPlaylists');
    Route::get('/search', [PlaylistController::class, "index"])->name('index');
    Route::get('/{id}', [PlaylistController::class, "view"])->name('view')->whereUuid("id");
    Route::post('/create', [PlaylistController::class, "create"])->name('create');
    Route::put('/{id}', [PlaylistController::class, "update"])->name('update')->whereUuid("id");
    Route::delete('/{id}', [PlaylistController::class, "delete"])->name('delete')->whereUuid("id");
});
