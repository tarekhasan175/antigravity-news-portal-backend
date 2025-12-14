<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ArticleController;

Route::prefix('v1')->group(function () {
    // Public Routes
    Route::post('/auth/login', [AuthController::class, 'login']);
    
    Route::get('/news/latest', [ArticleController::class, 'latest']);
    Route::get('/news/grouped', [CategoryController::class, 'newsWithCategories']);
    Route::get('/news/category/{slug}', [ArticleController::class, 'byCategory']);
    Route::get('/news/{slug}', [ArticleController::class, 'show']);
    Route::get('/categories', [CategoryController::class, 'index']);

    // Protected Routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/articles', [ArticleController::class, 'store']);
        Route::put('/articles/{id}', [ArticleController::class, 'update']);
        Route::delete('/articles/{id}', [ArticleController::class, 'destroy']);
        
        Route::post('/categories', [CategoryController::class, 'store']);
        
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
    });
});
