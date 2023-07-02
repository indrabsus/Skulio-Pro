<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Controllers\Controller;
use App\Models\Absen;
use Illuminate\Support\Facades\Auth;

class DataSiswa extends Component
{
    use WithPagination;
    public $ket;
    public $cari = '';
    public $result = 10;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $set = new Controller;
        $data = DB::table('users')
        ->leftJoin('groups','groups.id_grup','users.id_grup')
        ->leftJoin('saldos','saldos.id_user','users.id')
        ->leftJoin('poin_sikaps','poin_sikaps.id_user','users.id')
        ->where('kode_grup', 1000)
        ->where('name', 'like','%'.$this->cari.'%')
        ->orderBy('id', 'desc')
        ->paginate($this->result);
        return view('livewire.admin.data-siswa', compact('data'))
        ->extends('layouts.app')
        ->section('content');
    }
    public function k_hapus($id){
        $data = User::where('id',$id)->first();
        $this->ids = $data->id;
    }
    public function delete(){
        User::where('id', $this->ids)->delete();
        session()->flash('sukses', 'Data berhasil dihapus!');
        $this->dispatchBrowserEvent('closeModal');
    }
    public function changeAcc($id){
        $user = User::where('id', $id)->first();
        if($user->acc == 'n'){
            User::where('id', $id)->update(['acc' => 'y']);
        } else {
            User::where('id', $id)->update(['acc' => 'n']);
        }
    }
    public function absen($id){
        $data = User::where('id',$id)->first();
        $this->id_user = $data->id;
    }
    public function updateAbsen(){
        $this->validate([
            'ket' => 'required',
        ]);
        $cek = $this->cekDuplikat('absens', 'id_user', $this->id_user);
    if($cek['absen']>0){
        if(Auth::user()->level == 'admin'){
            return redirect()->route('datasiswa')->with('gagal','Anda sudah absen!');
        } else {
            return redirect()->route('datasiswapiket')->with('gagal','Anda sudah absen!');
        }
        } elseif(date('l', strtotime(now())) == 'Sunday' || date('l', strtotime(now())) == 'Saturday'){
            if(Auth::user()->level == 'admin'){
                return redirect()->route('datasiswa')->with('gagal','Tidak bisa absen dihari libur!');
            } else {
                return redirect()->route('datasiswapiket')->with('gagal','Tidak bisa absen dihari libur!');
            }
        }

        else {
            $insert = Absen::create([
                'id_user' => $this->id_user,
                'tanggal' => date('Y/m/d'),
                'waktu' => (date('A') == 'PM' ? date('h') + 12 : date('h')).date(':i:s'),
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
                'total' => Absen::where('id_user',$this->id_user)
                ->where('tanggal', 'like', '%'.date('Y-m').'%')
                ->where('ket', 'hadir')->count() +
                            Absen::where('id_user',$this->id_user)
                ->where('tanggal', 'like', '%'.date('Y-m').'%')
                ->where('ket', 'kegiatan')->count() +
                            Absen::where('id_user',$this->id_user)
                ->where('tanggal', 'like', '%'.date('Y-m').'%')
                ->where('ket', 'nojadwal')->count(),

            ]
        );
        if(Auth::user()->level == 'admin'){
            return redirect()->route('datasiswa')->with('sukses','Anda berhasil absen!');
        } else {
            return redirect()->route('datasiswapiket')->with('sukses','Anda berhasil absen!');
        }
        }
    }
    public function cekDuplikat($table, $key, $value){
        $hitung['absen'] = DB::table($table)->where($key, $value)->where('tanggal', date('Y/m/d', strtotime(now())))->count();
        return $hitung;
    }
    public function clearForm()
    {
        $this->ket = '';
    }
}
