<?php

namespace App\Http\Livewire\Kurikulum;

use App\Models\Group;
use App\Models\KelasSubject;
use App\Models\Role;
use App\Models\Subject;
use App\Models\User;
use Auth;
use DB;
use Livewire\Component;
use Livewire\WithPagination;

class MapelKelas extends Component
{
    public $ids, $id_mapel, $id_kelas, $id_user;
    use WithPagination;
    public $cari = '';
    public $result = 10;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $kelas = Group::where('kode_grup', '>=', 1000)->get();
        $mapel = Subject::all();
        $guru = User::where('kode','>=',1000)->where('kode','<',2000)->get();

        if(Auth::user()->level == 'admin' || Auth::user()->level == 'kurikulum'){
            $data = DB::table('kelas_subjects')
                ->leftJoin('groups','groups.id_grup','kelas_subjects.id_kelas')
                ->leftJoin('subjects','subjects.id_mapel','kelas_subjects.id_mapel')
                ->leftJoin('users','users.id','kelas_subjects.id_user')
                ->where('nama_mapel', 'like','%'.$this->cari.'%')
                ->orderBy('id_ks', 'desc')
                ->paginate($this->result);
        } else {
            $data = DB::table('kelas_subjects')
                ->leftJoin('groups','groups.id_grup','kelas_subjects.id_kelas')
                ->leftJoin('subjects','subjects.id_mapel','kelas_subjects.id_mapel')
                ->leftJoin('users','users.id','kelas_subjects.id_user')
                ->where('id_user', Auth::user()->id)
                ->where('nama_mapel', 'like','%'.$this->cari.'%')
                ->orderBy('id_ks', 'desc')
                ->paginate($this->result);
        }

        
        return view('livewire.kurikulum.mapel-kelas', compact('data','kelas','mapel','guru'))
        ->extends('layouts.app')
        ->section('content');
    }
    public function clearForm(){
        $this->id_kelas = '';
        $this->id_user = '';
        $this->id_mapel = '';
    }
    public function insert(){
        $this->validate([
            'id_kelas' => 'required',
            'id_user' => 'required',
            'id_mapel' => 'required',
        ]);
        $hitung = KelasSubject::where('id_kelas', $this->id_kelas)
        ->where('id_mapel', $this->id_mapel)
        ->count();

        if($hitung > 0){
            session()->flash('gagal', 'Data Ganda');
            $this->dispatchBrowserEvent('closeModal');
        } else {
            KelasSubject::create([
                'id_mapel' => $this->id_mapel,
                'id_kelas' => $this->id_kelas,
                'id_user' => $this->id_user,
            ]);
            $this->clearForm();
            session()->flash('sukses', 'Data berhasil ditambahkan');
            $this->dispatchBrowserEvent('closeModal');
        }
    }
    public function set($id){
        $data = KelasSubject::where('id_ks',$id)->first();

        $this->ids = $data->id_ks;
    }
    public function upset(){
        KelasSubject::where('id_ks', $this->ids)->update([
            'id_user' => NULL
        ]);
        $this->clearForm();
        session()->flash('sukses', 'Data berhasil di Unset');
        $this->dispatchBrowserEvent('closeModal');
    }

    public function edit($id){
        $data = KelasSubject::where('id_ks',$id)->first();

        $this->ids = $data->id_ks;
        $this->id_mapel = $data->id_mapel;
        $this->id_user = $data->id_user;
        $this->id_kelas = $data->id_kelas;
    }
    public function update(){
        $this->validate([
            'id_user' => 'required'
        ],[
            'id_user.required' => 'nama guru tidak boleh kosong',
        ]);

        $isi = KelasSubject::where('id_ks', $this->ids)->update([
            'id_user' => ucwords($this->id_user)
        ]);
        $this->clearForm();
        session()->flash('sukses', 'Data berhasil diedit');
        $this->dispatchBrowserEvent('closeModal');
    }
    public function k_hapus($id){
        $data = KelasSubject::where('id_ks',$id)->first();
        $this->ids = $data->id_ks;
    }
    public function delete(){
        KelasSubject::where('id_ks', $this->ids)->delete();
        session()->flash('sukses', 'Data berhasil dihapus!');
        $this->dispatchBrowserEvent('closeModal');
    }
}
