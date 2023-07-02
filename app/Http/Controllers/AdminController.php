<?php

namespace App\Http\Controllers;


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
        $kelas = Group::where('kode_grup', 1000)->get();
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

    public function sendrfid($norfid){
        $mode = Mode::first();
        $simpan = Temp::create(['norfid' => $norfid, 'status' => $mode->mode]);
        if($simpan){
            echo "Berhasil";
        } else {
            echo "Gagal";
        }
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
            $status = Mode::where('id_mode',1)->first();
            if($status->mode > 1){
                Mode::where('id_mode',1)->update([
                    'mode' => 1
                ]);
                echo "kembali ke 1";
            } else {
                Mode::where('id_mode',1)->update([
                    'mode' => $status->mode +1
                ]);
                echo "mode berubah";
            }
        }

}
