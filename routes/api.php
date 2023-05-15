<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;

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

Route::get('/images', [ImageController::class, 'index'])->withoutMiddleware("throttle:api");
Route::get('/products/{id}/images', [ImageController::class, 'showByProductId']);

Route::get('/images/{id}', [ImageController::class, 'showByImageId']);
Route::post('/store', [ImageController::class, 'store']);
Route::delete('/images/{id}', [ImageController::class, 'deleteByImageId']);

Route::delete('/products/{id}/images', [ImageController::class, 'deleteByProductId']);