<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\UserController;
use App\Http\Livewire\AbsenAll;
use App\Http\Livewire\UserMgmt;
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

Route::get('/',[AuthController::class,'index'])->name('index');
Route::post('proseslogin', [AuthController::class,'login'])->name('login');
Route::get('logout',[AuthController::class,'logout'])->name('logout');

Route::group(['middleware' => ['auth']], function(){
    Route::group(['middleware' => ['cekrole:admin']], function(){
        Route::post('admin/prosesabsen', [AdminController::class,'absen'])->name('absen');
        Route::get('admin/usermgmt', UserMgmt::class)->name('usermgmt');
        Route::get('admin', AbsenAll::class)->name('indexadmin');
    });
    Route::group(['middleware' => ['cekrole:user']], function(){
        Route::get('user', [UserController::class,'index'])->name('indexuser');
    });
});
