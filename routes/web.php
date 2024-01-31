<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::any('/payslip/{id}', [HomeController::class, 'index2']);

Route::any('/payslips/entry', [HomeController::class, 'payslipEntry'])->middleware(['auth'])->name('dashboard');;

Route::any('/', [HomeController::class, 'index'])
    ->middleware(['auth'])->name('dashboard');
Route::any('dashboard', [HomeController::class, 'index'])
    ->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

require __DIR__.'/app.php';

require __DIR__.'/module.php';
