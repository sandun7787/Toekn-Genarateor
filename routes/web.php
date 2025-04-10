<?php
use App\Http\Controllers\TokenController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TokenController::class, 'index']);
Route::post('/print-token', [TokenController::class, 'printToken'])->name('print.token');
