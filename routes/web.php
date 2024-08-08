<?php

use App\Http\Controllers\ClasseController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Student_taskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

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
    return view('login');
})->name('home');

Route::view('/login', "login")->name('login');
Route::get('/registro', [LoginController::class, 'showRegisterForm'])->name('registro');
Route::post('/validar-registro', [LoginController::class, 'register'])->name('validar-registro');
Route::post('/iniciar-sesion', [LoginController::class, 'login'])->name('iniciar-sesion');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/tasks/chart-data', [TaskController::class, 'getTasksByClass']);
Route::resource('/Calificar', Student_taskController::class)->middleware('auth');
Route::resource('/classes', ClasseController::class)->middleware('auth');
Route::patch('/classes/restore/{id_class}', [ClasseController::class, 'restore'])->name('classes.restore');
Route::resource('/courses', CourseController::class)->middleware('auth');
Route::resource('/tasks', TaskController::class)->middleware('auth');
Route::resource('/entrega', TaskController::class)->middleware('auth');
Route::patch('/tasks/{task}/entregar', [TaskController::class, 'entregar'])->name('tasks.entregar');

