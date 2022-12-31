<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;


Route::middleware('auth:sanctum')->group( function () {
    Route::resource('articles', ArticleController::class);
});
