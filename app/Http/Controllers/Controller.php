<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function jarak($lat1,$long1,$lat2,$long2){
    $theta = $long1 - $long2;
    $miles = (sin(deg2rad($lat1))) * sin(deg2rad($lat2)) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
    $miles = acos($miles);
    $miles = rad2deg($miles);
    $result['miles'] = $miles * 60 * 1.1515;
    $result['feet'] = $result['miles']*5280;
    $result['yards'] = $result['feet']/3;
    $result['kilometers'] = $result['miles']*1.609344;
    $result['meters'] = $result['kilometers']*1000;

    return $result['meters'];
    }

    public function cekDuplikat($table, $key, $value){
        $hitung['absen'] = DB::table($table)->where($key, $value)->where('tanggal', date('Y/m/d', strtotime(now())))->count();
        return $hitung;
    }

    public function config(){
        $data['nama_instansi'] = 'SMK Sangkuriang 1 Cimahi';
        $data['long'] = 107.540232;
        $data['lat'] = -6.865116;
        return $data;
    }
    public function changePassword($id,$pass){
        $ganti = User::where('id',$id)->update([
            'password' => bcrypt($pass)
        ]);
        return $ganti;
    }
}
