<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentImportController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/import', [DocumentImportController::class, 'showForm'])->name('document.import.form');
Route::post('/import', [DocumentImportController::class, 'import'])->name('document.import');
Route::post('/process-queue', [DocumentImportController::class, 'processQueue'])->name('queue.process');
