<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/task', [TaskController::class, 'index'])->name('task.index');
Route::post('/task', [TaskController::class, 'store'])->name('task.store');
Route::put('/task', [TaskController::class, 'update'])->name('task.update');
Route::post('/task/complete/{id}', [TaskController::class, 'complete'])->name('task.complete');
Route::delete('/task/{id}', [TaskController::class, 'destroy'])->name('task.destroy');