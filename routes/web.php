<?php

use App\Http\Controllers\LeadController;
use App\Http\Middleware\AmoAuthentication;
use Illuminate\Support\Facades\Route;

Route::middleware(AmoAuthentication::class)->group(function () {
    Route::get('/{id?}', [LeadController::class, 'index'])->name('home');
    // Route::get('{any?}', function () {
    //     return view('home');
    // })->where('any', '.*')->name('home');
});
