<?php

use App\Modules\Post\Http\Controllers\API\V1\PostApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/posts', [PostApiController::class, 'posts']);
});

