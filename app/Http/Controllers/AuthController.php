<?php

namespace App\Http\Controllers;

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
