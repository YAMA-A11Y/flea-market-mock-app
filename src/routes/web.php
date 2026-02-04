<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;

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

Route::get('/', [ItemController::class, 'index'])->name('items.index');

Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('items.show');

Route::post('/item/{item_id}/like', [ItemController::class, 'toggleLike'])
    ->middleware('auth')
    ->name('items.like');

Route::post('/item/{item_id}/comment', [ItemController::class, 'storeComment'])
    ->middleware('auth')
    ->name('items.comment');

Route::middleware(['auth'])->group(function () {
    Route::get('/mypage/profile', [ProfileController::class, 'edit']);
    Route::post('/mypage/profile', [ProfileController::class, 'update']);
});

Route::get('/purchase/{item_id}', [ItemController::class, 'purchase'])
    ->middleware('auth')
    ->name('items.purchase');

Route::middleware(['auth', 'profile'])->group(function () {
    //あとで
});

