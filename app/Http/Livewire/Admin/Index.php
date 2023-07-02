<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $guru = DB::table('users')
        ->leftJoin('groups','groups.id_grup','users.id_grup')
        ->where('kode_grup', 3)
        ->count();
        $tendik = DB::table('users')
        ->leftJoin('groups','groups.id_grup','users.id_grup')
        ->where('kode_grup', 4)
        ->count();
        $saldo = DB::table('users')
        ->leftJoin('saldos','saldos.id_user','users.id')
        ->sum('saldo');
        $siswa = User::where('level', 'siswa')->count();
        return view('livewire.admin.index',compact('guru','tendik','saldo','siswa'))
        ->extends('layouts.app')
        ->section('content');
    }
}
