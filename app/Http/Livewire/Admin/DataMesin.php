<?php

namespace App\Http\Livewire\Admin;

use App\Models\Config;
use App\Models\MesinRfid;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class DataMesin extends Component
{
    public $kode_mesin, $ids;
    use WithPagination;
    public $cari = '';
    public $result = 10;
    public $role = '';
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $data = MesinRfid::paginate($this->result);
        return view('livewire.admin.data-mesin', compact('data'))
        ->extends('layouts.app')
        ->section('content');
    }
    public function clearForm(){
        $this->kode_mesin = '';
    }
    public function insert(){
        $this->validate([
            'kode_mesin' => 'required|unique:mesin_rfids',
        ]);
        MesinRfid::create([
            'kode_mesin' => $this->kode_mesin
        ]);
        $this->clearForm();
        session()->flash('sukses', 'Data berhasil ditambahkan');
        $this->dispatchBrowserEvent('closeModal');
    }
    public function edit($id){
        $data = MesinRfid::where('id_mesin',$id)->first();

        $this->ids = $data->id_mesin;
        $this->kode_mesin = $data->kode_mesin;
    }
    public function update(){
        $this->validate([
            'kode_mesin' => 'required|unique:mesin_rfids',
        ]);
        MesinRfid::where('id_mesin', $this->ids)->update([
            'kode_mesin' => $this->kode_mesin
        ]);
        $this->clearForm();
        session()->flash('sukses', 'Data berhasil diedit');
        $this->dispatchBrowserEvent('closeModal');
    }
    public function k_hapus($id){
        $data = MesinRfid::where('id_mesin',$id)->first();
        $this->ids = $data->id_mesin;
    }
    public function delete(){
        MesinRfid::where('id_mesin', $this->ids)->delete();
        session()->flash('sukses', 'Data berhasil dihapus!');
        $this->dispatchBrowserEvent('closeModal');
    }
}
