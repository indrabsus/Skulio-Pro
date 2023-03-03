<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Persentase extends Component
{
    use WithPagination;
    public $cari = '';
    public $result = 10;
    public $role = '';
    public $bulan = '';
    public function render()
    {
        $data = DB::table('hitung_absens')
        ->leftJoin('users','users.id','hitung_absens.id_user')
        ->where('users.level', 'user')
        ->where('name', 'like','%'.$this->cari.'%')
        ->where('jabatan', 'like','%'.$this->role.'%')
        ->where('bulan', 'like','%'.$this->bulan.'%')
        ->paginate($this->result);
        return view('livewire.persentase',compact('data'))
        ->extends('layouts.app')
        ->section('content');
    }
}
