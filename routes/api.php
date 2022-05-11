<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [ApiController::class, 'login']);
    Route::post('/register', [ApiController::class, 'register']);
    Route::post('/logout', [ApiController::class, 'logout']);
    Route::post('/refresh', [ApiController::class, 'refresh']);
    Route::get('/user-profile', [ApiController::class, 'userProfile']);
});
Route::group(['middleware' => 'jwt.verify' , 'namespace' => 'Api'], function () {
    Route::get('users', [UserController::class,'index']);
    Route::post('users', [UserController::class,'store']);
    Route::get('user/{id}', [UserController::class,'show']);
    Route::post('user/{id}',[UserController::class,'update']);
    Route::post('/user/{id}',[UserController::class,'destroy']);
 Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{id}', [ProductController::class, 'show']);
    Route::post('create', [ProductController::class, 'store']);
    Route::put('update/{product}',  [ProductController::class, 'update']);
    Route::delete('delete/{product}',  [ProductController::class, 'destroy']);
    // Route::post('categories',[CategoryController::class,'index']);
});
