<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\MovieController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    $locale = app()->getLocale();
    app()->setLocale($locale);

    return redirect()->route('login', $locale);
});


Route::group([
    'prefix' => '{locale}',
    'where' => ['locale' => 'en|id'],
    'middleware' => ['setlocale']
], function () {

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.process');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/movies', [MovieController::class, 'index'])->name('movies')->middleware('auth');
    Route::get('/movies/search', [MovieController::class, 'search'])->name('movies.search')->middleware('auth');
    Route::get('/movies/favorites', [MovieController::class, 'showFavorites'])->name('movies.favorites')->middleware('auth');

    Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.show')->middleware('auth');



    Route::post('/movies/{id}/favorites', [MovieController::class, 'addToFavorites'])->name('movies.addFavorite')->middleware('auth');
    Route::delete(
        '/movies/{id}/favorites',
        [MovieController::class, 'removeFromFavorites']
    )->name('movies.removeFavorite')->middleware('auth');
});
