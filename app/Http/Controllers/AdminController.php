<?php

namespace App\Http\Controllers;


use App\Models\Absen;
use App\Models\Log;
use App\Models\PoinTemp;
use App\Models\TopupTemp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Exports\PersentaseExport;
use App\Models\DataSiswa;
use App\Models\Group;
use App\Models\Mode;
use App\Models\PoinSikap;
use App\Models\Saldo;
use App\Models\Temp;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    
    public function export($bln, $jbtn)
    {
        return Excel::download(new PersentaseExport($bln, $jbtn), 'persentase-'.$jbtn.'-'.$bln.'.xlsx');
    }
    public function addSiswa(){
        Temp::truncate();
        $kelas = Group::where('kode_grup','>=', 1000)->get();
        return view('admin.addsiswa', compact('kelas'));
    }
    public function insertSiswa(Request $request){
        $request->validate([
            'kode' => 'required',
            'name' => 'required',
            'id_grup' => 'required',
            'jenkel' => 'required'
        ]);
        $hitung = User::where('kode', $request->kode)->count();
        if($hitung > 0){
            return redirect()->route('addsiswa')->with('gagal', 'Kartu sudah digunakan!');
        } else {
            $user = User::create([
                'name' => ucwords($request->name),
                'username' => rand(100,999).strtolower(substr(str_replace(' ','', $request->name), 0, 7)),
                'password' => bcrypt('sakuci'),
                'level' => 'siswa',
                'id_grup' => $request->id_grup,
                'kode' => $request->kode,
                'acc' => 'y'
            ]);
            $datasiswa = DataSiswa::create([
                'id_user' => $user->id,
                'jenkel' => $request->jenkel,
            ]);
            $saldo = Saldo::create([
                'id_user' => $user->id,
                'saldo' => 0
            ]);
            $poin = PoinSikap::create([
                'id_user' => $user->id,
                'poin' => 50,
            ]);
            Temp::truncate();
            return redirect()->route('datasiswa')->with('sukses', 'Anda Berhasil Menambahkan Siswa');
        }
    }

    public function inputrfid($norfid){
        $simpan = Temp::create(['norfid' => $norfid]);
        if($simpan){
            echo "Berhasil";
        } else {
            echo "Gagal";
        }
    }
    public function inputformrfid(){
        $neww = Temp::orderBy('created_at','desc')->first();
    if($neww){
        $print = $neww->norfid;
    } else {
        $print = '';
    }
    
    return view('load.inputscan', [
        'scan' => $print
    ]);
    }

    public function editSiswa($id){
        Temp::truncate();
        $data = DB::table('users')
        ->leftJoin('groups','groups.id_grup','users.id_grup')
        ->leftJoin('data_siswas','data_siswas.id_user','users.id')
        ->where('id',$id)
        ->first();
        $kelas = Group::where('kode_grup', 1000)->get();
        return view('admin.editsiswa', compact('kelas', 'data'));
    }
    public function updateSiswa(Request $request){
        $all = $request->validate([
            'name' => 'required',
            'id_grup' => 'required',
            'jenkel' => 'required'
        ]);
        $hitung = User::where('kode', $request->kode)
        ->where('level', 'siswa')
        ->count();
        if($hitung > 0) {
            return redirect()->route('editsiswa',['id' => $request->id])->with('gagal', 'Kartu sudah digunakan!');
        } else {
            if($request->kode == ''){
                $user = User::where('id', $request->id)->update([
                    'name' => $request->name,
                    'password' => bcrypt('sakuci'),
                    'level' => 'siswa',
                    'id_grup' => $request->id_grup,
                ]);
            } else {
                $user = User::where('id', $request->id)->update([
                    'name' => $request->name,
                    'password' => bcrypt('sakuci'),
                    'level' => 'siswa',
                    'id_grup' => $request->id_grup,
                    'kode' => $request->kode,
                ]);
            }
            $datasiswa = DataSiswa::where('id_user', $request->id)->update([
                'jenkel' => $request->jenkel,
            ]);
            
            Temp::truncate();
            return redirect()->route('datasiswa')->with('sukses', 'Anda Berhasil Mengupdate Siswa');
        }
            
        }

        public function absen(){
            Temp::truncate();
            return view('admin.absen');
        }

        public function ubahPassword(){
            return view('admin.ubah-password');
        }
        public function updatePassword(Request $request){
            $request->validate([
                'old_pass' => 'required',
                'password' => 'required|min:4',
                'k_pass' => 'required'
            ]);
            $global = new Controller;
            $user = User::where('id', Auth::user()->id)->first();
            if(password_verify($request->old_pass, $user->password)){
                if($request->password == $request->k_pass){
                    $global->changePassword(Auth::user()->id, $request->password);
                } else {
                    return redirect()->route('ubahpassword')->with('gagal', 'Password dan Konfirmasi Password harus sama!');
                }
            } else {
                return redirect()->route('ubahpassword')->with('gagal', 'Masukan Password Saat ini dengan benar!');
            }
            
            return redirect()->route('ubahpassword')->with('sukses', 'Pastikan akan mencatat password baru anda!');
        }
        public function ubahmode(){
            $status = Mode::where('id',1)->first();
            if($status->mode == 1){
                Mode::where('id', 1)->update(['mode' => 0]);
            } else {
                Mode::where('id', 1)->update(['mode' => 1]);
            }
        }
        public function absenSiswa($norfid){
                $set = new Controller;
                $user = User::where('kode',$norfid)->first();

                if($user){
                    if(date('l', strtotime(now())) == 'Sunday' || date('l', strtotime(now())) == 'Saturday'){
                        return "Gagal, Absen dihari libur";
                    } else {
                        $cek = $set->cekDuplikat('absens','id_user',$user->id);
                    if($cek['absen'] > 0){
                        return "Anda Sudah Absen";
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
                        return "sukses";
                    }
                    }   
                } else {
                    return "Gagal";
                }
        }
        public function poinrfid($norfid){
            $cek = DB::table('poin_sikaps')->leftJoin('users','users.id','poin_sikaps.id_user')->where('kode', $norfid)->count();
            
            if($cek > 0){
                PoinTemp::create(['norfid' => $norfid]);
                return "sukses";
            } else {
                return "gagal";
            }
            
        }
        public function poinscan(){
            //PoinTemp::truncate();
            $ket = '';
            $hitung = PoinTemp::count();
            $poin = PoinTemp::orderBy('created_at', 'desc')->first();
            $mode = Mode::orderBy('created_at', 'desc')->first();
            $sikap = [];
            
            if($mode->mode == 1){
                $status = 'plus';
            } else {
                $status = 'minus';
            }
            if($hitung > 0){
                $sikap = DB::table('poin_sikaps')->leftJoin('users','users.id','poin_sikaps.id_user')->where('kode', $poin->norfid)->first();
                $terdata = DB::table('poin_sikaps')->leftJoin('users','users.id','poin_sikaps.id_user')->where('kode', $poin->norfid)->count();
                
                if($terdata > 0){
                    if($status == 'plus'){
                        PoinSikap::where('id_user', $sikap->id_user)->update(['poin' => $sikap->poin + 1]);
                        PoinTemp::truncate();
                        $ket = $sikap->name." Menambah +1 poin = ".$sikap->poin + 1;
                    } else {
                        PoinSikap::where('id_user', $sikap->id_user)->update(['poin' => $sikap->poin - 1]);
                        PoinTemp::truncate();
                        $ket = $sikap->name." Berkurang -1 poin = ".$sikap->poin - 1;
                    }
                } else {
                    $ket = 'User tidak ditemukan';
                    PoinTemp::truncate();
                }
                
            }

            return view('load.poinscan', compact('status','hitung','ket'));
        }
        public function poin(){
            return view('admin.poin');
        }

        public function topuprfid($norfid){
            $cek = User::where('kode', $norfid)->count();

            if($cek > 0){
                TopupTemp::create(['norfid' => $norfid]);
                return "sukses";
            } else {
                return "gagal";
            }
        }

        public function topup(){
            $neww = TopupTemp::orderBy('created_at','desc')->first();
            $saldo = 0;
            if($neww){
                $data = DB::table('saldos')->leftJoin('users','users.id','saldos.id_user')->where('kode', $neww->norfid)->first();
                $print = $data->kode;
                $nama = $data->name;
                $saldo = $data->saldo;
                $noref = 'TO'.date('dmyhi').$data->id;
            } else {
                $print = '';
                $nama = '';
                $saldo = '';
                $noref = '';
            }
            
            return view('load.topupinput', [
                'scan' => $print,
                'nama' => $nama,
                'saldo' => $saldo,
                'noref' => $noref
            ]);
        }

        public function topupform(){
            TopupTemp::truncate();
            return view('admin.topup');
        }

        public function topupProses(Request $request){
            $duplikat = Log::where('no_ref', $request->no_ref)->count();
            $request->validate([
                'saldo' => 'required',
                'name' => 'required',
                // 'no_ref' => 'required|unique:logs'
            ]);
            if($duplikat > 0){
                return redirect()->route('topupform')->with('gagal', 'Terlalu sering melakukan transaksi!');
            } else {
                $user = User::where('kode', $request->kode)->first();
            Saldo::where('id_user', $user->id)->update(['saldo' => $request->saldos + $request->saldo]);
            Log::create([
                'id_user' => $user->id,
                'status' => 'topup',
                'no_ref' => $request->no_ref,
                'total' => $request->saldo
            ]);
            return redirect()->route('topupform')->with('sukses', 'Berhasil Update Saldo');
            }
            
        }

}
