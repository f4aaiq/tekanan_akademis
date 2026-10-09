<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Nanti kalau halaman quiz sudah dibuat, tambahkan:
// Route::get('/quiz', [QuizController::class, 'index'])->name('quiz.index');