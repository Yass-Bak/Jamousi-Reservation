<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\ActeurController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProducerController;

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
Route::middleware('api')->group(function () {
    Route::resource('producers', ProducerController::class);
});

Route::middleware('api')->group(function () {
    Route::resource('acteurs', ActeurController::class);
});
Route::middleware('api')->group(function () {
    Route::resource('films', FilmController::class);
});
Route::get('/film/{idprod}',
[FilmController::class,'showFilmByProd']);
Route::middleware('api')->group(function ($router) {
    Route::post('/createpayment', [PaymentController::class,'createPaymentIntent']);
});
