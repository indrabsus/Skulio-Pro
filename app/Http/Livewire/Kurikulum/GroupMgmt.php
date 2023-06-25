<?php

namespace App\Http\Livewire\Kurikulum;

use App\Models\Group;
use Livewire\Component;
use Livewire\WithPagination;

class GroupMgmt extends Component
{
    public $ids, $nama_kelas;
    use WithPagination;
    public $cari = '';
    public $result = 10;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $data = Group::where('nama_kelas', 'like','%'.$this->cari.'%')
        ->orderBy('id_kelas', 'desc')
        ->paginate($this->result);
        return view('livewire.kurikulum.group-mgmt', compact('data'))
        ->extends('layouts.app')
        ->section('content');
    }
    public function clearForm(){
        $this->nama_kelas = '';
    }
    public function insert(){
        $this->validate([
            'nama_kelas' => 'required',
        ],[
            'nama_kelas.required' => 'Kelas tidak boleh kosong',
        ]);

        Group::create([
            'nama_kelas' => $this->nama_kelas,
        ]);
        $this->clearForm();
        session()->flash('sukses', 'Data berhasil ditambahkan');
        $this->dispatchBrowserEvent('closeModal');
    }
    public function edit($id){
        $data = Group::where('id_kelas',$id)->first();

        $this->ids = $data->id_kelas;
        $this->nama_kelas = $data->nama_kelas;
    }
    public function update(){
        $this->validate([
            'nama_kelas' => 'required',
        ],[
            'nama_kelas.required' => 'Kelas tidak boleh kosong',
        ]);

        $isi = Group::where('id_kelas', $this->ids)->update([
            'nama_kelas' => $this->nama_kelas,
        ]);
        $this->clearForm();
        session()->flash('sukses', 'Data berhasil diedit');
        $this->dispatchBrowserEvent('closeModal');
    }
    public function k_hapus($id){
        $data = Group::where('id_kelas',$id)->first();
        $this->ids = $data->id_kelas;
    }
    public function delete(){
        Group::where('id_kelas', $this->ids)->delete();
        session()->flash('sukses', 'Data berhasil dihapus!');
        $this->dispatchBrowserEvent('closeModal');
    }
}
