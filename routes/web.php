<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MinervaController;
use App\Http\Controllers\MinervaLaController;
use App\Http\Controllers\MinervaOverlayController;

Route::get('/', [MinervaController::class, 'index'])->name('minerva.home');


Route::get('/minerva', [MinervaController::class, 'index'])->name('minerva');
Route::get('/minerva-la', [MinervaLaController::class, 'index'])->name('minerva-la');

Route::get('/minerva-overley', [MinervaOverlayController::class, 'index'])->name('minerva-overley');
