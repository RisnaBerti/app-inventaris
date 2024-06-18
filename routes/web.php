<?php

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

Route::middleware(['auth', 'web'])->group(function () {
    Route::get('/', fn () => view('dashboard'));
    Route::get('/dashboard', fn () => view('dashboard'));

    Route::get('/profile', App\Http\Controllers\ProfileController::class)->name('profile');

    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::resource('roles', App\Http\Controllers\RoleAndPermissionController::class);
});

Route::middleware(['auth', 'permission:test view'])->get('/tests', function () {
    dd('This is just a test and an example for permission and sidebar menu. You can remove this line on web.php, config/permission.php and config/generator.php');
})->name('tests.index');

Route::resource('barangs', App\Http\Controllers\BarangController::class)->middleware('auth');
Route::resource('ruangans', App\Http\Controllers\RuanganController::class)->middleware('auth');
Route::resource('transaks', App\Http\Controllers\TransakController::class)->middleware('auth');
Route::resource('pelaporans', App\Http\Controllers\PelaporanController::class)->middleware('auth');

Route::get('laporans', [App\Http\Controllers\LaporanController::class, 'index'])->name('laporans.index')->middleware('auth');
Route::get('laporans/print', [App\Http\Controllers\LaporanController::class, 'print'])->name('laporans.print')->middleware('auth');
Route::resource('pegawais', App\Http\Controllers\PegawaiController::class)->middleware('auth');