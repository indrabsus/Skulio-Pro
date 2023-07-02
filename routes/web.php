<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use App\Http\Livewire\Admin\DataSiswa;
use App\Http\Livewire\Admin\Index as AdminIndex;
use App\Http\Livewire\Piket\AbsenAll;
use App\Http\Livewire\Piket\History;
use App\Http\Livewire\Piket\Persentase;
use App\Http\Livewire\Admin\RoleMgmt;
use App\Http\Livewire\Admin\UserMgmt;
use App\Http\Livewire\Kurikulum\Agenda;
use App\Http\Livewire\Kurikulum\GroupMgmt;
use App\Http\Livewire\Piket\HistorySiswa;
use App\Http\Livewire\Piket\PersentaseSiswa;
use App\Http\Livewire\Siswa\Index;
use App\Models\Absen;
use App\Models\Mode;
use App\Models\PoinSikap;
use App\Models\Temp;
use App\Models\TempAddSiswa;
use Illuminate\Support\Facades\DB;
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
Route::get('/sendrfid/{norfid}/bataraindra2020',[AdminController::class,'sendrfid'])->name('sendrfid');
Route::get('/ubahmode/bataraindra2020',[AdminController::class,'ubahmode'])->name('ubahmode');
Route::get('export/{bln?}/{jbtn?}', [AdminController::class, 'export'])->name('export');

// View to Load
Route::get('/inputscan', function() {
    $neww = Temp::orderBy('created_at','desc')->first();
    if($neww){
        $print = $neww->norfid;
    } else {
        $print = '';
    }
    
    return view('load.inputscan', [
        'scan' => $print
    ]);
    
})->name('inputscan');

Route::get('/absenscan', function() {
    $set = new Controller;
    $poin = ['poin' => 0];
    $mode = Mode::first();
    $neww = Temp::orderBy('created_at','desc')->first();
    $temp = Temp::count();
    
    $user = [];
    if($neww == null) {
    $hitung = 0;
    
    } else {
    $hitung = DB::table('temps')
    ->leftJoin('users','users.kode','temps.norfid')
    ->where('kode', $neww->norfid)
    ->count();
    $user = DB::table('temps')
    ->leftJoin('users','users.kode','temps.norfid')
    ->where('kode', $neww->norfid)
    ->first();
    }
    
    if($temp > 0 && $hitung == 0){
        
        $status = 0;
        Temp::truncate();
    } elseif($temp > 0 && $hitung > 0) {
        
            if($mode->mode == 1){
                $cek = $set->cekDuplikat('absens','id_user',$user->id);
            if($cek['absen'] > 0){
                $status = 3;
                Temp::truncate();
            } else {
                Absen::create([
                    'id_user' => $user->id,
                    'tanggal' => date('Y/m/d'),
                    'waktu' => (date('A') == 'PM' ? date('h') + 12 : date('h')).date(':i:s'),
                    'ket' => 'hadir'
                ]);
                DB::table('hitung_absens')->updateOrInsert(
                    ['bulan' => date('F Y'), 'id_user' => $user->id],
                    [
                        'hadir' => Absen::where('id_user',$user->id)
                                        ->where('tanggal', 'like', '%'.date('Y-m').'%')
                                        ->where('ket', 'hadir')->count(),
                        'kegiatan' => Absen::where('id_user',$user->id)
                        ->where('tanggal', 'like', '%'.date('Y-m').'%')
                        ->where('ket', 'kegiatan')->count(),
                        'sakit' => Absen::where('id_user',$user->id)
                        ->where('tanggal', 'like', '%'.date('Y-m').'%')
                        ->where('ket', 'sakit')->count(),
                        'izin' => Absen::where('id_user',$user->id)
                        ->where('tanggal', 'like', '%'.date('Y-m').'%')
                        ->where('ket', 'izin')->count(),
                        'nojadwal' => Absen::where('id_user',$user->id)
                        ->where('tanggal', 'like', '%'.date('Y-m').'%')
                        ->where('ket', 'nojadwal')->count(),
                        'total' => Absen::where('id_user',$user->id)
                        ->where('tanggal', 'like', '%'.date('Y-m').'%')
                        ->where('ket', 'hadir')->count() +
                                    Absen::where('id_user',$user->id)
                        ->where('tanggal', 'like', '%'.date('Y-m').'%')
                        ->where('ket', 'kegiatan')->count() +
                                    Absen::where('id_user',$user->id)
                        ->where('tanggal', 'like', '%'.date('Y-m').'%')
                        ->where('ket', 'nojadwal')->count(),
                    ]
                );
                $status = 1;
                Temp::truncate();
            }
            } elseif($mode->mode == 2){
                $poin = PoinSikap::where('id_user', $user->id)->first();
                $simpan = PoinSikap::where('id_user', $user->id)->update([
                    'poin' => $poin->poin +1,
                ]);
                $status = 4;
                Temp::truncate();
                
            }
    } else {
        $status = 2;
    }
    return view('load.absenscan', compact('status','user','mode','poin'));
    
})->name('absenscan');

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
        Route::get('admin/rolemgmt', RoleMgmt::class)->name('rolemgmt');
        Route::get('admin/absenkaryawan', AbsenAll::class)->name('absenkaryawan');
        Route::get('admin/groupmgmt', GroupMgmt::class)->name('groupmgmt');
        Route::get('admin/agenda', Agenda::class)->name('agendamgmt');
        Route::get('admin/datasiswa', DataSiswa::class)->name('datasiswa');

        //controller add siswa
        Route::get('/admin/addsiswa',[AdminController::class,'addSiswa'])->name('addsiswa');
        Route::get('/admin/editsiswa/{id}',[AdminController::class,'editSiswa'])->name('editsiswa');
        Route::any('/admin/insertsiswa',[AdminController::class,'insertSiswa'])->name('insertsiswa');
        Route::any('/admin/updatesiswa',[AdminController::class,'updateSiswa'])->name('updatesiswa');

        Route::get('/admin/absen',[AdminController::class,'absen'])->name('absen');
        
        
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
        Route::get('kurikulum/agenda', Agenda::class)->name('indexkurikulum');
        Route::get('kurikulum/groupmgmt', GroupMgmt::class)->name('groupmgmtkurikulum');
    });
    Route::group(['middleware' => ['cekrole:siswa']], function(){
        Route::get('siswa', Index::class)->name('indexsiswa');
    });
});
