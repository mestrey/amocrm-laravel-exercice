<?php

use App\Http\Controllers\LeadController;
use App\Http\Controllers\TokenController;
use App\Http\Middleware\AmoAuthentication;
use Illuminate\Support\Facades\Route;

Route::get('token', [TokenController::class, 'handle']);

Route::middleware(AmoAuthentication::class)->group(function () {
    Route::resource('leads', LeadController::class, [
        'only' => ['index']
    ]);
});
