<?php

use App\Http\Controllers\DecisionController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/decisions', [DecisionController::class, 'index'])->name('decisions.index');
    Route::get('/decisions/create', [DecisionController::class, 'create'])->name('decisions.create');
    Route::post('/decisions', [DecisionController::class, 'store'])->name('decisions.store');
});

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
