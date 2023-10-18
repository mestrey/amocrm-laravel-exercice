<?php

use App\Http\Middleware\AmoAuthentication;
use Illuminate\Support\Facades\Route;

Route::middleware(AmoAuthentication::class)->group(function () {
    Route::get('{any?}', function () {
        return view('home');
    })->where('any', '.*')->name('home');
});
