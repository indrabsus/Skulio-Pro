<?php

namespace App\Http\Livewire\Admin;

use App\Models\Jabatan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class UserMgmt extends Component
{
    public $name, $username, $id_jabatan, $ids, $kode;
    use WithPagination;
    public $cari = '';
    public $result = 10;
    public $role = '';
    protected $paginationTheme = 'bootstrap';
    public function render()
    {

        $data = DB::table('users')
        ->leftJoin('jabatans','jabatans.id_jabatan','users.id_jabatan')
        ->where('level','user')
        ->where('name', 'like','%'.$this->cari.'%')
        ->where('jabatan', 'like','%'.$this->role.'%')
        ->orderBy('kode', 'asc')
        ->paginate($this->result);
        $jbtn = Jabatan::where('kode_jabatan', 2)
        ->get();
        return view('livewire.admin.user-mgmt', compact('data', 'jbtn'))
        ->extends('layouts.app')
        ->section('content');
    }
    public function clearForm(){
        $this->name = '';
        $this->username = '';
        $this->id_jabatan = '';
        $this->kode = '';
    }
    public function insert(){
        $this->validate([
            'name' => 'required',
            'username' => 'required|alpha_dash|unique:users',
            'id_jabatan' => 'required',
            'kode' => 'required|unique:users'
        ],[
            'name.required' => 'Nama tidak boleh kosong!',
            'username.required' => 'Username tidak boleh kosong!',
            'username.alpha_dash' => 'Username hanya boleh huruf dan angka!',
            'username.unique' => 'Username sudah digunakan!',
            'id_jabatan.required' => 'Jabatan tidak boleh kosong!',
            'kode.required' => 'Kode tidak boleh kosong!'
        ]);
        User::create([
            'name' => ucwords($this->name),
            'username' => $this->username,
            'password' => bcrypt('rahasia'),
            'level' => 'user',
            'id_jabatan' => $this->id_jabatan,
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
        $this->id_jabatan = $data->id_jabatan;
        $this->kode = $data->kode;
    }
    public function update(){
        $this->validate([
            'name' => 'required',
            'id_jabatan' => 'required',
            'kode' => 'required'
        ],[
            'name.required' => 'Nama tidak boleh kosong!',
            'id_jabatan.required' => 'Jabatan tidak boleh kosong',
            'kode.required' => 'Kode tidak boleh kosong!'
        ]);
        User::where('id', $this->ids)->update([
            'name' => ucwords($this->name),
            'username' => $this->username,
            'id_jabatan' => $this->id_jabatan,
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
