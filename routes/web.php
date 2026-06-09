<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\ApplicationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('applications.index')
        : redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', fn() => redirect()->route('applications.index'))->name('dashboard');
    Route::resource('applications', ApplicationController::class)->except([]);
    Route::post('applications/{application}/logs', [ActivityLogController::class, 'store'])->name('logs.store');
    Route::delete('logs/{activityLog}', [ActivityLogController::class, 'destroy'])->name('logs.destroy');
});

require __DIR__.'/auth.php';