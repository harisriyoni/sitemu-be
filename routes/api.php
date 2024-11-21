<?php

use App\Http\Controllers\OrganisasiController;
use App\Http\Controllers\TypegaleriController;
use App\Http\Controllers\UserController;
use App\Models\Organisasi;
use Illuminate\Support\Facades\Route;


Route::post('/users/login', [UserController::class, 'login']);
Route::get('/home/typegaleri', [TypegaleriController::class, 'get']);
Route::get('/home/organisasi', [OrganisasiController::class, 'get']);


Route::middleware('auth:api')->group(function () {
    Route::post('/users/logout', [UserController::class, 'logout']);
    Route::post('/users/refresh', [UserController::class, 'refresh']);
    Route::post('/users/profile', [UserController::class, 'me']);
    // Type Galeri
    Route::post('/dashboard/typegaleri', [TypegaleriController::class, 'store']);
    Route::get('/dashboard/typegaleri', [TypegaleriController::class, 'get']);
    Route::get('/dashboard/typegaleri/{id}', [TypegaleriController::class, 'getid'])->where('{id}', '[0-9]+');
    Route::put('/dashboard/typegaleri/{id}', [TypegaleriController::class, 'update'])->where('{id}', '[0-9]+');
    Route::delete('/dashboard/typegaleri/{id}', [TypegaleriController::class, 'delete'])->where('{id}', '[0-9]+');
    // Organisasi
    Route::post('/dashboard/organisasi', [OrganisasiController::class, 'create']);
    Route::get('/dashboard/organisasi', [OrganisasiController::class, 'get']);
    Route::get('/dashboard/organisasi/{id}', [OrganisasiController::class, 'getid'])->where('{id}', '[0-9]+');
    Route::delete('/dashboard/organisasi/{id}', [OrganisasiController::class, 'delete'])->where('{id}', '[0-9]+');
    Route::post('/dashboard/organisasi/{id}', [OrganisasiController::class, 'update'])->where('{id}', '[0-9]+');
});
