<?php

use App\Http\Controllers\QuoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Route::get('/user', function (Request $request) {
//     return 'Hello, World!';
// })->middleware('auth:sanctum');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('logout',[UserController::class,'logout']);
    Route::apiResource('quotes', QuoteController::class);
    
});

Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);

Route::get('/showQuote/{id}',[QuoteController::class,'showquote']);
Route::get('/randomQuote/{NombreQuotes}',[QuoteController::class,'randomQuote']);
Route::get('fliterQuotesNombreMot/{Nombre_max_mots}',[QuoteController::class,'fliterQuotesNombreMot']);
Route::get('getQuotePlusPopulaire',[QuoteController::class,'getQuotePlusPopulaire']);


// Route::get('/test',function(){
//     return 'hello world';
// });
