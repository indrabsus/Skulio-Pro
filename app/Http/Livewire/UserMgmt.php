<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserMgmt extends Component
{
    public $name, $username, $jabatan, $ids;
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
        ->orderBy('id', 'desc')
        ->paginate($this->result);
        return view('livewire.user-mgmt', compact('data'))
        ->extends('layouts.app')
        ->section('content');
    }
    public function clearForm(){
        $this->name = '';
        $this->username = '';
        $this->jabatan = '';
    }
    public function insert(){
        $this->validate([
            'name' => 'required',
            'username' => 'required|alpha_dash|unique:users',
            'jabatan' => 'required'
        ]);
        User::create([
            'name' => $this->name,
            'username' => $this->username,
            'password' => bcrypt('rahasia'),
            'level' => 'user',
            'jabatan' => $this->jabatan,
            'id_config' => 1
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
    }
    public function update(){
        $this->validate([
            'name' => 'required',
            'jabatan' => 'required'
        ]);
        User::where('id', $this->ids)->update([
            'name' => $this->name,
            'username' => $this->username,
            'jabatan' => $this->jabatan,
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
