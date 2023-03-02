<?php

namespace App\Http\Livewire;

use App\Models\Absen;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AbsenAll extends Component
{

    public $ket, $id_user;
    public function render()
    {
        $config = DB::table('configs')->first();
        $nama = DB::table('users')->get();
        return view('livewire.absen-all', compact('config','nama'))
        ->extends('layouts.app')
        ->section('content');
    }
    public function absen(){
        $this->validate([
            'ket' => 'required',
            'id_user' => 'required'
        ]);
        $cek = $this->cekDuplikat('absens', 'id_user', $this->id_user);
    if($cek['absen']>99){
        session()->flash('gagal', 'Anda Sudah Absen Hari ini');
        } elseif(date('l', strtotime(now())) == 'Sunday' || date('l', strtotime(now())) == 'Saturday'){
            session()->flash('gagal', 'Tidak bisa Absen dihari Libur');
        }

        else {
            $insert = Absen::create([
                'id_user' => $this->id_user,
                'tanggal' => date('Y/m/d'),
                'waktu' => date('h:i:s'),
                'ket' => $this->ket,
            ]);
            DB::table('hitung_absens')->updateOrInsert(
            ['bulan' => date('F Y'), 'id_user' => $this->id_user],
            [
                'hadir' => Absen::where('id_user',$this->id_user)
                                ->where('tanggal', 'like', '%'.date('Y-m').'%')
                                ->where('ket', 'hadir')->count(),
                'kegiatan' => Absen::where('id_user',$this->id_user)
                ->where('tanggal', 'like', '%'.date('Y-m').'%')
                ->where('ket', 'kegiatan')->count(),
                'sakit' => Absen::where('id_user',$this->id_user)
                ->where('tanggal', 'like', '%'.date('Y-m').'%')
                ->where('ket', 'sakit')->count(),
                'izin' => Absen::where('id_user',$this->id_user)
                ->where('tanggal', 'like', '%'.date('Y-m').'%')
                ->where('ket', 'izin')->count(),
                'nojadwal' => Absen::where('id_user',$this->id_user)
                ->where('tanggal', 'like', '%'.date('Y-m').'%')
                ->where('ket', 'nojadwal')->count(),

            ]
        );
        session()->flash('sukses', 'Berhasil Absen');
        $this->clearForm();
        }

    }
    public function cekDuplikat($table, $key, $value){
        $hitung['absen'] = DB::table($table)->where($key, $value)->where('tanggal', date('Y/m/d', strtotime(now())))->count();
        return $hitung;
    }
    public function clearForm()
    {
        $this->id_user = '';
        $this->ket = '';
    }
}
