<?php

use App\Http\Controllers\ActivityController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ActivityController::class, 'index'])->name('activities.index');
Route::post('/activities', [ActivityController::class, 'store'])->name('activities.store');
Route::patch('/activities/{activity}/toggle', [ActivityController::class, 'toggle'])->name('activities.toggle');
Route::delete('/activities/{activity}', [ActivityController::class, 'destroy'])->name('activities.destroy');