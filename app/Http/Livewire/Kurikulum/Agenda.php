<?php

namespace App\Http\Livewire\Kurikulum;

use App\Models\Agenda as ModelsAgenda;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Agenda extends Component
{
    public $ids, $materi, $id_kelas, $jam_awal, $jam_akhir;
    use WithPagination;
    public $cari = '';
    public $caritgl = '';
    public $result = 10;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $kelas = Group::all();
        $data = DB::table('agendas')
        ->leftJoin('groups','groups.id_kelas','agendas.id_kelas')
        ->leftJoin('users','users.id','agendas.id_user')
        ->where('nama_kelas', 'like','%'.$this->cari.'%')
        ->where('agendas.created_at', 'like','%'.$this->caritgl.'%')
        ->orderBy('id_agenda', 'desc')
        ->select('materi','nama_kelas','name','jam_awal','jam_akhir','agendas.created_at','id_agenda')
        ->paginate($this->result);
        return view('livewire.kurikulum.agenda', compact('data','kelas'))
        ->extends('layouts.app')
        ->section('content');
    }
    public function clearForm(){
        $this->materi = '';
        $this->id_kelas = '';
        $this->jam_awal = '';
        $this->jam_akhir = '';
    }
    public function insert(){
        $this->validate([
            'materi' => 'required',
            'id_kelas' => 'required',
            'jam_awal' => 'required',
            'jam_akhir' => 'required',
        ]);

        if($this->jam_akhir < $this->jam_awal){
            session()->flash('gagal', 'Salah Format Jam!');
            $this->dispatchBrowserEvent('closeModal');
        } else {
            ModelsAgenda::create([
                'materi' => $this->materi,
                'id_kelas' => $this->id_kelas,
                'jam_awal' => $this->jam_awal,
                'jam_akhir' => $this->jam_akhir,
                'id_user' => Auth::user()->id,
            ]);
            $this->clearForm();
            session()->flash('sukses', 'Data berhasil ditambahkan');
            $this->dispatchBrowserEvent('closeModal');
        }
    }
    public function edit($id){
        $data = ModelsAgenda::where('id_agenda',$id)->first();

        $this->ids = $data->id_agenda;
        $this->materi = $data->materi;
        $this->id_kelas = $data->id_kelas;
        $this->jam_awal = $data->jam_awal;
        $this->jam_akhir = $data->jam_akhir;
    }
    public function update(){
        $this->validate([
            'materi' => 'required',
            'id_kelas' => 'required',
            'jam_awal' => 'required',
            'jam_akhir' => 'required',
        ]);

        $isi = ModelsAgenda::where('id_agenda', $this->ids)->update([
            'materi' => $this->materi,
            'id_kelas' => $this->id_kelas,
            'jam_awal' => $this->jam_awal,
            'jam_akhir' => $this->jam_akhir,
        ]);
        $this->clearForm();
        session()->flash('sukses', 'Data berhasil diedit');
        $this->dispatchBrowserEvent('closeModal');
    }
    public function k_hapus($id){
        $data = ModelsAgenda::where('id_agenda',$id)->first();
        $this->ids = $data->id_agenda;
    }
    public function delete(){
        ModelsAgenda::where('id_agenda', $this->ids)->delete();
        session()->flash('sukses', 'Data berhasil dihapus!');
        $this->dispatchBrowserEvent('closeModal');
    }
}