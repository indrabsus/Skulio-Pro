<?php

namespace App\Http\Livewire\Kurikulum;

use App\Models\Group;
use App\Models\Jabatan;
use App\Models\Role;
use DB;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class KelasMgmt extends Component
{
    public $ids, $nama_grup, $kode_grup, $roles;
    use WithPagination;
    public $cari = '';
    public $result = 10;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $role = Role::where('kode', '>=', 1000)->get();
        $data = DB::table('groups')->leftJoin('roles','roles.kode','groups.kode_grup')
        ->where('nama_grup', 'like','%'.$this->cari.'%')
        ->where('kode','>=',1000)
        ->where('kode','<',2000)
        ->orderBy('kode', 'desc')
        ->paginate($this->result);
        return view('livewire.kurikulum.kelas-mgmt', compact('data','role'))
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

        Group::create([
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
