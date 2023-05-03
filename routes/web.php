<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\Management\PekerjaanController;
use App\Http\Controllers\Management\JenisPekerjaanController;

use App\Http\Controllers\Freelance\PekerjaanController as PekerjaanFreelance;

use App\Http\Controllers\Penjadwalan\PekerjaanController as PekerjaanPenjadwalan;
use  App\Http\Controllers\Penjadwalan\LemburController as LemburPenjadwalan;



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

Route::get('auth', [AuthController::class, 'index'])->name('auth');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'checkauth'], function () {

    Route::get('/', function () {
        if (session('role') == 'management') {
            return redirect()->route('management.pekerjaan.index');
        } else if (session('role') == 'penjadwalan') {
            return redirect()->route('penjadwalan.pekerjaan.index');
        } else if (session('role') == 'freelance') {
            return redirect()->route('freelance.pekerjaan.index');
        } else if (session('role') == 'lembur') {
            return redirect()->route('lembur.pekerjaan.index');
        } else {
            // return redirect('http://127.0.0.1:8000/');
            return redirect()->route('penjadwalan.lembur.index');
        }
    });

    //role management
    Route::group(['middleware' => 'role:management', 'prefix' => 'management', 'as' => 'management.'], function () {

        Route::resource('pekerjaan', PekerjaanController::class);
        Route::resource('jenis-pekerjaan', JenisPekerjaanController::class);
    });

    //role freelance
    Route::group(['middleware' => 'role:freelance', 'prefix' => 'freelance', 'as' => 'freelance.'], function () {

        Route::resource('pekerjaan', PekerjaanFreelance::class);
    });

    //role penjadwalan
    Route::group(['middleware' => 'role:penjadwalan', 'prefix' => 'penjadwalan', 'as' => 'penjadwalan.'], function () {

        Route::resource('pekerjaan', PekerjaanPenjadwalan::class);
        Route::resource('lembur', LemburPenjadwalan::class);
    });
});
