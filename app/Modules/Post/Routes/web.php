<?php

use App\Modules\Post\Http\Controllers\Web\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/demo', [PostController::class, 'demo'])->name('posts.demo');
Route::resource('/posts', PostController::class);
