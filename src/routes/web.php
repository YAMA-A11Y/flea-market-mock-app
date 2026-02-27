<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\StripeCheckoutController;

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

Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();        
        return back()->with('status', 'verification-link-sent');
    })->middleware('throttle:6,1')->name('verification.send');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->route('profile.edit')->with('verified', true);
    })->middleware('signed')->name('verification.verify');
    
    Route::get('/sell', [ItemController::class, 'create'])->name('items.sell');
    Route::post('/sell', [ItemController::class, 'store'])->name('items.sell.store');

    Route::post('/item/{item_id}/like', [ItemController::class, 'toggleLike'])->name('items.like');
    Route::post('/item/{item_id}/comment', [ItemController::class, 'storeComment'])->name('items.comment');

    Route::get('/purchase/{item_id}', [ItemController::class, 'purchase'])->name('items.purchase');
    Route::post('/purchase/{item_id}', [ItemController::class, 'purchaseStore'])->name('items.purchase.store');

    Route::get('/purchase/address/{item_id}', [ItemController::class, 'editAddress'])->name('purchase.address.edit');
    Route::patch('/purchase/address/{item_id}', [ItemController::class, 'updateAddress'])->name('purchase.address.update');

    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage');
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');
});