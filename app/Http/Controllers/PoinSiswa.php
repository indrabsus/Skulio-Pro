<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Mode;
use App\Models\PoinSikap;
use App\Models\PoinTemp;
use DB;
use Illuminate\Http\Request;

class PoinSiswa extends Controller
{
    public function ubahmode(){
        $status = Mode::where('id',1)->first();
        if($status->mode == 1){
            Mode::where('id', 1)->update(['mode' => 0]);
        } else {
            Mode::where('id', 1)->update(['mode' => 1]);
        }
    }
    
    public function poinrfid($norfid){
        $cek = DB::table('poin_sikaps')->leftJoin('users','users.id','poin_sikaps.id_user')->where('kode', $norfid)->count();
        
        if($cek > 0){
            PoinTemp::create(['norfid' => $norfid]);
            return "sukses";
        } else {
            return "gagal";
        }
        
    }
    public function poinscan(){
        //PoinTemp::truncate();
        $ket = '';
        $hitung = PoinTemp::count();
        $poin = PoinTemp::orderBy('created_at', 'desc')->first();
        $mode = Mode::orderBy('created_at', 'desc')->first();
        $sikap = [];
        
        if($mode->mode == 1){
            $status = 'plus';
        } else {
            $status = 'minus';
        }
        if($hitung > 0){
            $sikap = DB::table('poin_sikaps')->leftJoin('users','users.id','poin_sikaps.id_user')->where('kode', $poin->norfid)->first();
            $terdata = DB::table('poin_sikaps')->leftJoin('users','users.id','poin_sikaps.id_user')->where('kode', $poin->norfid)->count();
            if($terdata > 0){
                if($status == 'plus'){
                    PoinSikap::where('id_user', $sikap->id_user)->update(['poin' => $sikap->poin + 1]);
                    PoinTemp::truncate();
                    Log::create([
                        'id_user' => $sikap->id_user,
                        'total' => 1,
                        'status' => 'plus',
                        'no_ref' => 'PL'.date('dmyhis').$sikap->id_user
                    ]);
                    $ket = $sikap->name." Menambah +1 poin = ".$sikap->poin + 1;
                } else {
                    PoinSikap::where('id_user', $sikap->id_user)->update(['poin' => $sikap->poin - 1]);
                    PoinTemp::truncate();
                    Log::create([
                        'id_user' => $sikap->id_user,
                        'total' => 1,
                        'status' => 'minus',
                        'no_ref' => 'MN'.date('dmyhis').$sikap->id_user
                    ]);
                    $ket = $sikap->name." Berkurang -1 poin = ".$sikap->poin - 1;
                }
            } else {
                $ket = 'User tidak ditemukan';
                PoinTemp::truncate();
            }
            
        }

        return view('load.poinscan', compact('status','hitung','ket'));
    }
    public function poin(){
        return view('admin.poin');
    }
}
