<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Temp;
use App\Models\User;
use DB;
use Illuminate\Http\Request;

class AbsenSiswa extends Controller
{
    public function absen(){
        Temp::truncate();
        return view('admin.absen');
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
}
