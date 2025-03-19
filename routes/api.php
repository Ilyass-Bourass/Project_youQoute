<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\TagController;
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

    Route::post('/addLike/{id_quote}',[LikeController::class,'addLike']);
    Route::post('/deleteLike/{id_quote}',[LikeController::class,'deleteLike']);
        
    Route::middleware('role:admin')->group(function () {
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('tags', TagController::class);
    });

    Route::middleware('role:user')->group(function(){
        Route::get('testUser',function(){
            return response()->json(['message'=>'testUser']);
        });
    });
    Route::post('logout',[UserController::class,'logout']);
    Route::apiResource('quotes', QuoteController::class);
    
});

Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);

Route::get('/showQuote/{id}',[QuoteController::class,'showquote']);
Route::get('/randomQuote/{NombreQuotes}',[QuoteController::class,'randomQuote']);
Route::get('fliterQuotesNombreMot/{Nombre_max_mots}',[QuoteController::class,'fliterQuotesNombreMot']);
Route::get('getQuotesPlusPopulaire',[QuoteController::class,'getQuotesPlusPopulaire']);



// Route::get('/test',function(){
//     return 'hello world';
// });
