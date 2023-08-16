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

class PengajuanSubsidi extends Component
{
    public $ket, $bayar, $nama, $noref, $ref, $nominal, $ids, $id_user, $angkatan, $bulan, $blnnow;
    use WithPagination;
    public $dll = 0;
    public $subsidi = 0;
    public $cari = '';
    public $result = 10;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $nom = Config::where('id_config', 1)->first();
        $data = DB::table('spp_reqs')
        ->leftJoin('users','users.id','spp_reqs.id_user')
        ->leftJoin('groups','groups.id_grup','users.id_grup')
        ->where('name', 'like','%'.$this->cari.'%')
        ->orderBy('id_req', 'desc')
        ->select('id_req','name','nama_grup','subsidi','spp_reqs.updated_at','sts','spp_reqs.created_at','spp_reqs.bayar')
        ->paginate($this->result);
        return view('livewire.keuangan.pengajuan-subsidi', compact('data','nom'))
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
    

    public function k_proses($id){
        $data = DB::table('spp_reqs')
        ->leftJoin('users','users.id','spp_reqs.id_user')
        ->where('id_req', $id)->first();
        $this->ids = $data->id_req;
        $this->id_user = $data->id;
        $this->nama = $data->name;
        $this->noref = 'SPP'.date('dmy').$data->id;
        $this->subsidi = $data->subsidi;
        $this->bayar = $data->bayar;
        $this->ref = SppLog::where('created_at', 'like','%'.date('Y-m-d', strtotime(now())).'%')->count() + 1;
        $spp = DB::table('spps')->leftJoin('months','months.kode','spps.kode')->where('id_user',$data->id)->first();
        $skrg = $spp->kode + 1;
        $blnskrg = Month::where('kode', $skrg)->first();
        $this->blnnow = $blnskrg->bulan.' '.$blnskrg->angkatan;
        $this->bulan = $spp->bulan;
        $this->angkatan = $spp->angkatan;
    }

    
    public function proses(){
        $this->validate([
            'bayar' => 'required',
            'ref' => 'required',
            'nominal' => 'required',
        ]);
        $user = Spp::where('id_user', $this->id_user)->first();
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
                Spp::where('id_user', $this->id_user)->update([
                    'kode' => $user->kode + $this->bayar
                ]);
                SppLog::create([
                    'id_user' => $this->id_user,
                    'nominal' => $this->nominal,
                    'bayar' => 1, 
                    'no_ref' => $this->noref.$this->ref,
                    'dll' => $this->dll,
                    'subsidi' => $this->subsidi,
                    'keterangan' => $this->blnnow,
                ]);
                SppReq::where('id_req', $this->ids)->update([
                    'bayar' => $this->blnnow,
                    'subsidi' => $this->subsidi,
                    'sts' => 'y'
                ]);
                $this->clearForm();
                session()->flash('sukses', 'Data berhasil disimpan!');
                $this->dispatchBrowserEvent('closeModal');
            }
            
        } 
    }
    
}
