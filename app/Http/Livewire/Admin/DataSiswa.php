<?php

namespace App\Http\Livewire\Admin;

use App\Models\Config;
use App\Models\Group;
use App\Models\PoinSikap;
use App\Models\Saldo;
use App\Models\Spp;
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
    public $ket, $bayar, $nama, $noref, $ref, $nominal, $ids, $id_user, $angkatan, $bulan,
    $nis, $name, $jenkel, $id_grup, $nohp, $no_va;
    public $dll = 0;
    public $subsidi = 0;
    public $cari = '';
    public $result = 10;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $set = new Controller;
        $kelas = Group::where('kode_grup','>=',1000)->where('kode_grup','<',2000)->get();
        $nom = Config::where('id_config', 1)->first();
        $data = DB::table('users')
        ->leftJoin('groups','groups.id_grup','users.id_grup')
        ->leftJoin('saldos','saldos.id_user','users.id')
        ->leftJoin('poin_sikaps','poin_sikaps.id_user','users.id')
        ->leftJoin('data_siswas','data_siswas.id_user','users.id')
        ->where('kode_grup','>=', 1000)
        ->where('kode_grup','<', 2000)
        ->where('name', 'like','%'.$this->cari.'%')
        ->orderBy('id', 'desc')
        ->paginate($this->result);
        return view('livewire.admin.data-siswa', compact('data', 'nom','kelas'))
        ->extends('layouts.app')
        ->section('content');
    }
    public function clearForm(){
        $this->nis = '';
        $this->name = '';
        $this->jenkel = '';
        $this->id_grup = '';
        $this->nohp = '';
        $this->no_va = '';
        $this->ket = '';
    }

    public function insert(){
        $this->validate([
            'nis' => 'required|unique:data_siswas',
            'name' => 'required',
            'jenkel' => 'required',
            'id_grup' => 'required',
            'nohp' => 'required',
        ]);
        $konfig = Config::where('id_config', 1)->first();
        $user = User::create([
            'name' => ucwords($this->name),
            'username' => rand(100,999).strtolower(substr(str_replace(' ','', $this->name), 0, 7)),
            'password' => bcrypt($konfig->default_pass),
            'level' => 'siswa',
            'id_grup' => $this->id_grup,
            'acc' => 'y'
        ]);
        $datasiswa = \App\Models\DataSiswa::create([
            'nis' => $this->nis,
            'id_user' => $user->id,
            'jenkel' => $this->jenkel,
            'nohp' => $this->nohp,
            'no_va' => $this->no_va
        ]);
        $saldo = Saldo::create([
            'id_user' => $user->id,
            'saldo' => 0
        ]);
        $poin = PoinSikap::create([
            'id_user' => $user->id,
            'poin' => 50,
        ]);
        $spp = Spp::create([
            'id_user' => $user->id,
            'kode' => 0
        ]);
        $this->clearForm();
        session()->flash('sukses', 'Data berhasil ditambahkan');
        $this->dispatchBrowserEvent('closeModal');
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
   

    public function k_reset($id){
        $data = User::where('id',$id)->first();
        $this->ids = $data->id;
    }
    public function do_reset(){
        $kon = Config::where('id_config', 1)->first();
        User::where('id', $this->ids)->update([
            'password' => bcrypt($kon->default_pass)
        ]);
        $this->clearForm();
        session()->flash('sukses', 'Password berhasil direset');
        $this->dispatchBrowserEvent('closeModal');
    }

    public function edit($id){
        $data = DB::table('users')
        ->leftJoin('groups','groups.id_grup','users.id_grup')
        ->leftJoin('data_siswas','data_siswas.id_user','users.id')
        ->where('id',$id)
        ->first();
        $this->id_userku = $data->id;
        $this->nis = $data->nis;
        $this->name = $data->name;
        $this->jenkel = $data->jenkel;
        $this->id_grup = $data->id_grup;
        $this->nohp = $data->nohp;
        $this->no_va = $data->no_va;
    }
    public function update(){
        User::where('id', $this->id_userku)->update([
            'name' => $this->name,
            'id_grup' => $this->id_grup,
        ]);
        \App\Models\DataSiswa::where('id_user', $this->id_userku)->update([
            'nis' => $this->nis,
            'jenkel' => $this->jenkel,
            'nohp' => $this->nohp,
            'no_va' => $this->no_va,
        ]);
        $this->clearForm();
        session()->flash('sukses', 'Password berhasil direset');
        $this->dispatchBrowserEvent('closeModal');
    }
}
