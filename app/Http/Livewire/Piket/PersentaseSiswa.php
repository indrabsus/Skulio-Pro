<?php

namespace App\Http\Livewire\Piket;

use App\Models\Group;
use App\Models\Jabatan;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class PersentaseSiswa extends Component
{
    use WithPagination;
    public $bln = '';
    public $thn = '';
    public $jbtn = '';
    public $cari = '';
    public $result = 10;
    public $role = '';
    public $bulan = '';
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $data = DB::table('hitung_absens')
        ->leftJoin('users','users.id','hitung_absens.id_user')
        ->leftJoin('groups','groups.id_grup','users.id_grup')
        ->where('users.level', 'siswa')
        ->where('name', 'like','%'.$this->cari.'%')
        ->where('nama_grup', 'like','%'.$this->role.'%')
        ->where('bulan', 'like','%'.$this->bulan.'%')
        ->orderBy('kode','asc')
        ->where('kode_grup','>=', 1000)
        ->paginate($this->result);
        $jbtan = Group::where('kode_grup','>=', 1000)
        ->get();
        return view('livewire.piket.persentase-siswa',compact('data','jbtan'))
        ->extends('layouts.app')
        ->section('content');
    }
}
