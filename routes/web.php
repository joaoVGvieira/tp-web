<?php

use App\Http\Controllers\BooksController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

// Welcome Page
Route::get('/', function () {
    return view('welcome');
});

// BooksController
Route::get('/livros', [BooksController::class, 'index']);
Route::get('/livros/criar', [BooksController::class, 'create'])->middleware('auth');
Route::post('/livros', [BooksController::class, 'store'])->middleware('auth');
Route::get('/livros/{id}', [BooksController::class, 'show']);

// ReservationCotroller
Route::get('/dashboard', [ReservationController::class, 'dashboard'])->middleware('auth');
Route::get('/livros/reserva/{id}', [ReservationController::class, 'create'])->middleware('auth');
Route::post('/livros/reserva', [ReservationController::class, 'store'])->middleware('auth');
Route::match(['get', 'post'], '/livros/devolver/{id}', [ReservationController::class, 'returnBook'])->name('books.return');
Route::get('/test-return-book/{id}', [ReservationController::class, 'returnBook']);
Route::get('/livros/{id}/edit', [BooksController::class, 'edit'])->name('books.edit');
Route::put('/livros/{id}', [BooksController::class, 'update'])->name('books.update');
