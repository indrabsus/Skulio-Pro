<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(){

        return view('user.index');
    }
    public function ayoAbsen(Request $request){
        $data = DB::table('configs')
        ->where('id_config', Auth::user()->id_config)
        ->first();

        $lat1 = $request->lat;
        $long1 = $request->long;
        $lat2 = $data->lat;
        $long2 = $data->long;

        $cek = $this->cekDuplikat('absens', 'id_user', $request->id_user);
        $jarak = $this->jarak($lat1,$long1,$lat2,$long2);
    if($cek['absen']>0){
        return redirect()->route('indexuser')->with('gagal', 'Anda Sudah Absen Hari ini');
        } elseif(date('l', strtotime(now())) == 'Sunday' || date('l', strtotime(now())) == 'Saturday'){
            return redirect()->route('indexuser')->with('gagal', 'Tidak bisa Absen dihari Libur');
        }

        elseif($jarak >= 200){
            return redirect()->route('indexuser')->with('gagal', 'Diluar radius yang ditentukan!');
        }  else {
            $insert = Absen::create([
                'id_user' => $request->id_user,
                'tanggal' => date('Y/m/d'),
                'waktu' => date('h:i:s'),
                'lat' => $request->lat,
                'long' => $request->long,
                'ket' => 'hadir',
                'selisih' => $this->jarak($lat1,$long1,$lat2,$long2),
            ]);
            DB::table('hitung_absens')->updateOrInsert(
            ['bulan' => date('F Y'), 'id_user' => $request->id_user],
            [
                'hadir' => Absen::where('id_user',$request->id_user)
                                ->where('tanggal', 'like', '%'.date('Y-m').'%')
                                ->where('ket', 'hadir')->count(),
                'kegiatan' => Absen::where('id_user',$request->id_user)
                ->where('tanggal', 'like', '%'.date('Y-m').'%')
                ->where('ket', 'kegiatan')->count(),
                'sakit' => Absen::where('id_user',$request->id_user)
                ->where('tanggal', 'like', '%'.date('Y-m').'%')
                ->where('ket', 'sakit')->count(),
                'izin' => Absen::where('id_user',$request->id_user)
                ->where('tanggal', 'like', '%'.date('Y-m').'%')
                ->where('ket', 'izin')->count(),
                'nojadwal' => Absen::where('id_user',$request->id_user)
                ->where('tanggal', 'like', '%'.date('Y-m').'%')
                ->where('ket', 'nojadwal')->count(),
                'total' => Absen::where('id_user',$request->id_user)
                ->where('tanggal', 'like', '%'.date('Y-m').'%')
                ->where('ket', 'hadir')->count() +
                            Absen::where('id_user',$request->id_user)
                ->where('tanggal', 'like', '%'.date('Y-m').'%')
                ->where('ket', 'kegiatan')->count() +
                            Absen::where('id_user',$request->id_user)
                ->where('tanggal', 'like', '%'.date('Y-m').'%')
                ->where('ket', 'nojadwal')->count(),


            ]
        );
        return redirect()->route('indexuser')->with('sukses', 'Berhasil Absen');
        }
    }

}
