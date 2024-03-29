<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Mode;
use App\Models\PoinGroup;
use App\Models\PoinSikap;
use App\Models\Temp;
use App\Models\User;
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

    public function poinscan(){
        $ket = '';
        $hitung = Temp::where('id_mesin', session('id_mesin'))->count();
        $poin = Temp::where('id_mesin', session('id_mesin'))->orderBy('created_at', 'desc')->first();
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
                    Temp::where('id_mesin', session('id_mesin'))->delete();
                    Log::create([
                        'id_user' => $sikap->id_user,
                        'total' => 1,
                        'status' => 'plus',
                        'no_ref' => 'PL'.date('dmyhis').$sikap->id_user
                    ]);
                    $ket = $sikap->name." Menambah +1 poin = ".$sikap->poin + 1;
                } else {
                    PoinSikap::where('id_user', $sikap->id_user)->update(['poin' => $sikap->poin - 1]);
                    Temp::where('id_mesin', session('id_mesin'))->delete();
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
                Temp::where('id_mesin', session('id_mesin'))->delete();
            }
            
        }

        return view('load.poinscan', compact('status','hitung','ket'));
    }
    public function poin(){
        Temp::where('id_mesin', session('id_mesin'))->delete();
        return view('admin.poin');
    }

    public function poinGroup($id, $sts, $id_kelas){
        return view('user.poingrup', compact('id','sts', 'id_kelas'));
    }
   
    public function poinGrupScan($id, $sts, $id_kelas){
        $hitung = Temp::where('id_mesin', session('id_mesin'))->count();
        $kode = Temp::where('id_mesin', session('id_mesin'))->orderBy('created_at', 'desc')->first();
        $user = [];
        $status = '';
        if($hitung > 0){
            $user = User::where('kode', $kode->norfid)->first();
            $cek = User::where('kode', $kode->norfid)->where('id_grup', $id_kelas)->count();
            $status = 'Siswa tidak terdaftar';
            Temp::where('id_mesin', session('id_mesin'))->delete();
            if($cek > 0){
                PoinGroup::create([
                    'id_ks' => $id,
                    'sts' => $sts,
                    'id_user' => $user->id
                ]);
                $status = $user->name.' mendapatkan nilai '.$sts.' 1';
        
                Temp::where('id_mesin', session('id_mesin'))->delete();
                $plus = PoinGroup::where('id_ks', $id)
                ->where('id_user', $user->id)
                ->where('sts', 'plus')
                ->count();
                $minus = PoinGroup::where('id_ks', $id)
                ->where('id_user', $user->id)
                ->where('sts', 'minus')
                ->count();
                DB::table('user_poins')->updateOrInsert([
                    'id_user' => $user->id,
                    'id_ks' => $id
                ],[
                    'plus' => $plus,
                    'minus' => $minus
                ]);
                
            }
        
        }
        return view('load.poingrupscan', compact('id','sts','hitung','status'));
        
    }
}
