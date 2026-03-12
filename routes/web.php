<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/producten', [ProductController::class, 'index'])->name('producten.index');
Route::get('/producten/specifiek/{id}', [ProductController::class, 'specifiek'])->name('producten.specifiek');
Route::get('/producten/store', [ProductController::class, 'store'])->name('producten.store');