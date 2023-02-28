<?php

namespace App\Http\Controllers;

use App\Models\Absen;
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

    $theta = $long1 - $long2;
    $miles = (sin(deg2rad($lat1))) * sin(deg2rad($lat2)) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
    $miles = acos($miles);
    $miles = rad2deg($miles);
    $result['miles'] = $miles * 60 * 1.1515;
    $result['feet'] = $result['miles']*5280;
    $result['yards'] = $result['feet']/3;
    $result['kilometers'] = $result['miles']*1.609344;
    $result['meters'] = $result['kilometers']*1000;

    $cek = DB::table('absens')->where('id_user', $request->id_user)->where('tanggal', date('Y/m/d', strtotime(now())))->count();
        if($cek < 1){
    $insert = Absen::create([
        'id_user' => $request->id_user,
        'tanggal' => date('Y/m/d'),
        'waktu' => date('h:i:s'),
        'lat' => $request->lat,
        'long' => $request->long,
        'ket' => $request->ket
    ]);
    return redirect()->route('indexadmin')->with('sukses', 'Berhasil Absen');
} else {
    return redirect()->route('indexadmin')->with('gagal', 'Anda Sudah Absen Hari ini');
}

    }


}
