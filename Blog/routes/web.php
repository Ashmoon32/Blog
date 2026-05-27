<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\CommentController;

Route::get('/', [ArticleController::class, 'index']);

Route::get('/articles', [ArticleController::class, 'index']);

Route::get('/articles/detail/{id}', [
    ArticleController::class,
    'detail'
]);

Route::get('/products', [ProductController::class, 'index']);

Route::get('/articles/info/{boldText}', [ArticleController::class, 'info']);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/articles/add', [ArticleController::class, 'add']);

Route::post('/articles/add', [ArticleController::class, 'create']);

Route::get('/articles/delete/{id}', [ArticleController::class, 'delete'])->middleware('auth');

Route::post('/comments/add', [CommentController::class, 'create']);

Route::get('/comments/delete/{id}', [CommentController::class, 'delete'])->middleware('auth');

Route::get('/comments/edit/{id}', [CommentController::class, 'edit'])->middleware('auth');

Route::put('/comments/update/{id}', [CommentController::class, 'update'])->middleware('auth');

Route::get('/articles/edit/{id}', [ArticleController::class, 'edit'])->middleware('auth');

Route::put('/articles/update/{id}', [ArticleController::class, 'update'])->middleware('auth');

Route::get('/articles/add', [ArticleController::class, 'add'])->middleware('auth');
