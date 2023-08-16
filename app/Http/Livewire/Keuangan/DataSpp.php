<?php

namespace App\Http\Livewire\Keuangan;

use App\Models\Config;
use App\Models\Month;
use App\Models\Spp;
use App\Models\SppLog;
use App\Models\SppReq;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithPagination;

class DataSpp extends Component
{
    public $ket, $bayar, $nama, $noref, $ref, $nominal, $ids, $id_user, $angkatan, $bulan, $kode;
    use WithPagination;
    public $dll = 0;
    public $blnnow = 1;
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
        $this->ref = SppLog::where('created_at', 'like','%'.date('Y-m-d', strtotime(now())).'%')->count() + 1;
        

        $spp = DB::table('spps')->leftJoin('months','months.kode','spps.kode')->where('id_user',$id)->first();
        $skrg = $spp->kode + 1;
        $blnskrg = Month::where('kode', $skrg)->first();
        $this->blnnow = $blnskrg->bulan.' '.$blnskrg->angkatan;
        $this->bulan = $spp->bulan;
        $this->angkatan = $spp->angkatan;
    }

    public function bayar(){
        $this->validate([
            'ref' => 'required',
            'nominal' => 'required',
        ]);
        $bot = Config::where('id_config', 1)->first();
        $user = Spp::where('id_user', $this->ids)->first();
        $hitung = SppLog::where('no_ref', $this->noref.$this->ref)->count();
        $max = Month::max('kode');
        if($hitung > 0){
            session()->flash('gagal', 'Data Ganda!');
            $this->dispatchBrowserEvent('closeModal');
        } else {
            if($user->kode + 1 > $max) {
                session()->flash('gagal', 'Pembayaran melebihi limit!');
                $this->dispatchBrowserEvent('closeModal');
            } else {
                $baru = Spp::where('id_user', $this->ids)->update([
                    'kode' => $user->kode + 1
                ]);
                $new = SppLog::create([
                    'id_user' => $this->ids,
                    'nominal' => (int)$this->nominal,
                    'bayar' => 1, 
                    'no_ref' => $this->noref.$this->ref,
                    'dll' => $this->dll,
                    'subsidi' => $this->subsidi,
                    'keterangan' => $this->blnnow,
                ]);
                $this->clearForm();
                $nama = User::where('id', $this->ids)->first();
                $nomi = (int)$new->nominal + (int)$new->dll - (int)$new->subsidi;
                $text = $nama->name.' sudah membayar SPP bulan '.$this->blnnow.' Rp.'.number_format((int)$new->nominal).' dan biaya lainnya Rp.'.number_format($new->dll).' dan mendapatkan subsidi Rp.'.number_format($new->subsidi).' Total Rp.'.number_format($nomi);
                Http::get('https://api.telegram.org/bot'.$bot->token_telegram.'/sendMessage?chat_id='.$bot->chat_id_telegram.'&text='.$text);
                session()->flash('sukses', 'Data berhasil disimpan!');
                $this->dispatchBrowserEvent('closeModal');
            }
            
        } 
    }

    public function k_req($id){
        $data = User::where('id', $id)->first();
        $this->ids = $data->id;
        $this->nama = $data->name;

        $spp = DB::table('spps')->leftJoin('months','months.kode','spps.kode')->where('id_user',$id)->first();
        $skrg = $spp->kode + 1;
        $blnskrg = Month::where('kode', $skrg)->first();
        $this->blnnow = $blnskrg->bulan.' '.$blnskrg->angkatan;
        $this->bulan = $spp->bulan;
        $this->angkatan = $spp->angkatan;
        $this->kode = $spp->kode;
    }
    
    public function req(){
        $this->validate([
            'subsidi' => 'required',
        ]);
        $user = Spp::where('id_user', $this->ids)->first();
        SppReq::create([
            'id_user' => $this->ids,
            'bayar' => 1,
            'subsidi' => $this->subsidi,
            'sts' => 'n'
        ]);
        $this->clearForm();
                session()->flash('sukses', 'Data berhasil disimpan!');
                $this->dispatchBrowserEvent('closeModal');
    }
}
