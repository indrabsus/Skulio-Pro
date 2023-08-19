<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Saldo;
use App\Models\SaldoLog;
use App\Models\Temp;
use App\Models\TopupTemp;
use App\Models\User;
use DB;
use Illuminate\Http\Request;

class TopUpBayar extends Controller
{

    public function topup(){
        $neww = Temp::where('id_mesin', session('id_mesin'))->orderBy('created_at', 'desc')->first();
        $saldo = 0;
        if($neww){
            $data = DB::table('saldos')->leftJoin('users','users.id','saldos.id_user')->where('kode', $neww->norfid)->first();
            $print = $data->kode;
            $nama = $data->name;
            $saldo = $data->saldo;
            $noref = 'TO'.date('dmyh').$data->id;
        } else {
            $print = '';
            $nama = '';
            $saldo = '';
            $noref = '';
        }
        
        return view('load.topupinput', [
            'scan' => $print,
            'nama' => $nama,
            'saldo' => $saldo,
            'noref' => $noref
        ]);
    }

    public function topupform(){
        Temp::where('id_mesin', session('id_mesin'))->delete();
        return view('admin.topup');
    }

    public function topupProses(Request $request){
        $duplikat = SaldoLog::where('no_ref', $request->no_ref)->count();
        $request->validate([
            'saldo' => 'required',
            'name' => 'required',
            // 'no_ref' => 'required|unique:logs'
        ]);
        if($duplikat > 0){
            return redirect()->route('topupform')->with('gagal', 'Terlalu sering melakukan transaksi!');
        } else {
            $user = User::where('kode', $request->kode)->first();
        Saldo::where('id_user', $user->id)->update(['saldo' => $request->saldos + $request->saldo]);
        SaldoLog::create([
            'id_user' => $user->id,
            'status' => 'topup',
            'no_ref' => $request->no_ref,
            'total' => $request->saldo,
        ]);
        return redirect()->route('topupform')->with('sukses', 'Berhasil Update Saldo');
        }
        
    }
}
