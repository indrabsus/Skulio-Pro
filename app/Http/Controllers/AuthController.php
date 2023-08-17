<?php

namespace App\Http\Controllers;

use App\Models\MesinRfid;
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
        $verify = MesinRfid::where('kode_mesin', $request->id_mesin)->count();
        
        if($verify > 0){
            session(['id_mesin' => $request->id_mesin]);
        } else {
            session(['id_mesin' => null]);
        }
        
        if(Auth::attempt($auth)){
            Auth::user();
            $role = Auth::user()->level;
            if(Auth::user()->acc == 'n'){
                return redirect()->route('index')->with('gagal', 'Akun anda belum diaktivasi, silakan hubungi Admin!');
                Auth::logout();
            } else {
                return redirect()->route('index'.$role);
            }
            

        }
        else {
            return redirect()->route('index')->with('gagal', 'Username dan Password Salah!');
        }
    }
    public function logout(){
        Auth::logout();
        return redirect()->route('index')->with('status', 'Anda berhasil logout');
    }
}
