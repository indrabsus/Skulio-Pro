<?php

namespace App\Http\Livewire\Kurikulum;

use App\Models\Subject;
use DB;
use Livewire\Component;
use Livewire\WithPagination;

class MapelKelas extends Component
{
    public $ids, $id_mapel, $id_kelas;
    use WithPagination;
    public $cari = '';
    public $result = 10;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $data = DB::table('kelas-subjects')
        ->leftJoin('groups','groups.id_kelas','kelas-subjects.id_kelas')
        ->leftJoin('subjects','subjects.id_mapel','kelas-subjects.id_mapel')
        ->where('nama_mapel', 'like','%'.$this->cari.'%')
        ->orderBy('id_ks', 'desc')
        ->paginate($this->result);
        return view('livewire.kurikulum.mapel-kelas', compact('data'))
        ->extends('layouts.app')
        ->section('content');
    }
    public function clearForm(){
        $this->id_kelas = '';
        $this->id_mapel = '';
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
