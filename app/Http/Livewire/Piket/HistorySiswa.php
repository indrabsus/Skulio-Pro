<?php

namespace App\Http\Livewire\Piket;

use App\Models\Group;
use App\Models\Jabatan;
use App\Models\User;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class HistorySiswa extends Component
{
    public $hash, $ids, $password, $k_password, $name, $oldPass;
    use WithPagination;
    public $cari = '';
    public $result = 10;
    public $role = '';
    public $caritgl = '';
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $jbtan = Group::where('kode_grup','>=',1000)->get();
        if(Auth::user()->level == 'admin' || Auth::user()->level == 'piket'){
            $data = DB::table('absens')
            ->leftJoin('users','users.id', 'absens.id_user')
            ->leftJoin('groups','groups.id_grup','users.id_grup')
            ->where('users.level', 'siswa')
            ->where('name', 'like','%'.$this->cari.'%')
            ->where('nama_grup', 'like','%'.$this->role.'%')
            ->where('tanggal', 'like','%'.$this->caritgl.'%')
            ->paginate($this->result);
        } else {
            $data = DB::table('absens')
            ->leftJoin('users','users.id', 'absens.id_user')
            ->leftJoin('groups','groups.id_grup','users.id_grup')
            ->where('users.id', Auth::user()->id)
            ->where('tanggal', 'like','%'.$this->caritgl.'%')
            ->paginate($this->result);
        }
        
        return view('livewire.piket.history-siswa', compact('data','jbtan'))
        ->extends('layouts.app')
        ->section('content');
    }
    public function k_ubah($id){
        $data = User::where('id', Auth::user()->id)->first();
        $this->ids = $data->id;
        $this->name = $data->name;
        $this->hash = $data->password;
    }
    public function ubah(){
        $this->validate([
            'oldPass' => 'required',
            'password' => 'required',
            'k_password' => 'required'
        ],[
            'oldPass.required' => 'Password Saat ini tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
            'k_password.required' => 'Konfirmasi Password tidak boleh kosong'
        ]);
        if(password_verify($this->oldPass, $this->hash)){
            if($this->password == $this->k_password){
                User::where('id', $this->ids)->update([
                    'password' => bcrypt($this->password)
                ]);
                session()->flash('sukses', 'Anda berhasil ubah password!');
                $this->clearForm();
                $this->dispatchBrowserEvent('closeModal');
            } else {
                session()->flash('gagal', 'Password dan konfirmasi password harus sama!');
                $this->clearForm();
                $this->dispatchBrowserEvent('closeModal');
            }
        } else {
            session()->flash('gagal', 'Anda gagal memasukan Password Saat ini!');
            $this->clearForm();
            $this->dispatchBrowserEvent('closeModal');
        }
    }
    public function clearForm()
    {
        $this->oldPass = '';
        $this->password = '';
        $this->k_password = '';
    }
}
