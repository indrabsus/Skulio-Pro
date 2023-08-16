<?php

use App\Http\Controllers\AbsenSiswa;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CrudSiswa;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\PoinSiswa;
use App\Http\Controllers\TopUpBayar;
use App\Http\Controllers\UserController;
use App\Http\Livewire\Admin\DataSiswa;
use App\Http\Livewire\Admin\Index as AdminIndex;
use App\Http\Livewire\Admin\LogSaldo;
use App\Http\Livewire\Admin\Manajemen;
use App\Http\Livewire\Keuangan\DataSpp;
use App\Http\Livewire\Keuangan\PengajuanSubsidi;
use App\Http\Livewire\Keuangan\SppLog;
use App\Http\Livewire\Kurikulum\KelasMgmt;
use App\Http\Livewire\Admin\Log;
use App\Http\Livewire\Kurikulum\Jurusan;
use App\Http\Livewire\Kurikulum\Mapel;
use App\Http\Livewire\Kurikulum\MapelKelas;
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

Route::get('exportabsen/{bln?}/{jbtn?}', [ExcelController::class, 'absen'])->name('absen');
Route::get('exportspplog/{thn?}/{bln?}', [ExcelController::class, 'sppLog'])->name('spplogxls');

//absen siswa
Route::get('/absensiswa/{norfid}/bataraindra2020', [AbsenSiswa::class, 'absenSiswa'])->name('absensiswafix');

// Input RFID
Route::get('/inputscan', [CrudSiswa::class, 'inputformrfid'])->name('inputscan');
Route::get('/inputrfid/{norfid}/bataraindra2020',[CrudSiswa::class,'inputrfid'])->name('inputrfid');

//RFID MODE POIN GRUP
Route::get('poingrup/{norfid}/bataraindra2020', [PoinSiswa::class, 'poinGrupRfid'])->name('poingruprfid');
Route::get('poingrupscan/{id_ks}/{sts}/{id_kelas}', [PoinSiswa::class, 'poinGrupScan'])->name('poingrupscan');

//RFID MODE POIN
Route::get('/ubahmode/bataraindra2020',[PoinSiswa::class,'ubahmode'])->name('ubahmode');
Route::get('poin/{norfid}/bataraindra2020', [PoinSiswa::class, 'poinrfid'])->name('poinrfid');
Route::get('poinscan', [PoinSiswa::class, 'poinscan'])->name('poinscan');

//RFID Top Up
Route::get('/topuprfid/{norfid}/bataraindra2020', [TopUpBayar::class, 'topuprfid'])->name('topuprfid');
Route::get('/topup', [TopUpBayar::class, 'topup'])->name('topup');


Route::group(['middleware' => ['auth']], function(){
    Route::get('/global/ubahpassword',[AdminController::class,'ubahPassword'])->name('ubahpassword');
    Route::any('/admin/updatepassword',[AdminController::class,'updatePassword'])->name('updatepassword');

    Route::group(['middleware' => ['cekrole:admin']], function(){
        // Admin Menu
        Route::get('admin', AdminIndex::class)->name('indexadmin');
        Route::get('admin/usermgmt', UserMgmt::class)->name('usermgmt');
        Route::get('admin/datasiswa', DataSiswa::class)->name('datasiswa');
        Route::get('admin/manajemen', Manajemen::class)->name('manajemen');

        //Konfigurasi
        Route::get('admin/konfig',[AdminController::class,'konfig'])->name('konfig');
        Route::any('admin/updatekonfig',[AdminController::class,'updateKonfig'])->name('updatekonfig');

        //pembayaran
        Route::get('admin/logsaldo', LogSaldo::class)->name('logsaldo');

        // Piket
        Route::get('admin/persentase', Persentase::class)->name('persentase');
        Route::get('admin/persentasesiswa', PersentaseSiswa::class)->name('persentasesiswa');
        Route::get('admin/history', History::class)->name('history');
        Route::get('admin/historysiswa', HistorySiswa::class)->name('historysiswa');
        Route::get('admin/absenkaryawan', AbsenAll::class)->name('absenkaryawan');

        // Kurikulum
        Route::get('admin/kelasmgmt', KelasMgmt::class)->name('kelasmgmt');
        Route::get('admin/jurusan', Jurusan::class)->name('jurusan');
        Route::get('admin/agenda', Agenda::class)->name('agendamgmt');
        Route::get('admin/mapel', Mapel::class)->name('mapel');
        Route::get('admin/mapelkelas', MapelKelas::class)->name('mapelkelas');

        // Keuangan
        Route::get('admin/dataspp', DataSpp::class)->name('dataspp');
        Route::get('admin/pengajuansubsidi', PengajuanSubsidi::class)->name('pengajuansubsidi');
        Route::get('admin/spplog', SppLog::class)->name('spplog');

        //Top Up RFID
        Route::get('/admin/topupform',[TopUpBayar::class,'topupform'])->name('topupform');
        Route::any('/admin/topupproses',[TopUpBayar::class,'topupProses'])->name('topupproses');

        //controller add siswa
        Route::get('/admin/addsiswa',[CrudSiswa::class,'addSiswa'])->name('addsiswa');
        Route::get('/admin/editsiswa/{id}',[CrudSiswa::class,'editSiswa'])->name('editsiswa');
        Route::any('/admin/insertsiswa',[CrudSiswa::class,'insertSiswa'])->name('insertsiswa');
        Route::any('/admin/updatesiswa',[CrudSiswa::class,'updateSiswa'])->name('updatesiswa');

        //Poin Siswa
        Route::get('/admin/poin',[PoinSiswa::class,'poin'])->name('poin');

        //Log
        Route::get('admin/log', Log::class)->name('log');

        //Print PDF
        Route::get('/admin/print',[PdfController::class, 'print'])->name('print');
        Route::get('/admin/invoicepembayaran/{id}',[PdfController::class, 'invoiceSaldo'])->name('invoicesaldo');
        Route::get('/admin/invoicespp/{id}',[PdfController::class, 'invoiceSpp'])->name('invoicespp');
        
        
    });
    Route::group(['middleware' => ['cekrole:piket']], function(){
        Route::get('piket', AbsenAll::class)->name('indexpiket');
        Route::get('piket/usermgmt', UserMgmt::class)->name('usermgmtpiket');
        Route::get('piket/history', History::class)->name('historypiket');
        Route::get('piket/persentase', Persentase::class)->name('persentasepiket');
        Route::get('piket/export/{bln?}/{jbtn?}', [AdminController::class, 'export'])->name('exportpiket');
    
        //Absen RFID
    Route::get('/piket/absensiswa',[AbsenSiswa::class,'absen'])->name('absensiswapiket');
        //Data Siswa
    Route::get('piket/datasiswa', DataSiswa::class)->name('datasiswapiket');
        //Livewire Absen Siswa
    Route::get('piket/persentasesiswa', PersentaseSiswa::class)->name('persentasesiswapiket');
    Route::get('piket/historysiswa', HistorySiswa::class)->name('historysiswapiket');
    
    });
    Route::group(['middleware' => ['cekrole:user']], function(){
        Route::get('user', [UserController::class,'index'])->name('indexuser');
        Route::get('user/kelas/{id_ks}', [UserController::class,'kelas'])->name('kelasguru');
        Route::get('user/detailpoin/{id_ks}/{id_user}', [UserController::class,'detailpoin'])->name('detailpoin');
        Route::get('user/poingrup/{id_ks}/{sts}/{id_kelas}', [PoinSiswa::class,'poinGroup'])->name('poingrup');
        Route::post('user/ayoabsen', [UserController::class,'ayoAbsen'])->name('ayoabsen');
        Route::get('user/history', History::class)->name('userhistory');
        Route::get('user/agenda', Agenda::class)->name('agendamgmtguru');
        Route::get('user/mapelkelas', MapelKelas::class)->name('mapelkelasguru');
        
    });
    Route::group(['middleware' => ['cekrole:kurikulum']], function(){
        Route::get('kurikulum/kelasmgmt', KelasMgmt::class)->name('kelasmgmtkurikulum');
        Route::get('kurikulum/jurusan', Jurusan::class)->name('jurusankurikulum');
        Route::get('kurikulum/agenda', Agenda::class)->name('indexkurikulum');
        Route::get('kurikulum/mapel', Mapel::class)->name('mapelkurikulum');
        Route::get('kurikulum/mapelkelas', MapelKelas::class)->name('mapelkelaskurikulum');
    });
    Route::group(['middleware' => ['cekrole:siswa']], function(){
        Route::get('siswa', Index::class)->name('indexsiswa');
    });
    Route::group(['middleware' => ['cekrole:keuangan']], function(){
        Route::get('keuangan', DataSpp::class)->name('indexkeuangan');
        Route::get('keuangan/pengajuansubsidi', PengajuanSubsidi::class)->name('pengajuansubsidikeuangan');
        Route::get('keuangan/spplog', SppLog::class)->name('spplogkeuangan');
    });
    Route::group(['middleware' => ['cekrole:requester']], function(){
        Route::get('requester', DataSpp::class)->name('indexrequester');
        Route::get('requester/pengajuansubsidi', PengajuanSubsidi::class)->name('pengajuansubsidirequester');
    });
});
