<?php

use App\Modules\Tag\Http\Controllers\Web\TagController;
use Illuminate\Support\Facades\Route;

Route::get('/tags', [TagController::class, 'index'])->name('tags.index');
Route::resource('tags', TagController::class)->except('show', 'edit', 'update');
