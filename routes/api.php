<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\VariantController;
use App\Http\Controllers\Product\CategoryController;
use App\Http\Controllers\Product\VariantImageController;
use App\Http\Controllers\User\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['prefix'=>'product'], function(){
    Route::get("/get", [ProductController::class, 'getProduct']);
    Route::get("/get/{idProduct}", [ProductController::class, 'detail']);
    Route::post("/create", [ProductController::class, 'create'])->middleware('auth.middleware');
    Route::post("/update/{idProduct}", [ProductController::class, 'update'])->middleware('auth.middleware');
    Route::post("/delete/{idProduct}", [ProductController::class, 'delete'])->middleware('auth.middleware');
    Route::group(['prefix'=>'{idProduct}/variant'], function(){
        Route::post("/create", [VariantController::class, 'create']); 
        Route::post("/delete/{idVariant}", [VariantController::class, 'delete'])->middleware('auth.middleware');
        Route::post("/update/{idVariant}", [VariantController::class, 'update'])->middleware('auth.middleware');
        Route::group(['prefix'=>'image'], function(){
            Route::post("/delete/{idVariantImage}", [VariantImageController::class, 'delete'])->middleware('auth.middleware');
        });
    });
    Route::group(['prefix'=>'category'], function(){
        Route::get("/get", [CategoryController::class, 'getCategory']); 
        Route::post("/create", [CategoryController::class, 'create'])->middleware('auth.middleware');
        Route::post("/update/{idCategory}", [CategoryController::class, 'updateCategory'])->middleware('auth.middleware'); 
        Route::post("/delete/{idCategory}", [CategoryController::class, 'delete'])->middleware('auth.middleware');
    });
});
Route::group(['prefix'=>'user'], function(){
    Route::get("/product/{id}", [UserController::class, 'userProduct']);
    Route::post("/login", [UserController::class, 'login'])->middleware('web');
    Route::post("/create", [UserController::class, 'create'])->middleware('auth.middleware');
    Route::post("/update/{idUser}", [UserController::class, 'update'])->middleware('auth.middleware');
    Route::post("/logout", [UserController::class, 'update'])->middleware('auth.middleware');
    Route::get("/verified")->middleware(['verified', 'auth.middleware']);
});

