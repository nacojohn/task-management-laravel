<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('tasks');
});

Route::post('tasks/reorder', [TaskController::class, 'reorder'])->name('tasks.reorder');
Route::resource('tasks', TaskController::class);
