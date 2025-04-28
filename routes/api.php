<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

Route::delete('/categories/delete-all', [CategoryController::class, 'destroyAll'])->name('categories.delete-all');
Route::resource('categories', CategoryController::class)->except('show');
