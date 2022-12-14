<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PositionController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('dashboard');
});

//Position
Route::resource('position',PositionController::class);

//Employee
Route::resource('employee',EmployeeController::class);
Route::post('add-employee',[EmployeeController::class, 'store']);
Route::put('update-employee',[EmployeeController::class, 'update']);
Route::get('status-employee/{id}',[EmployeeController::class, 'updateStatus'])->name('status.employee');
Route::get('hapus-employee/{id}',[EmployeeController::class, 'destroy'])->name('hapus.employee');
