<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;

Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
Route::get('/chat/fetch', [ChatController::class, 'fetch'])->name('chat.fetch');
Route::get('/chat/fetch-ai', [ChatController::class, 'fetchAI'])->name('chat.fetch-ai');
Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');
