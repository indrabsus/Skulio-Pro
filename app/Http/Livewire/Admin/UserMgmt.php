<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class UserMgmt extends Component
{
    public $name, $username, $jabatan, $ids, $kode;
    use WithPagination;
    public $cari = '';
    public $result = 10;
    public $role = '';
    protected $paginationTheme = 'bootstrap';
    public function render()
    {

        $data = User::where('level', 'user')
        ->where('name', 'like','%'.$this->cari.'%')
        ->where('jabatan', 'like','%'.$this->role.'%')
        ->where('id_config', Auth::user()->id_config)
        ->orderBy('id', 'desc')
        ->paginate($this->result);
        return view('livewire.admin.user-mgmt', compact('data'))
        ->extends('layouts.app')
        ->section('content');
    }
    public function clearForm(){
        $this->name = '';
        $this->username = '';
        $this->jabatan = '';
        $this->kode = '';
    }
    public function insert(){
        $this->validate([
            'name' => 'required',
            'username' => 'required|alpha_dash|unique:users',
            'jabatan' => 'required',
            'kode' => 'required'
        ],[
            'name.required' => 'Nama tidak boleh kosong!',
            'username.required' => 'Username tidak boleh kosong!',
            'username.alpha_dash' => 'Username hanya boleh huruf dan angka!',
            'username.unique' => 'Username sudah digunakan!',
            'jabatan.required' => 'Jabatan tidak boleh kosong!',
            'kode.required' => 'Kode tidak boleh kosong!'
        ]);
        User::create([
            'name' => ucwords($this->name),
            'username' => $this->username,
            'password' => bcrypt('rahasia'),
            'level' => 'user',
            'jabatan' => $this->jabatan,
            'id_config' => Auth::user()->id_config,
            'kode' => $this->kode
        ]);
        $this->clearForm();
        session()->flash('sukses', 'Data berhasil ditambahkan');
        $this->dispatchBrowserEvent('closeModal');
    }
    public function edit($id){
        $data = User::where('id',$id)->first();

        $this->ids = $data->id;
        $this->name = $data->name;
        $this->username = $data->username;
        $this->jabatan = $data->jabatan;
        $this->kode = $data->kode;
    }
    public function update(){
        $this->validate([
            'name' => 'required',
            'jabatan' => 'required',
            'kode' => 'required'
        ],[
            'name.required' => 'Nama tidak boleh kosong!',
            'jabatan.required' => 'Jabatan tidak boleh kosong',
            'kode.required' => 'Kode tidak boleh kosong!'
        ]);
        User::where('id', $this->ids)->update([
            'name' => ucwords($this->name),
            'username' => $this->username,
            'jabatan' => $this->jabatan,
            'kode' => $this->kode
        ]);
        $this->clearForm();
        session()->flash('sukses', 'Data berhasil diedit');
        $this->dispatchBrowserEvent('closeModal');
    }
    public function k_hapus($id){
        $data = User::where('id',$id)->first();
        $this->ids = $data->id;
    }
    public function delete(){
        User::where('id', $this->ids)->delete();
        session()->flash('sukses', 'Data berhasil dihapus!');
        $this->dispatchBrowserEvent('closeModal');
    }

    public function k_reset($id){
        $data = User::where('id',$id)->first();
        $this->ids = $data->id;
    }
    public function do_reset(){
        User::where('id', $this->ids)->update([
            'password' => bcrypt('rahasia')
        ]);
        $this->clearForm();
        session()->flash('sukses', 'Password berhasil direset');
        $this->dispatchBrowserEvent('closeModal');
    }
}
