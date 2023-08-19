<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Temp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use File;

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
        
        public function konfig(){
            $data = Config::where('id_config', 1)->first();
            return view('admin.konfig', compact('data'));
        }
        public function updateKonfig(Request $request){
            $k = Config::where('id_config', 1)->first();
            
            if($request->file('logo') == null){
                Config::where('id_config', 1)->update([
                    'instansi' => $request->instansi,
                    'long' => $request->long,
                    'lat' => $request->lat,
                    'token_telegram' => $request->token_telegram,
                    'chat_id_telegram' => $request->chat_id_telegram,
                    'x_spp' => $request->x_spp,
                    'xi_spp' => $request->xi_spp,
                    'xii_spp' => $request->xii_spp,
                    'daftar' => $request->daftar,
                    'ppdb' => $request->ppdb,
                ]);
                return redirect()->route('konfig')->with('sukses', 'Anda sudah update Konfigurasi!');
            } else {
                $request->validate([
                    'logo' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                ]);
                if($k->logo == null){
                    $image_path = $request->file('logo')->store('image', 'public');
                    Config::where('id_config', 1)->update([
                        'instansi' => $request->instansi,
                        'long' => $request->long,
                        'lat' => $request->lat,
                        'token_telegram' => $request->token_telegram,
                        'chat_id_telegram' => $request->chat_id_telegram,
                        'x_spp' => $request->x_spp,
                        'xi_spp' => $request->xi_spp,
                        'xii_spp' => $request->xii_spp,
                        'daftar' => $request->daftar,
                        'ppdb' => $request->ppdb,
                        'logo' => $image_path
                    ]);
                    return redirect()->route('konfig')->with('sukses', 'Anda sudah update Konfigurasi!');
                } else {
                    $hapus = File::delete(public_path('storage').'/'.$k->logo);
                    $image_path = $request->file('logo')->store('image', 'public');
                Config::where('id_config', 1)->update([
                    'instansi' => $request->instansi,
                    'long' => $request->long,
                    'lat' => $request->lat,
                    'token_telegram' => $request->token_telegram,
                    'chat_id_telegram' => $request->chat_id_telegram,
                    'x_spp' => $request->x_spp,
                    'xi_spp' => $request->xi_spp,
                    'xii_spp' => $request->xii_spp,
                    'daftar' => $request->daftar,
                    'ppdb' => $request->ppdb,
                    'logo' => $image_path
                ]);
                return redirect()->route('konfig')->with('sukses', 'Anda sudah update Konfigurasi!');
                }
                
            }
            
        }

        public function rfidglobal($norfid, $id_mesin){
            $simpan = Temp::create(['norfid' => $norfid, 'id_mesin' => $id_mesin]);
            if($simpan){
                echo "Berhasil";
            } else {
                echo "Gagal";
            }
        }
}
