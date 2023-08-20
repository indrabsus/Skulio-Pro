<?php

namespace App\Http\Livewire\Admin;

use App\Models\MesinRfid;
use App\Models\MesinToken;
use Livewire\Component;
use Livewire\WithPagination;

class TokenMesin extends Component
{
    public $kode_mesin, $ids;
    use WithPagination;
    public $cari = '';
    public $result = 10;
    public $role = '';
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $data = MesinToken::leftJoin('users','users.id', 'mesin_tokens.id_user')
        ->orderBy('id_mesin', 'desc')->paginate($this->result);
        return view('livewire.admin.token-mesin', compact('data'))
        ->extends('layouts.app')
        ->section('content');
    }
    
    public function k_hapus($id){
        $data = MesinToken::where('id_token',$id)->first();
        $this->ids = $data->id_token;
    }
    public function delete(){
        MesinToken::where('id_token', $this->ids)->delete();
        session()->flash('sukses', 'Data berhasil dihapus!');
        $this->dispatchBrowserEvent('closeModal');
    }
}
