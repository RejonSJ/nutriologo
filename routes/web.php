<?php

use App\Http\Controllers\CitasController;
use App\Http\Controllers\Admins\ClinicasController;
use App\Http\Controllers\Admins\UserController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

// Route::get('/home', function() {
//     return view('home');
// })->name('home')->middleware('auth');

Route::delete('admins/users/deleteUser/{id}', [UserController::class, 'deleteUser'])->name('admins.users.deleteUser');
Route::get('admins/users/switchRole', [UserController::class, 'switchRole'])->name('admins.users.switchRole');
Route::put('admins/users/switchClinica', [UserController::class, 'switchClinica'])->name('admins.users.switchClinica');
Route::resource('admins/users', UserController::class);

Route::get('admins/citas', [CitasController::class, 'administradores'])->name('admins.citas');
Route::get('doctores/citas', [CitasController::class, 'doctores'])->name('doctores.citas');
Route::post('citas/createcita', [CitasController::class, 'createcita'])->name('admins.citas.createcita');
Route::put('citas/updatecita', [CitasController::class, 'updatecita'])->name('admins.citas.updatecita');
Route::delete('citas/deletecita', [CitasController::class, 'deletecita'])->name('admins.citas.deletecita');

Route::resource('citas', CitasController::class);

Route::put('admins/clinicas/updateclinicas', [ClinicasController::class, 'updateclinicas'])->name('admins.clinicas.updateclinicas');
Route::delete('admins/clinicas/deleteclinicas/{id}', [ClinicasController::class, 'deleteclinicas'])->name('admins.clinicas.deleteclinicas');
Route::post('admins/clinicas/createclinicas', [ClinicasController::class, 'createclinicas'])->name('admins.clinicas.createclinicas');
Route::resource('admins/clinicas',ClinicasController::class);