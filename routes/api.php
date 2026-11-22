<?php

use App\Http\Controllers\MediaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ->parameters() wajib: Laravel menganggap bentuk singular dari "media" adalah "medium",
// jadi tanpa ini route model binding `Media $media` tidak akan jalan.
Route::apiResource('media', MediaController::class)->parameters(['media' => 'media']);

// Users & koleksi (custom action)
Route::get('users', [UserController::class, 'index']);
Route::get('users/{user}', [UserController::class, 'show']);
Route::get('users/{user}/collection', [UserController::class, 'collection']);
Route::post('users/{user}/collection', [UserController::class, 'addToCollection']);
Route::delete('users/{user}/collection/{media}', [UserController::class, 'removeFromCollection']);
