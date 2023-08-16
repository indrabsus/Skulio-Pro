<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Temp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class UserController extends Controller
{
    public function index(){
        $scan = Temp::first();
        return view('user.index', compact('scan'));
    }
    public function ayoAbsen(Request $request){
        $kfg = new Controller;
        $data = $kfg->config();

        $lat1 = $request->lat;
        $long1 = $request->long;
        $lat2 = $data['lat'];
        $long2 = $data['long'];

        $cek = $this->cekDuplikat('absens', 'id_user', $request->id_user);
        $jarak = $this->jarak($lat1,$long1,$lat2,$long2);
    if($cek['absen']>0){
        return redirect()->route('indexuser')->with('gagal', 'Anda Sudah Absen Hari ini');
        } elseif(date('l', strtotime(now())) == 'Sunday' || date('l', strtotime(now())) == 'Saturday'){
            return redirect()->route('indexuser')->with('gagal', 'Tidak bisa Absen dihari Libur');
        }

        elseif($jarak >= 200){
            return redirect()->route('indexuser')->with('gagal', 'Diluar radius yang ditentukan! Selisih : '.round($jarak).' m');
        }  else {
            $insert = Absen::create([
                'id_user' => $request->id_user,
                'tanggal' => date('Y/m/d'),
                'waktu' => (date('A') == 'PM' ? date('h') + 12 : date('h')).date(':i:s'),
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
        return redirect()->route('indexuser')->with('sukses', 'Berhasil Absen, Selisih: '.round($jarak).' m');
        }
    }

    public function kelas($id_ks){
        $detail = DB::table('kelas_subjects')
        ->leftJoin('groups','groups.id_grup','kelas_subjects.id_kelas')
        ->leftJoin('subjects','subjects.id_mapel','kelas_subjects.id_mapel')
        ->where('id_ks', $id_ks)->first();
        $data = DB::table('users')
        ->leftJoin('groups','groups.id_grup','users.id_grup')
        ->leftJoin('user_poins','user_poins.id_user','users.id')
        ->where('users.id_grup',$detail->id_kelas)
        ->get();
       
        // $data = DB::table('user_poins')
        // ->leftJoin('users','users.id','user_poins.id_user')
        // ->where('user_poins.id_user', $detail->id_user)
        // ->get();
        return view('user.kelas', compact('data','detail'));
    }

    public function detailPoin($id_ks, $id_user){
        $plus = DB::table('poin_groups')
        ->where('id_ks', $id_ks)
        ->where('id_user', $id_user)
        ->where('sts', 'plus')
        ->count();
        $minus = DB::table('poin_groups')
        ->where('id_ks', $id_ks)
        ->where('id_user', $id_user)
        ->where('sts', 'minus')
        ->count();

        $user = User::where('id', $id_user)->first();
        $detail = DB::table('kelas_subjects')
        ->leftJoin('subjects','subjects.id_mapel','kelas_subjects.id_mapel')
        ->leftJoin('groups','groups.id_grup','kelas_subjects.id_kelas')
        ->where('id_ks', $id_ks)
        ->first();
        return view('user.detailpoin',compact('plus','minus','user','detail'));
    }
}
