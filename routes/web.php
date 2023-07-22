<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Livewire\Admin\DataSiswa;
use App\Http\Livewire\Admin\Index as AdminIndex;
use App\Http\Livewire\Admin\Manajemen;
use App\Http\Livewire\Kurikulum\KelasMgmt;
use App\Http\Livewire\Admin\Log;
use App\Http\Livewire\Kurikulum\Jurusan;
use App\Http\Livewire\Piket\AbsenAll;
use App\Http\Livewire\Piket\History;
use App\Http\Livewire\Piket\Persentase;
use App\Http\Livewire\Admin\UserMgmt;
use App\Http\Livewire\Kurikulum\Agenda;
use App\Http\Livewire\Piket\HistorySiswa;
use App\Http\Livewire\Piket\PersentaseSiswa;
use App\Http\Livewire\Siswa\Index;
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
Route::any('proseslogin', [AuthController::class,'login'])->name('login');
Route::get('logout',[AuthController::class,'logout'])->name('logout');

Route::get('/ubahmode/bataraindra2020',[AdminController::class,'ubahmode'])->name('ubahmode');
Route::get('export/{bln?}/{jbtn?}', [AdminController::class, 'export'])->name('export');

//absen siswa
Route::get('/absensiswa/{norfid}/bataraindra2020', [AdminController::class, 'absenSiswa'])->name('absensiswafix');

// Input RFID
Route::get('/inputscan', [AdminController::class, 'inputformrfid'])->name('inputscan');
Route::get('/inputrfid/{norfid}/bataraindra2020',[AdminController::class,'inputrfid'])->name('inputrfid');

//RFID MODE POIN
Route::get('poin/{norfid}/bataraindra2020', [AdminController::class, 'poinrfid'])->name('poinrfid');
Route::get('poinscan', [AdminController::class, 'poinscan'])->name('poinscan');

//RFID Top Up
Route::get('/topuprfid/{norfid}/bataraindra2020', [AdminController::class, 'topuprfid'])->name('topuprfid');
Route::get('/topup', [AdminController::class, 'topup'])->name('topup');


Route::group(['middleware' => ['auth']], function(){
    Route::get('/global/ubahpassword',[AdminController::class,'ubahPassword'])->name('ubahpassword');
    Route::any('/admin/updatepassword',[AdminController::class,'updatePassword'])->name('updatepassword');

    Route::group(['middleware' => ['cekrole:admin']], function(){
        Route::get('admin', AdminIndex::class)->name('indexadmin');
        Route::get('admin/persentase', Persentase::class)->name('persentase');
        Route::get('admin/persentasesiswa', PersentaseSiswa::class)->name('persentasesiswa');
        Route::get('admin/history', History::class)->name('history');
        Route::get('admin/historysiswa', HistorySiswa::class)->name('historysiswa');
        Route::get('admin/usermgmt', UserMgmt::class)->name('usermgmt');
        Route::get('admin/kelasmgmt', KelasMgmt::class)->name('kelasmgmt');
        Route::get('admin/jurusan', Jurusan::class)->name('jurusan');
        Route::get('admin/absenkaryawan', AbsenAll::class)->name('absenkaryawan');
        Route::get('admin/agenda', Agenda::class)->name('agendamgmt');
        Route::get('admin/datasiswa', DataSiswa::class)->name('datasiswa');
        Route::get('admin/manajemen', Manajemen::class)->name('manajemen');

        //Top Up RFID
        Route::get('/admin/topupform',[AdminController::class,'topupform'])->name('topupform');
        Route::any('/admin/topupproses',[AdminController::class,'topupProses'])->name('topupproses');

        //controller add siswa
        Route::get('/admin/addsiswa',[AdminController::class,'addSiswa'])->name('addsiswa');
        Route::get('/admin/editsiswa/{id}',[AdminController::class,'editSiswa'])->name('editsiswa');
        Route::any('/admin/insertsiswa',[AdminController::class,'insertSiswa'])->name('insertsiswa');
        Route::any('/admin/updatesiswa',[AdminController::class,'updateSiswa'])->name('updatesiswa');

        Route::get('/admin/poin',[AdminController::class,'poin'])->name('poin');

        //Log
        Route::get('admin/log', Log::class)->name('log');
        
        
    });
    Route::group(['middleware' => ['cekrole:piket']], function(){
        Route::get('piket', AbsenAll::class)->name('indexpiket');
        Route::get('piket/usermgmt', UserMgmt::class)->name('usermgmtpiket');
        Route::get('piket/history', History::class)->name('historypiket');
        Route::get('piket/persentase', Persentase::class)->name('persentasepiket');
        Route::get('piket/export/{bln?}/{jbtn?}', [AdminController::class, 'export'])->name('exportpiket');
    
        //Absen RFID
    Route::get('/piket/absensiswa',[AdminController::class,'absen'])->name('absensiswapiket');
        //Data Siswa
    Route::get('piket/datasiswa', DataSiswa::class)->name('datasiswapiket');
        //Livewire Absen Siswa
    Route::get('piket/persentasesiswa', PersentaseSiswa::class)->name('persentasesiswapiket');
    Route::get('piket/historysiswa', HistorySiswa::class)->name('historysiswapiket');
    
    });
    Route::group(['middleware' => ['cekrole:user']], function(){
        Route::get('user', [UserController::class,'index'])->name('indexuser');
        Route::post('user/ayoabsen', [UserController::class,'ayoAbsen'])->name('ayoabsen');
        Route::get('user/history', History::class)->name('userhistory');
        Route::get('user/agenda', Agenda::class)->name('agendamgmtguru');
    });
    Route::group(['middleware' => ['cekrole:kurikulum']], function(){
        Route::get('kurikulum/kelasmgmt', KelasMgmt::class)->name('kelasmgmtkurikulum');
        Route::get('kurikulum/jurusan', Jurusan::class)->name('jurusankurikulum');
        Route::get('kurikulum/agenda', Agenda::class)->name('indexkurikulum');
    });
    Route::group(['middleware' => ['cekrole:siswa']], function(){
        Route::get('siswa', Index::class)->name('indexsiswa');
    });
});
