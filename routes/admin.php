<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AddonItemController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProfileController;

Route::group(['prefix'=>'admin','middleware'=>'admin'],function(){

    Route::get('/home',[AdminController::class,'adminDashboard'])->name('admin#home');

    //category
    Route::group(['prefix'=>'category'],function(){

        Route::get('/list',[CategoryController::class,'listPage'])->name('category#list');
        Route::post('create',[CategoryController::class,'create'])->name('category#create');
        Route::get('/delete/{id}',[CategoryController::class,'delete'])->name('category#delete');
        Route::get('/edit/{id}',[CategoryController::class,'editPage'])->name('category#edit');
        Route::post('/update/{id}',[CategoryController::class,'update'])->name('category#update');

    });

    //product
    Route::group(['prefix'=>'product'],function(){

        Route::get('/create',[ProductController::class,'createPage'])->name('product#createpage');
        Route::post('/create',[ProductController::class,'create'])->name('product#create');
        Route::get('/list/{action?}',[ProductController::class,'list'])->name('product#list');
        Route::get('/delete/{id}',[ProductController::class,'delete'])->name('product#delete');
        Route::get('/edit/{id}',[ProductController::class,'editPage'])->name('product#edit');
        Route::post('/update',[ProductController::class,'update'])->name('product#update');
        Route::get('/detail/{id}',[ProductController::class,'detailPage'])->name('product#detail');

    });

    // profile
    Route::group(['prefix' => 'profile'],function(){

        Route::get('/change/password',[ProfileController::class,'changePasswordPage'])->name('profile#changePasswordPage');
        Route::post('/change/password',[ProfileController::class,'changePassword'])->name('profile#changePassword');

        Route::get('/edit',[ProfileController::class,'editProfilePage'])->name('profile#editProfilePage');
        Route::post('/update',[ProfileController::class,'updateProfile'])->name('profile#updateProfile');

    });

    // pizza size
    Route::group(['prefix' => '/pizza/size'],function(){

        Route::get('/list',[SizeController::class,'listPage'])->name('size#listPage');
        Route::post('/create',[SizeController::class,'create'])->name('size#create');
        Route::get('/delete/{id}',[SizeController::class,'delete'])->name('size#delete');
        Route::get('/edit/{id}',[SizeController::class,'editPage'])->name('size#editPage');
        Route::post('/update',[SizeController::class,'update'])->name('size#update');

    });

    // add-on items
    Route::group(['prefix'=>'item'],function(){

        Route::get('/list',[AddonItemController::class,'listPage'])->name('item#listPage');
        Route::post('/create',[AddonItemController::class,'create'])->name('item#create');
        Route::get('/delete/{id}',[AddonItemController::class,'delete'])->name('item#delete');
        Route::get('/edit/{id}',[AddonItemController::class,'editPage'])->name('item#editPage');
        Route::post('/update',[AddonItemController::class,'update'])->name('item#update');

    });

    Route::group(['middleware' => 'superadmin'],function(){

        // payment
        Route::group(['prefix' => 'payment'],function(){

            Route::get('/list',[PaymentController::class,'listPage'])->name('payment#listPage');
            Route::post('/create',[PaymentController::class,'create'])->name('payment#create');
            Route::get('/delete/{id}',[PaymentController::class,'delete'])->name('payment#delete');
            Route::get('/edit/{id}',[PaymentController::class,'editPage'])->name('payment#editPage');
            Route::post('/update',[PaymentController::class,'update'])->name('payment#update');

        });

        // account
        Route::group(['prefix' => 'account'],function(){

            // admin
            Route::get('/create/new/admin',[AdminController::class,'createAdminPage'])->name('account#createAdminPage');
            Route::post('/create/new/admin',[AdminController::class,'createAdmin'])->name('account#createAdmin');

            Route::get('/adminlist',[AdminController::class,'adminListPage'])->name('account#adminListPage');
            Route::get('/adminlist/delete/{id}',[AdminController::class,'adminListDelete'])->name('account#adminListDelete');

            // user
            Route::get('/userlist',[AdminController::class,'userListPage'])->name('account#userListPage');
            Route::get('/userlist/delete/{id}',[AdminController::class,'userListDelete'])->name('account#userListDelete');

        });
    });

    // order
    Route::group(['prefix' => 'order'],function(){

        Route::get('/list',[OrderController::class,'orderListPage'])->name('admin#orderListPage');
        Route::get('/details/{orderCode}',[OrderController::class,'orderDetails'])->name('admin#orderDetails');

        Route::get('/confirm',[OrderController::class,'orderConfirm'])->name('admin#orderConfirm');
        Route::get('/reject',[OrderController::class,'orderReject'])->name('admin#orderReject');

        Route::get('/status/change',[OrderController::class,'orderStatusChange'])->name('admin#orderStatusChange');

        //delete
        Route::get('/delete/{orderCode}',[OrderController::class,'orderDelete'])->name('admin#orderDelete');

    });

    // sales information
    Route::group(['prefix' => 'sales'],function(){

        Route::get('/info',[OrderController::class,'salesInfoPage'])->name('admin#salesInfoPage');
        Route::get('/info/details/{orderCode}',[OrderController::class,'salesInfoDetails'])->name('admin#salesInfoDetails');
    });
});