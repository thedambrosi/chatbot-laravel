<?php

use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');
Route::view('/login', 'auth.login')->name('login');

Route::get('/chat', function () {
    return 'Login funcionou! Olá, ' . auth()->user()->name;
})->middleware('auth')->name('chat');
