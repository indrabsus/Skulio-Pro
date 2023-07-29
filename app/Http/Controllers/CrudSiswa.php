<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use App\Models\Group;
use App\Models\PoinSikap;
use App\Models\Saldo;
use App\Models\Spp;
use App\Models\Temp;
use App\Models\User;
use DB;
use Illuminate\Http\Request;

class CrudSiswa extends Controller
{
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
            $spp = Spp::create([
                'id_user' => $user->id,
                'kode' => 0
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

}
