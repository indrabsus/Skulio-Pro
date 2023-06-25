<?php

namespace App\Http\Livewire\Admin;

use App\Models\Jabatan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class RoleMgmt extends Component
{
    public $ids, $jabatan, $kode_jabatan;
    use WithPagination;
    public $cari = '';
    public $result = 10;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $data = Jabatan::where('jabatan', 'like','%'.$this->cari.'%')
        ->orderBy('kode_jabatan', 'asc')
        ->paginate($this->result);
        return view('livewire.admin.role-mgmt', compact('data'))
        ->extends('layouts.app')
        ->section('content');
    }
    public function clearForm(){
        $this->jabatan = '';
        $this->kode_jabatan= '';
    }
    public function insert(){
        $this->validate([
            'jabatan' => 'required',
            'kode_jabatan' => 'required'
        ],[
            'jabatan.required' => 'Jabatan tidak boleh kosong',
            'kode_jabatan.required' => 'Kode Jabatan tidak boleh kosong',
        ]);

        Jabatan::create([
            'jabatan' => ucwords($this->jabatan),
            'kode_jabatan' => $this->kode_jabatan,
        ]);
        $this->clearForm();
        session()->flash('sukses', 'Data berhasil ditambahkan');
        $this->dispatchBrowserEvent('closeModal');
    }
    public function edit($id){
        $data = Jabatan::where('id_jabatan',$id)->first();

        $this->ids = $data->id_jabatan;
        $this->jabatan = $data->jabatan;
        $this->kode_jabatan = $data->kode_jabatan;
    }
    public function update(){
        $this->validate([
            'jabatan' => 'required',
            'kode_jabatan' => 'required'
        ],[
            'jabatan.required' => 'Jabatan tidak boleh kosong',
            'kode_jabatan.required' => 'Kode Jabatan tidak boleh kosong',
        ]);

        $isi = Jabatan::where('id_jabatan', $this->ids)->update([
            'jabatan' => ucwords($this->jabatan),
            'kode_jabatan' => $this->kode_jabatan,
        ]);
        $this->clearForm();
        session()->flash('sukses', 'Data berhasil diedit');
        $this->dispatchBrowserEvent('closeModal');
    }
    public function k_hapus($id){
        $data = Jabatan::where('id_jabatan',$id)->first();
        $this->ids = $data->id_jabatan;
    }
    public function delete(){
        Jabatan::where('id_jabatan', $this->ids)->delete();
        session()->flash('sukses', 'Data berhasil dihapus!');
        $this->dispatchBrowserEvent('closeModal');
    }
}
