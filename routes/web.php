<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\PlaylistGeneratorController;
use App\Http\Controllers\PlaylistController;

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
Auth::routes(['register' => FALSE]);

Route::get('/', [PlaylistController::class, 'index'])->name('home');
Route::get('/download/{id}', [FileController::class, 'download'])->name('files.download');
Route::get('/delete/{id}', [PlaylistController::class, 'delete'])->name('playlist.delete');

Route::group(['prefix' => 'songs'], function() {
    Route::get('/', [
        'uses' => SongController::class . '@index',
        'as' => 'songs'
    ]);
    Route::get('/add', [
        'uses' => SongController::class . '@addForm',
        'as' => 'songs.add'
    ]);
    Route::post('/create', [
        'uses' => SongController::class . '@post',
        'as' => 'songs.post'
    ]);
    Route::get('/edit/{id}', [
        'uses' => SongController::class . '@editForm',
        'as' => 'songs.edit'
    ]);
    Route::post('/update/{id}', [
        'uses' => SongController::class . '@patch',
        'as' => 'songs.update'
    ]);
    Route::get('/delete/{id}', [
        'uses' => SongController::class . '@delete',
        'as' => 'songs.delete'
    ]);
});

Route::group(['prefix' => 'generate'], function() {
    Route::get('/', [
        'uses' => PlaylistGeneratorController::class . '@playlistLayout',
        'as' => 'playlist-layout'
    ]);
    Route::post('/randomize', [
        'uses' => PlaylistGeneratorController::class . '@randomize',
        'as' => 'playlist-randomize'
    ]);
    Route::post('/export', [
        'uses' => PlaylistGeneratorController::class . '@export',
        'as' => 'playlist-export'
    ]);
});
Route::group(['prefix' => 'playlist'], function() {
    Route::get('/edit/{id}', [
        'uses' => PlaylistController::class . '@editForm',
        'as' => 'playlist-edit'
    ]);
    Route::post('/save', [
        'uses' => PlaylistController::class . '@save',
        'as' => 'playlist-save'
    ]);
});
