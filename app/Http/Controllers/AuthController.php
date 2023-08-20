<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\DataSiswa;
use App\Models\Group;
use App\Models\MesinRfid;
use App\Models\MesinToken;
use App\Models\PoinSikap;
use App\Models\Saldo;
use App\Models\Spp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index(){
        return view('loginui');
    }
    public function login(Request $request){
        $auth = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        $cekuser = User::where('username', $request->username)->first();
        $kes = MesinToken::where('id_user', $cekuser->id)->where('id_mesin', $request->id_mesin)->count();
        if($kes > 0){
            MesinToken::where('id_user', $cekuser->id)->where('id_mesin', $request->id_mesin)->delete();
        }
        $mesin = 0;
        $cektoken = MesinToken::where('id_mesin', $request->id_mesin)->count();

        if($cektoken > 0){
            return redirect()->route('index')->with('gagal', 'Mesin sedang digunakan!');
        } else {
            
            $verify = MesinRfid::where('kode_mesin', $request->id_mesin)->count();
        
        if($verify > 0){
            $mesin = 1;
            session(['id_mesin' => $request->id_mesin, 'ver' => $verify]);
        } else {
            $mesin = 0;
            session(['id_mesin' => null]);
        }
        
        if(Auth::attempt($auth)){
            Auth::user();
            $role = Auth::user()->level;
            if(Auth::user()->acc == 'n'){
                return redirect()->route('index')->with('gagal', 'Akun anda belum diaktivasi, silakan hubungi Admin!');
                Auth::logout();
            } else {
                if($mesin == 1){
                    MesinToken::create([
                        'id_mesin' => $request->id_mesin,
                        'id_user' => Auth::user()->id
                ]);
                return redirect()->route('index'.$role);
                } else {
                    return redirect()->route('index'.$role);
                }
            }
            

        }
        else {
            return redirect()->route('index')->with('gagal', 'Username dan Password Salah!');
        }
        }

    }
    public function logout(){
        if(session('id_mesin') == null){
            Auth::logout();
        return redirect()->route('index')->with('status', 'Anda berhasil logout');
        } else {
            MesinToken::where('id_mesin', session('id_mesin'))->delete();
            Auth::logout();
            return redirect()->route('index')->with('status', 'Anda berhasil logout');
        }
        
    }

    public function registrasi(){
        $kelas = Group::where('kode_grup','>=',1000)->where('kode_grup','<',2000)->get();
        return view('registrasi', compact('kelas'));
    }
    public function prosesregis(Request $request){
        $request->validate([
            'nis' => 'required|unique:data_siswas',
            'name' => 'required',
            'jenkel' => 'required',
            'id_grup' => 'required',
            'nohp' => 'required',
        ]);
        $konfig = Config::where('id_config', 1)->first();
        $user = User::create([
            'name' => ucwords($request->name),
            'username' => rand(100,999).strtolower(substr(str_replace(' ','', $request->name), 0, 7)),
            'password' => bcrypt($konfig->default_pass),
            'level' => 'siswa',
            'id_grup' => $request->id_grup,
            'acc' => 'n'
        ]);
        $datasiswa = DataSiswa::create([
            'nis' => $request->nis,
            'id_user' => $user->id,
            'jenkel' => $request->jenkel,
            'nohp' => $request->nohp,
            'no_va' => $request->no_va,
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
        return redirect()->route('index')->with('status', 'Username : '.$user->username.' Password : '.$konfig->default_pass.' (CATAT)');
    }
}
