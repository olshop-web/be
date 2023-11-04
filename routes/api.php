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



Route::get("/user/{idUser}/product", [UserController::class, 'userProduct']);
Route::get("/get/category", [CategoryController::class, 'getCategory']); 
Route::get("/get/product", [ProductController::class, 'getProduct']);
Route::get("/get/{idProduct}", [ProductController::class, 'detail']);

Route::post("/user/login", [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){
    Route::group(['prefix'=>'product'], function(){
        Route::post("/create", [ProductController::class, 'create']);
        Route::post("/update/{idProduct}", [ProductController::class, 'update']);
        Route::post("/delete/{idProduct}", [ProductController::class, 'delete']);
        Route::get("/{idProduct}", [ProductController::class, 'detail']);
        Route::group(['prefix'=>'{idProduct}/variant'], function(){
            Route::post("/create", [VariantController::class, 'create']); 
            Route::post("/delete/{idVariant}", [VariantController::class, 'delete']);
            Route::post("/update/{idVariant}", [VariantController::class, 'update']);
            Route::group(['prefix'=>'image'], function(){
                Route::post("/delete/{idVariantImage}", [VariantImageController::class, 'delete']);
            });
        });
        Route::group(['prefix'=>'category'], function(){
            Route::post("/create", [CategoryController::class, 'create']);
            Route::post("/update/{idCategory}", [CategoryController::class, 'updateCategory']);
            Route::post("/delete/{idCategory}", [CategoryController::class, 'delete']);
        });
    });
    Route::group(['prefix'=>'user'], function(){
        Route::get('/check', function (Request $request) {
            return $request->user();
        });
        Route::post("/register", [UserController::class, 'create']);
        Route::post("/update/{idUser}", [UserController::class, 'update']);
        Route::post("/logout", [UserController::class, 'logout']);
        Route::get("/verified")->middleware(['verified']);
    });
});

// Route::resouce(['get', 'post'], '/haha', [UserController::class, "check"]);