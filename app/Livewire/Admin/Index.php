<?php

namespace App\Livewire\Admin;

use App\Models\SppLog;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        if(Auth::user()->level == 'admin'){
            $id_mesin = session('id_mesin');
        $karyawan = DB::table('users')
        ->leftJoin('groups','groups.id_grup','users.id_grup')
        ->where('level', 'user')
        ->count();
        $saldo = DB::table('users')
        ->leftJoin('saldos','saldos.id_user','users.id')
        ->sum('saldo');
        $siswa = User::where('level', 'siswa')->count();
        return view('livewire.admin.index',compact('karyawan','saldo','siswa','id_mesin'))
        ->extends('layouts.app')
        ->section('content');
        } elseif(Auth::user()->level == 'keuangan'){
            $spp = SppLog::sum('nominal');
            $dll = SppLog::sum('dll');
            $subsidi = SppLog::sum('subsidi');
            $total = $spp + $dll - $subsidi;
            return view('livewire.admin.index',compact('spp','dll','subsidi','total'))
            ->extends('layouts.app')
        ->section('content');
        }
    }
}
