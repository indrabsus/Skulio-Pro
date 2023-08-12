<?php

namespace App\Http\Livewire\Kurikulum;

use App\Models\Group;
use App\Models\Jabatan;
use App\Models\Role;
use App\Models\Subject;
use DB;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Mapel extends Component
{
    public $ids, $nama_mapel, $kode_grup, $roles;
    use WithPagination;
    public $cari = '';
    public $result = 10;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $data = DB::table('subjects')
        ->where('nama_mapel', 'like','%'.$this->cari.'%')
        ->orderBy('id_mapel', 'desc')
        ->paginate($this->result);
        return view('livewire.kurikulum.mapel', compact('data'))
        ->extends('layouts.app')
        ->section('content');
    }
    public function clearForm(){
        $this->nama_mapel = '';
    }
    public function insert(){
        $this->validate([
            'nama_mapel' => 'required'
        ],[
            'nama_mapel.required' => 'Nama Mapel tidak boleh kosong',
        ]);

        Subject::create([
            'nama_mapel' => ucwords($this->nama_mapel)
        ]);
        $this->clearForm();
        session()->flash('sukses', 'Data berhasil ditambahkan');
        $this->dispatchBrowserEvent('closeModal');
    }
    public function edit($id){
        $data = Subject::where('id_mapel',$id)->first();

        $this->ids = $data->id_mapel;
        $this->nama_mapel = $data->nama_mapel;
    }
    public function update(){
        $this->validate([
            'nama_mapel' => 'required'
        ],[
            'nama_mapel.required' => 'nama mapel tidak boleh kosong',
        ]);

        $isi = Subject::where('id_mapel', $this->ids)->update([
            'nama_mapel' => ucwords($this->nama_mapel)
        ]);
        $this->clearForm();
        session()->flash('sukses', 'Data berhasil diedit');
        $this->dispatchBrowserEvent('closeModal');
    }
    public function k_hapus($id){
        $data = Subject::where('id_mapel',$id)->first();
        $this->ids = $data->id_mapel;
    }
    public function delete(){
        Subject::where('id_mapel', $this->ids)->delete();
        session()->flash('sukses', 'Data berhasil dihapus!');
        $this->dispatchBrowserEvent('closeModal');
    }
}
