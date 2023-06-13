<?php

namespace App\Http\Livewire\Piket;

use App\Models\Jabatan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Persentase extends Component
{
    use WithPagination;
    public $bln = 'March 2023';
    public $jbtn = 'guru';
    public $cari = '';
    public $result = 10;
    public $role = '';
    public $bulan = '';
    public function render()
    {
        $data = DB::table('hitung_absens')
        ->leftJoin('users','users.id','hitung_absens.id_user')
        ->where('users.level', 'user')
        ->where('id_config', Auth::user()->id_config)
        ->where('name', 'like','%'.$this->cari.'%')
        ->where('jabatan', 'like','%'.$this->role.'%')
        ->where('bulan', 'like','%'.$this->bulan.'%')
        ->paginate($this->result);
        $jbtan = Jabatan::where('id_config', Auth::user()->id_config)->get();
        return view('livewire.admin.persentase',compact('data','jbtan'))
        ->extends('layouts.app')
        ->section('content');
    }
}
