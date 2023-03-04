<?php

namespace App\Http\Livewire\Admin;

use App\Models\Absen;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AbsenAll extends Component
{

    public $ket, $id_user, $oldPass, $password, $k_password, $ids, $name, $hash;
    public function render()
    {
        $config = DB::table('configs')->where('id_config', Auth::user()->id_config)->first();
        $nama = DB::table('users')->where('level', 'user')->where('id_config', Auth::user()->id_config)->get();
        return view('livewire.admin.absen-all', compact('config','nama'))
        ->extends('layouts.app')
        ->section('content');
    }
    public function absen(){
        $this->validate([
            'ket' => 'required',
            'id_user' => 'required'
        ]);
        $cek = $this->cekDuplikat('absens', 'id_user', $this->id_user);
    if($cek['absen']>0){
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
    public function k_ubah($id){
        $data = User::where('id', Auth::user()->id)->first();
        $this->ids = $data->id;
        $this->name = $data->name;
        $this->hash = $data->password;
    }
    public function ubah(){
        $this->validate([
            'oldPass' => 'required',
            'password' => 'required',
            'k_password' => 'required'
        ],[
            'oldPass.required' => 'Password Saat ini tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
            'k_password.required' => 'Konfirmasi Password tidak boleh kosong'
        ]);
        if(password_verify($this->oldPass, $this->hash)){
            if($this->password == $this->k_password){
                User::where('id', $this->ids)->update([
                    'password' => bcrypt($this->password)
                ]);
                session()->flash('sukses', 'Anda berhasil ubah password!');
                $this->dispatchBrowserEvent('closeModal');
            } else {
                session()->flash('gagal', 'Password dan konfirmasi password harus sama!');
                $this->dispatchBrowserEvent('closeModal');
            }
        } else {
            session()->flash('gagal', 'Anda gagal memasukan Password Saat ini!');
            $this->dispatchBrowserEvent('closeModal');
        }
    }
}
