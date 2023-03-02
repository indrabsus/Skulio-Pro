<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\HitungAbsen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index(){
        $config = DB::table('configs')->first();
        $nama = DB::table('users')->get();
        return view('admin.index', compact('config','nama'));
    }
    public function absen(Request $request){
        $request->validate([
            'ket' => 'required',
            'id_user' => 'required'
        ]);
        $data = DB::table('configs')->first();

        $lat1 = $request->lat;
        $long1 = $request->long;
        $lat2 = $data->lat;
        $long2 = $data->long;

    $cek = $this->cekDuplikat('absens', 'id_user', $request->id_user);
    if($cek['absen']>999){
        return redirect()->route('indexadmin')->with('gagal', 'Anda Sudah Absen Hari ini');
        } elseif(date('l', strtotime(now())) == 'Sunday' || date('l', strtotime(now())) == 'Saturday'){
            return redirect()->route('indexadmin')->with('gagal', 'Tidak bisa Absen dihari Libur');
        }

        else {
            $insert = Absen::create([
                'id_user' => $request->id_user,
                'tanggal' => date('Y/m/d'),
                'waktu' => date('h:i:s'),
                'lat' => $request->lat,
                'long' => $request->long,
                'ket' => $request->ket,
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

            ]
        );

        return redirect()->route('indexadmin')->with('sukses', 'Berhasil Absen');

        }

    }


}
