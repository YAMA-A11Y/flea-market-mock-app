<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MypageController;

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

Route::get('/sell', [ItemController::class, 'create'])
    ->middleware('auth')
    ->name('items.sell');

Route::post('/sell', [ItemController::class, 'store'])
    ->middleware('auth')
    ->name('items.sell.store');

Route::post('/item/{item_id}/like', [ItemController::class, 'toggleLike'])
    ->middleware('auth')
    ->name('items.like');

Route::post('/item/{item_id}/comment', [ItemController::class, 'storeComment'])
    ->middleware('auth')
    ->name('items.comment');

Route::middleware(['auth'])->group(function () {
    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage');
    Route::get('/mypage/profile', [ProfileController::class, 'edit']);
    Route::post('/mypage/profile', [ProfileController::class, 'update']);
});

Route::get('/purchase/{item_id}', [ItemController::class, 'purchase'])
    ->middleware('auth')
    ->name('items.purchase');

Route::post('/purchase/{item_id}', [ItemController::class, 'purchaseStore'])
    ->middleware('auth')
    ->name('items.purchase.store');

Route::get('/purchase/address/{item_id}', [ItemController::class, 'editAddress'])
    ->middleware('auth')
    ->name('purchase.address.edit');

Route::patch('/purchase/address/{item_id}', [ItemController::class, 'updateAddress'])
    ->middleware('auth')
    ->name('purchase.address.update');

Route::middleware(['auth', 'profile'])->group(function () {
    //あとで
});