<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Http;
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

// group middleware auth
Route::get('/login', [DashboardController::class, 'login'])->name("login")->middleware('guest');
Route::post('/login', [DashboardController::class, 'loginPost']);

Route::group(['middleware' => 'auth'], function () {
  Route::get('/', [DashboardController::class, 'dashboard']);
  Route::get('/kelola-laporan', [DashboardController::class, 'kelolaLaporan']);

  Route::post('/laporan/create', [DashboardController::class, 'tambahLaporan']);
  Route::delete('/laporan/delete', [DashboardController::class, 'hapusLaporan']);
});


Route::get('/tes', function () {
  return view('tes');
});
