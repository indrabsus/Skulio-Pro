<?php

namespace App\Http\Livewire\Keuangan;

use App\Models\Config;
use App\Models\Month;
use App\Models\Spp;
use App\Models\SppLog as LogSpp;
use App\Models\SppReq;
use App\Models\User;
use DB;
use Livewire\Component;
use Livewire\WithPagination;

class SppLog extends Component
{
    public $ket, $bayar, $nama, $noref, $ref, $nominal, $ids, $id_user, $angkatan, $bulan;
    use WithPagination;
    public $dll = 0;
    public $bln = '';
    public $thn = '';
    public $subsidi = 0;
    public $cari = '';
    public $result = 10;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $nom = Config::where('id_config', 1)->first();
        $data = DB::table('spp_logs')
        ->leftJoin('users','users.id','spp_logs.id_user')
        ->leftJoin('groups','groups.id_grup','users.id_grup')
        ->where('name', 'like','%'.$this->cari.'%')
        ->orderBy('id_log', 'desc')
        ->select('id_log','name','nama_grup','subsidi','nominal','spp_logs.updated_at','spp_logs.created_at','dll','no_ref','bayar','keterangan')
        ->paginate($this->result);
        return view('livewire.keuangan.spp-log', compact('data','nom'))
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
    

    public function k_edit($id){
        $data = DB::table('spp_logs')
        ->leftJoin('users','users.id','spp_logs.id_user')
        ->where('id_log', $id)->first();
        $this->ids = $data->id_log;
        $this->id_user = $data->id;
        $this->nama = $data->name;
        $this->noref = 'SPP'.date('dmy').$data->id;
        $this->subsidi = $data->subsidi;
        $this->bayar = $data->bayar;
        $this->nominal = $data->nominal;
        $this->dll = $data->dll;
        $spp = DB::table('spps')->leftJoin('months','months.kode','spps.kode')->where('id_user',$data->id)->first();
        $this->bulan = $spp->bulan;
        $this->angkatan = $spp->angkatan;
    }

    
    public function update(){
        $this->validate([
            'subsidi' => 'required',
            'dll' => 'required',
            'nominal' => 'required',
        ]);
        $user = Spp::where('id_user', $this->id_user)->first();
        $max = Month::max('kode');

        if($user->kode + $this->bayar > $max) {
                session()->flash('gagal', 'Pembayaran melebihi limit!');
                $this->dispatchBrowserEvent('closeModal');
            } else {
                LogSpp::where('id_log', $this->ids)->update([
                    'nominal' => $this->nominal,
                    'bayar' => 1,
                    'dll' => $this->dll,
                    'subsidi' => $this->subsidi,
                  ]);
                $this->clearForm();
                session()->flash('sukses', 'Data berhasil disimpan!');
                $this->dispatchBrowserEvent('closeModal');
            } 
    }
    public function k_hapus($id){
            $data = LogSpp::where('id_log',$id)->first();
            $this->ids = $data->id_log;
            $this->id_user = $data->id_user;
        }
        public function delete(){
            $test = LogSpp::where('id_log', $this->ids)->delete();
            $user = Spp::where('id_user', $this->id_user)->first();
            Spp::where('id_user', $this->id_user)->update([
                'kode' => $user->kode - 1
            ]);
            session()->flash('sukses', 'Data berhasil dihapus!');
            $this->dispatchBrowserEvent('closeModal');
        }
}
