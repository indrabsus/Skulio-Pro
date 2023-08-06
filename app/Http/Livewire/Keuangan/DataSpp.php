<?php

namespace App\Http\Livewire\Keuangan;

use App\Models\Config;
use App\Models\Month;
use App\Models\Spp;
use App\Models\SppLog;
use App\Models\SppReq;
use App\Models\User;
use DB;
use Livewire\Component;
use Livewire\WithPagination;

class DataSpp extends Component
{
    public $ket, $bayar, $nama, $noref, $ref, $nominal, $ids, $id_user, $angkatan, $bulan, $kode;
    use WithPagination;
    public $dll = 0;
    public $subsidi = 0;
    public $cari = '';
    public $result = 10;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $nom = Config::where('id_config', 1)->first();
        $data = DB::table('spps')
        ->leftJoin('users','users.id','spps.id_user')
        ->leftJoin('groups','groups.id_grup','users.id_grup')
        ->leftJoin('months','months.kode','spps.kode')
        ->where('name', 'like','%'.$this->cari.'%')
        ->orderBy('id_spp', 'desc')
        ->paginate($this->result);
        return view('livewire.keuangan.data-spp', compact('data','nom'))
        ->extends('layouts.app')
        ->section('content');
    }
    public function clearForm()
    {
        $this->ket = '';
        $this->bayar = '';
        $this->nama = '';
        $this->noref = '';
        $this->ref = '';
        $this->nominal = '';

    }
    

    public function k_bayar($id){
        $data = User::where('id', $id)->first();
        $this->ids = $data->id;
        $this->nama = $data->name;
        $this->noref = 'SPP'.date('dmy').$data->id;

        $spp = DB::table('spps')->leftJoin('months','months.kode','spps.kode')->where('id_user',$id)->first();
        $this->bulan = $spp->bulan;
        $this->angkatan = $spp->angkatan;
    }

    public function k_req($id){
        $data = User::where('id', $id)->first();
        $this->ids = $data->id;
        $this->nama = $data->name;

        $spp = DB::table('spps')->leftJoin('months','months.kode','spps.kode')->where('id_user',$id)->first();
        $this->bulan = $spp->bulan;
        $this->angkatan = $spp->angkatan;
        $this->kode = $spp->kode;
    }
    public function bayar(){
        $this->validate([
            'bayar' => 'required',
            'ref' => 'required',
            'nominal' => 'required',
        ]);
        $user = Spp::where('id_user', $this->ids)->first();
        $hitung = SppLog::where('no_ref', $this->noref.$this->ref)->count();
        $max = Month::max('kode');
        if($hitung > 0){
            session()->flash('gagal', 'Data Ganda!');
            $this->dispatchBrowserEvent('closeModal');
        } else {
            if($user->kode + $this->bayar > $max) {
                session()->flash('gagal', 'Pembayaran melebihi limit!');
                $this->dispatchBrowserEvent('closeModal');
            } else {
                $baru = Spp::where('id_user', $this->ids)->update([
                    'kode' => $user->kode + $this->bayar
                ]);
                SppLog::create([
                    'id_user' => $this->ids,
                    'nominal' => $this->nominal,
                    'bayar' => $this->bayar, 
                    'no_ref' => $this->noref.$this->ref,
                    'dll' => $this->dll,
                    'subsidi' => $this->subsidi,
                    'keterangan' => "test",
                ]);
                $this->clearForm();
                session()->flash('sukses', 'Data berhasil disimpan!');
                $this->dispatchBrowserEvent('closeModal');
            }
            
        } 
    }
    public function req(){
        $this->validate([
            'bayar' => 'required',
            'subsidi' => 'required',
        ]);
        $user = Spp::where('id_user', $this->ids)->first();
        SppReq::create([
            'id_user' => $this->ids,
            'bayar' => $this->bayar,
            'subsidi' => $this->subsidi,
            'sts' => 'n'
        ]);
        $this->clearForm();
                session()->flash('sukses', 'Data berhasil disimpan!');
                $this->dispatchBrowserEvent('closeModal');
    }
}
