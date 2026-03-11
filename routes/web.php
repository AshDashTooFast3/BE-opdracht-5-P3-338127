<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/producten', [ProductController::class, 'index'])->name('producten.index');
Route::get('/producten/specifiek', [ProductController::class, 'specifiek'])->name('producten.specifiek');
