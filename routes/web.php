<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use App\Http\Controllers\MateriasController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/maestros', [MateriasController::class, 'Show'])->middleware(['auth', 'verified'])->name('maestros');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /* Create mastros */
    Route::post('/addmateria', [MateriasController::class, 'Addmateria'])->name('add.materia');
    Route::get('/editmaestros/{id}', [MateriasController::class, 'EditMateria'])->name('edit.materia');
    Route::delete('/deletemaestros', [MateriasController::class, 'DeleteMateria'])->name('delete.materia');

});

require __DIR__.'/auth.php';
