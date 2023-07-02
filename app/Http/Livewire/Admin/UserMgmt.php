<?php

namespace App\Http\Livewire\Admin;

use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class UserMgmt extends Component
{
    public $name, $username, $id_grup, $ids, $kode;
    use WithPagination;
    public $cari = '';
    public $result = 10;
    public $role = '';
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $data = DB::table('users')
        ->leftJoin('groups','groups.id_grup','users.id_grup')
        ->where('level','user')
        ->where('name', 'like','%'.$this->cari.'%')
        ->where('nama_grup', 'like','%'.$this->role.'%')
        ->orderBy('kode', 'asc')
        ->paginate($this->result);
        $jbtn = Group::where('kode_grup', '!=', 1)
        ->where('kode_grup', '!=', 2)
        ->where('kode_grup', '!=', 1000)
        ->get();
        return view('livewire.admin.user-mgmt', compact('data', 'jbtn'))
        ->extends('layouts.app')
        ->section('content');
    }
    public function clearForm(){
        $this->name = '';
        $this->username = '';
        $this->id_grup = '';
        $this->kode = '';
    }
    public function insert(){
        $this->validate([
            'name' => 'required',
            'username' => 'required|alpha_dash|unique:users',
            'id_grup' => 'required',
            'kode' => 'required|unique:users'
        ],[
            'name.required' => 'Nama tidak boleh kosong!',
            'username.required' => 'Username tidak boleh kosong!',
            'username.alpha_dash' => 'Username hanya boleh huruf dan angka!',
            'username.unique' => 'Username sudah digunakan!',
            'id_grup.required' => 'Jabatan tidak boleh kosong!',
            'kode.required' => 'Kode tidak boleh kosong!'
        ]);
        User::create([
            'name' => ucwords($this->name),
            'username' => $this->username,
            'password' => bcrypt('rahasia'),
            'level' => 'user',
            'id_grup' => $this->id_grup,
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
        $this->id_grup = $data->id_grup;
        $this->kode = $data->kode;
    }
    public function update(){
        $this->validate([
            'name' => 'required',
            'id_grup' => 'required',
            'kode' => 'required'
        ],[
            'name.required' => 'Nama tidak boleh kosong!',
            'id_grup.required' => 'Jabatan tidak boleh kosong',
            'kode.required' => 'Kode tidak boleh kosong!'
        ]);
        User::where('id', $this->ids)->update([
            'name' => ucwords($this->name),
            'username' => $this->username,
            'id_grup' => $this->id_grup,
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
