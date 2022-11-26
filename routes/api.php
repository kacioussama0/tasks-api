<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login',[\App\Http\Controllers\UserController::class,'login']);
Route::post('register',[\App\Http\Controllers\UserController::class,'register']);


Route::middleware('auth:api')->prefix('user')->group(function () {

    Route::post('update/password',[\App\Http\Controllers\UserController::class,'passwordUpdate']);
    Route::post('update/profile',[\App\Http\Controllers\UserController::class,'profileUpdate']);
    Route::resource('categories',\App\Http\Controllers\CategoryController::class);
    Route::post('categories/{categoryId}/restore',[\App\Http\Controllers\CategoryController::class,'restore']);
    Route::post('categories/{categoryId}/force-delete',[\App\Http\Controllers\CategoryController::class,'forceDelete']);
    Route::get('category-trash',[\App\Http\Controllers\CategoryController::class,'deleted']);
    Route::resource('tasks',\App\Http\Controllers\TaskController::class);
    Route::post('tasks/{taskId}/restore',[\App\Http\Controllers\TaskController::class,'restore']);
    Route::post('tasks/{taskId}/force-delete',[\App\Http\Controllers\TaskController::class,'forceDelete']);
    Route::get('task-trash',[\App\Http\Controllers\TaskController::class,'deleted']);
    Route::resource('files',\App\Http\Controllers\FileController::class);
    Route::resource('comments',\App\Http\Controllers\CommentController::class);
});
