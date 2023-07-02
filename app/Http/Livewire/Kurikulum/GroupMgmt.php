<?php

namespace App\Http\Livewire\Kurikulum;

use App\Models\Group;
use Livewire\Component;
use Livewire\WithPagination;

class GroupMgmt extends Component
{
    public $ids, $nama_grup, $kode_grup;
    use WithPagination;
    public $cari = '';
    public $result = 10;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $data = Group::where('nama_grup', 'like','%'.$this->cari.'%')
        ->orderBy('id_grup', 'desc')
        ->where('kode_grup',1000)
        ->paginate($this->result);
        return view('livewire.kurikulum.group-mgmt', compact('data'))
        ->extends('layouts.app')
        ->section('content');
    }
    public function clearForm(){
        $this->nama_grup = '';
    }
    public function insert(){
        $this->validate([
            'nama_grup' => 'required',
        ],[
            'nama_grup.required' => 'Kelas tidak boleh kosong',
        ]);

        Group::create([
            'nama_grup' => $this->nama_grup,
            'kode_grup' => 1000
        ]);
        $this->clearForm();
        session()->flash('sukses', 'Data berhasil ditambahkan');
        $this->dispatchBrowserEvent('closeModal');
    }
    public function edit($id){
        $data = Group::where('id_grup',$id)->first();

        $this->ids = $data->id_grup;
        $this->nama_grup = $data->nama_grup;
    }
    public function update(){
        $this->validate([
            'nama_grup' => 'required',
        ],[
            'nama_grup.required' => 'Kelas tidak boleh kosong',
        ]);

        $isi = Group::where('id_grup', $this->ids)->update([
            'nama_grup' => $this->nama_grup,
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
