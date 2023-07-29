<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminController extends Controller
{
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
        

        

}
