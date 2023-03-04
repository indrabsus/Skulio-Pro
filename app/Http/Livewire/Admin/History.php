<?php

namespace App\Http\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class History extends Component
{
    use WithPagination;
    public $cari = '';
    public $result = 10;
    public $role = '';
    public $tanggal = '';
    public function render()
    {
        if(Auth::user()->level == 'admin'){
            $data = DB::table('absens')
            ->leftJoin('users','users.id', 'absens.id_user')
            ->where('users.level', 'user')
            ->where('id_config', Auth::user()->id_config)
            ->where('name', 'like','%'.$this->cari.'%')
            ->where('jabatan', 'like','%'.$this->role.'%')
            ->where('tanggal', 'like','%'.$this->tanggal.'%')
            ->paginate($this->result);
        } else {
            $data = DB::table('absens')
            ->leftJoin('users','users.id', 'absens.id_user')
            ->where('users.id', Auth::user()->id)
            ->where('tanggal', 'like','%'.$this->tanggal.'%')
            ->paginate($this->result);
        }
        return view('livewire.admin.history', compact('data'))
        ->extends('layouts.app')
        ->section('content');
    }
}
