<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\PageController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/quiz', [QuizController::class, 'index'])->name('quiz.index');
Route::post('/quiz', [QuizController::class, 'store'])->name('quiz.store');
Route::get('/hasil/{token}', [QuizController::class, 'result'])->name('quiz.result');
Route::get('/tips', [PageController::class, 'tips'])->name('tips');
Route::get('/bantuan', [PageController::class, 'bantuan'])->name('bantuan');
Route::get('/kartu', [PageController::class, 'kartu'])->name('kartu');