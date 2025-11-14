<?php

use App\Modules\Tag\Http\Controllers\API\V1\TagApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/tags', [TagApiController::class, 'tags']);
});
