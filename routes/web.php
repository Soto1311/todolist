<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstadosController;
use App\Http\Controllers\TareasController;

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

Route::get('/estados', [EstadosController::class, 'index'])->name('estados');
Route::post('/estados', [EstadosController::class, 'getEstados'])->name('getestados');

Route::get('/tareas', [TareasController::class, 'index'])->name('tareas');
Route::post('/savetarea', [TareasController::class, 'save'])->name('savetarea');
Route::get('/tareas/{id}', [TareasController::class, 'edit'])->name('edittarea');
Route::put('/tareas/{id}', [TareasController::class, 'update'])->name('updatetarea');
Route::post('/deletetarea/{id}', [TareasController::class, 'delete'])->name('deleteTarea');

Route::get('/exportcsv', [TareasController::class, 'exportCsv'])->name('exportcsv');
