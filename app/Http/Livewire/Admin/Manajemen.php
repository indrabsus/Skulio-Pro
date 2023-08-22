<?php

namespace App\Http\Livewire\Admin;

use App\Models\Config;
use App\Models\Group;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Manajemen extends Component
{
    public $name, $username, $ids, $level;
    use WithPagination;
    public $cari = '';
    public $result = 10;
    public $role = '';
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $config = Config::where('id_config', 1)->first();
        $data = DB::table('users')
        ->leftJoin('groups','groups.id_grup','users.id_grup')
        ->where('level','<>','admin')
        ->where('level','<>','user')
        ->where('level','<>','siswa')
        ->where('name', 'like','%'.$this->cari.'%')
        ->where('nama_grup', 'like','%'.$this->role.'%')
        ->orderBy('kode', 'asc')
        ->paginate($this->result);
        $jbtn = Group::where('kode_grup', '>',2)->where('kode_grup','<',1000)->get();
        return view('livewire.admin.manajemen', compact('data', 'jbtn','config'))
        ->extends('layouts.app')
        ->section('content');
    }
    public function clearForm(){
        $this->name = '';
        $this->username = '';
        $this->level = '';
    }
    public function insert(){
        $this->validate([
            'name' => 'required',
            'username' => 'required|alpha_dash|unique:users',
            'level' => 'required'
        ]);
        $konfig = Config::where('id_config', 1)->first();
        User::create([
            'name' => ucwords($this->name),
            'username' => $this->username,
            'password' => bcrypt($konfig->default_pass),
            'level' => $this->level,
            'id_grup' => 5,
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
        $this->level = $data->level;
    }
    public function update(){
        $this->validate([
            'name' => 'required',
            'level' => 'required'
        ],[
            'name.required' => 'Nama tidak boleh kosong!',
            'level.required' => 'Level tidak boleh kosong',
        ]);
        User::where('id', $this->ids)->update([
            'name' => ucwords($this->name),
            'username' => $this->username,
            'level' => $this->level
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
        $konfig = Config::where('id_config', 1)->first();
        User::where('id', $this->ids)->update([
            'password' => bcrypt($konfig->default_pass)
        ]);
        $this->clearForm();
        session()->flash('sukses', 'Password berhasil direset');
        $this->dispatchBrowserEvent('closeModal');
    }
}
