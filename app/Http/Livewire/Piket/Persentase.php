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
    public $bln = '';
    public $jbtn = 'guru';
    public $cari = '';
    public $result = 10;
    public $role = '';
    public $bulan = '';
    public function render()
    {
        $data = DB::table('hitung_absens')
        ->leftJoin('users','users.id','hitung_absens.id_user')
        ->leftJoin('jabatans','jabatans.id_jabatan','users.id_jabatan')
        ->where('users.level', 'user')
        ->where('name', 'like','%'.$this->cari.'%')
        ->where('jabatan', 'like','%'.$this->role.'%')
        ->where('bulan', 'like','%'.$this->bulan.'%')
        ->orderBy('kode','asc')
        ->paginate($this->result);
        $jbtan = Jabatan::where('kode_jabatan', 2)
        ->get();
        return view('livewire.piket.persentase',compact('data','jbtan'))
        ->extends('layouts.app')
        ->section('content');
    }
}
