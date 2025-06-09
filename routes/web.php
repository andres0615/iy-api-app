<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;

Route::get('/', function (Request $request) {

    $props = [];

    if($request->has('success')) {
        $props['success'] = $request->input('success');
    }

    return Inertia::render('Tasks', $props);
});

Route::get('/task/create', [TaskController::class, 'create'])->name('task.create');
Route::get('/task/edit/{id}', [TaskController::class, 'edit'])->name('task.edit');

require __DIR__.'/auth.php';
