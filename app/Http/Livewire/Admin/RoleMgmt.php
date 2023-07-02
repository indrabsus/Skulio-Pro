<?php

namespace App\Http\Livewire\Admin;

use App\Models\Group;
use App\Models\Jabatan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class RoleMgmt extends Component
{
    public $ids, $nama_grup, $kode_grup;
    use WithPagination;
    public $cari = '';
    public $result = 10;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $data = Group::where('nama_grup', 'like','%'.$this->cari.'%')
        ->orderBy('kode_grup', 'asc')
        ->paginate($this->result);
        return view('livewire.admin.role-mgmt', compact('data'))
        ->extends('layouts.app')
        ->section('content');
    }
    public function clearForm(){
        $this->nama_grup = '';
        $this->kode_grup= '';
    }
    public function insert(){
        $this->validate([
            'nama_grup' => 'required',
            'kode_grup' => 'required'
        ],[
            'nama_grup.required' => 'Jabatan tidak boleh kosong',
            'kode_grup.required' => 'Kode Jabatan tidak boleh kosong',
        ]);

        Jabatan::create([
            'nama_grup' => ucwords($this->nama_grup),
            'kode_grup' => $this->kode_grup,
        ]);
        $this->clearForm();
        session()->flash('sukses', 'Data berhasil ditambahkan');
        $this->dispatchBrowserEvent('closeModal');
    }
    public function edit($id){
        $data = Group::where('id_grup',$id)->first();

        $this->ids = $data->id_grup;
        $this->nama_grup = $data->nama_grup;
        $this->kode_grup = $data->kode_grup;
    }
    public function update(){
        $this->validate([
            'nama_grup' => 'required',
            'kode_grup' => 'required'
        ],[
            'nama_grup.required' => 'Jabatan tidak boleh kosong',
            'kode_grup.required' => 'Kode Jabatan tidak boleh kosong',
        ]);

        $isi = Group::where('id_grup', $this->ids)->update([
            'nama_grup' => ucwords($this->nama_grup),
            'kode_grup' => $this->kode_grup,
        ]);
        $this->clearForm();
        session()->flash('sukses', 'Data berhasil diedit');
        $this->dispatchBrowserEvent('closeModal');
    }
    public function k_hapus($id){
        $data = Group::where('id_grup',$id)->first();
        $this->ids = $data->id_grup;
    }
    public function delete(){
        Group::where('id_grup', $this->ids)->delete();
        session()->flash('sukses', 'Data berhasil dihapus!');
        $this->dispatchBrowserEvent('closeModal');
    }
}
