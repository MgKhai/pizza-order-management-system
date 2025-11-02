<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;

Route::group(['prefix'=>'user','middleware'=>'user'],function(){

    Route::get('/home',[UserController::class,'userHome'])->name('user#home');
    Route::get('/productDetails/{id}',[UserController::class,'productDetails'])->name('user#productDetails');

    // comment
    Route::group(['prefix'=>'comment'],function(){
        Route::post('/create',[UserController::class,'comment'])->name('user#comment');
        Route::get('/delete/{id}',[UserController::class,'commentDelete'])->name('user#commentDelete');
    });

    // rating
    Route::post('/rating',[UserController::class,'rating'])->name('user#rating');

    // profile
    Route::group(['prefix' => 'profile'],function(){

        Route::get('/edit',[UserController::class,'profileEditPage'])->name('user#profileEditPage');
        Route::post('/update',[UserController::class,'profileUpdate'])->name('user#profileUpdate');

        //password
        Route::get('/change/password',[UserController::class,'changePasswordPage'])->name('user#changePasswordPage');
        Route::post('/change/password',[UserController::class,'changePassword'])->name('user#changePassword');
    });

    // contact
    Route::get('/contact',[UserController::class,'contactPage'])->name('user#contactPage');
    Route::post('/contact',[UserController::class,'contact'])->name('user#contact');

    // cart
    Route::get('/cart',[UserController::class,'cartPage'])->name('user#cartPage');
    Route::get('/cart/create/{productId}',[UserController::class,'addToCartProductId'])->name('user#addToCartProductId');
    Route::post('/cart',[UserController::class,'addToCart'])->name('user#addToCart');
    Route::get('/cart/delete',[UserController::class,'cartDelete'])->name('user#cartDelete');

    // payment
    Route::get('/payment',[UserController::class,'paymentPage'])->name('user#paymentPage');

    // temporary cart storage
    Route::get('/tempStorage',[UserController::class,'tempStorage'])->name('user#tempStorage');

    // order
    Route::post('/order',[UserController::class,'order'])->name('user#order');

    // order list page
    Route::get('/order/list',[UserController::class,'orderListPage'])->name('user#orderListPage');
    Route::get('/order/details/{orderCode}',[UserController::class,'orderDetails'])->name('user#orderDetails');

});