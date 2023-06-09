<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::prefix('projects')->name('projects.')->group(function () {
    Route::get('/create', [ProjectController::class, 'create'])->name('create');
    Route::post('/create', [ProjectController::class, 'store'])->name('store');
    Route::get('/{project:id}', [ProjectController::class, 'edit'])->name('edit');
    Route::put('/{project}', [ProjectController::class, 'update'])->name('update');
    Route::delete('/{project}', [ProjectController::class, 'delete'])->name('delete');
});

Route::prefix('tasks')->name('tasks.')->group(function () {
    Route::put('/update-priorities', [TaskController::class, 'updatePriorities'])->name('updatePriorities');

    Route::get('/create', [TaskController::class, 'create'])->name('create');
    Route::post('/create', [TaskController::class, 'store'])->name('store');
    Route::get('/{task:id}', [TaskController::class, 'edit'])->name('edit');
    Route::put('/{task}', [TaskController::class, 'update'])->name('update');
    Route::delete('/{task}', [TaskController::class, 'delete'])->name('delete');
});
