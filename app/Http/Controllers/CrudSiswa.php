<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\DataSiswa;
use App\Models\Group;
use App\Models\PoinGrupTemp;
use App\Models\PoinSikap;
use App\Models\Saldo;
use App\Models\Spp;
use App\Models\Temp;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CrudSiswa extends Controller
{
    public function addSiswa(){
        Temp::where('id_mesin', session('id_mesin'))->delete();
        $kelas = Group::where('kode_grup','>=', 1000)->get();
        return view('admin.addsiswa', compact('kelas'));
    }
    public function insertSiswa(Request $request){
        $request->validate([
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
            Temp::where('id_mesin', session('id_mesin'))->delete();
            return redirect()->route('datasiswa')->with('sukses', 'Anda Berhasil Menambahkan Siswa');
        }
    }
    
    public function inputformrfid(){
        $id_mesin = session('id_mesin');
        $neww = Temp::where('id_mesin', $id_mesin)->orderBy('created_at','desc')->first();
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
        Temp::where('id_mesin', session('id_mesin'))->delete();
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
        $konfig = Config::where('id_config', 1)->first();
        $hitung = User::where('kode', $request->kode)
        ->where('level', 'siswa')
        ->count();
        if($hitung > 0) {
            return redirect()->route('editsiswa',['id' => $request->id])->with('gagal', 'Kartu sudah digunakan!');
        } else {
            if($request->kode == ''){
                $user = User::where('id', $request->id)->update([
                    'name' => $request->name,
                    'password' => bcrypt($konfig->default_pass),
                    'level' => 'siswa',
                    'id_grup' => $request->id_grup,
                ]);
            } else {
                
                $user = User::where('id', $request->id)->update([
                    'name' => $request->name,
                    'password' => bcrypt($konfig->default_pass),
                    'level' => 'siswa',
                    'id_grup' => $request->id_grup,
                    'kode' => $request->kode,
                ]);
            }
            $datasiswa = DataSiswa::where('id_user', $request->id)->update([
                'jenkel' => $request->jenkel,
            ]);
            
            Temp::where('id_mesin', session('id_mesin'))->delete();
            if(Auth::user()->level == 'admin'){
                return redirect()->route('datasiswa')->with('sukses', 'Anda Berhasil Mengupdate Siswa');
            } else {
                return redirect()->route('indexmanajemen')->with('sukses', 'Anda Berhasil Mengupdate Siswa');
            }
        }
            
        }

}
