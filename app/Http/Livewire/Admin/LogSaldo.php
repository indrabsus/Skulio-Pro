<?php

namespace App\Http\Livewire\Admin;
use App\Models\Log as LogS;

use App\Models\Saldo;
use App\Models\SaldoLog;
use DB;
use Livewire\Component;
use Livewire\WithPagination;

class LogSaldo extends Component
{
    use WithPagination;
    public $ids, $total, $id_user;
    public $cari = '';
    public $result = 10;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $data = DB::table('saldo_logs')->leftJoin('users','users.id','saldo_logs.id_user')->where('name', 'like','%'.$this->cari.'%')
        ->orderBy('id_log', 'desc')
        ->select('saldo_logs.created_at','users.name','saldo_logs.status','saldo_logs.total','saldo_logs.no_ref','saldo_logs.id_log')
        ->paginate($this->result);
        return view('livewire.admin.log-saldo', compact('data'))
        ->extends('layouts.app')
        ->section('content');
    }
    public function edit($id){
        $data = SaldoLog::where('id_log', $id)->first();
        $this->ids = $data->id_log;
        $this->total = $data->total;
        $this->id_user = $data->id_user;
    }
    public function update(){
        $data = Saldo::where('id_user', $this->id_user)->first();
        $data2 = SaldoLog::where('id_log', $this->ids)->first();
        SaldoLog::where('id_log', $this->ids)->update([
            'total' => $this->total
        ]);
        Saldo::where('id_user', $this->id_user)->update([
            'saldo' => $data->saldo - ($data2->total - $this->total)
        ]);
        session()->flash('sukses', 'Data berhasil diedit!');
        $this->dispatchBrowserEvent('closeModal');
    }
    public function k_hapus($id){
        $data = LogS::where('id_log',$id)->first();
        $this->ids = $data->id_log;
    }
    public function delete(){
        LogS::where('id_log', $this->ids)->delete();
        session()->flash('sukses', 'Data berhasil dihapus!');
        $this->dispatchBrowserEvent('closeModal');
    }
}
