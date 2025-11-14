<?php

use App\Modules\Post\Http\Controllers\API\V1\PostApiController;
use Illuminate\Support\Facades\Route;

Route::get('/posts', [PostApiController::class, 'posts']);
