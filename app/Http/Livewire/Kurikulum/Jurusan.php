<?php

namespace App\Http\Livewire\Kurikulum;

use App\Models\Group;
use App\Models\Role;
use DB;
use Livewire\Component;
use Livewire\WithPagination;

class Jurusan extends Component
{
    public $ids, $keterangan, $kode;
    use WithPagination;
    public $cari = '';
    public $result = 10;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $data = Role::where('kode','>=', 1000)
        ->where('keterangan', 'like','%'.$this->cari.'%')
        ->orderBy('kode', 'asc')
        ->paginate($this->result);
        return view('livewire.kurikulum.jurusan', compact('data'))
        ->extends('layouts.app')
        ->section('content');
    }
    public function clearForm(){
        $this->keterangan = '';
        $this->kode= '';
    }
    public function insert(){
        $this->validate([
            'keterangan' => 'required',
            'kode' => 'required|unique:roles'
        ],[
            'keterangan.required' => 'Jurusan tidak boleh kosong',
            'kode.required' => 'Kode Jabatan tidak boleh kosong',
        ]);

        Role::create([
            'keterangan' => ucwords($this->keterangan),
            'kode' => $this->kode,
        ]);
        $this->clearForm();
        session()->flash('sukses', 'Data berhasil ditambahkan');
        $this->dispatchBrowserEvent('closeModal');
    }
    public function edit($id){
        $data = Role::where('kode',$id)->first();

        $this->ids = $data->kode;
        $this->keterangan = $data->keterangan;
        $this->kode = $data->kode;
    }
    public function update(){
        $this->validate([
            'keterangan' => 'required',
        ],[
            'keterangan.required' => 'Jabatan tidak boleh kosong',
        ]);

        $isi = Role::where('kode', $this->ids)->update([
            'keterangan' => ucwords($this->keterangan),
        ]);
        $this->clearForm();
        session()->flash('sukses', 'Data berhasil diedit');
        $this->dispatchBrowserEvent('closeModal');
    }
    public function k_hapus($id){
        $data = Role::where('kode',$id)->first();
        $this->ids = $data->kode;
    }
    public function delete(){
        Role::where('kode', $this->ids)->delete();
        session()->flash('sukses', 'Data berhasil dihapus!');
        $this->dispatchBrowserEvent('closeModal');
    }
}
