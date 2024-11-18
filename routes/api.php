<?php

use App\Http\Controllers\Auth\MobileAuthController;
use App\Http\Controllers\NoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/user/create', [MobileAuthController::class, 'create'])->name('user.create');
Route::post('/token', [MobileAuthController::class, 'token'])->name('token');

Route::middleware('auth:sanctum')->get('/notes', [NoteController::class, 'notes']);
Route::middleware('auth:sanctum')->get('/notes/{noteId}', [NoteController::class, 'note']);
Route::middleware('auth:sanctum')->post('/notes/create', [NoteController::class, 'create']);
Route::middleware('auth:sanctum')->delete('/notes/{noteId}', [NoteController::class, 'delete']);
