<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class SppExport implements FromView
{
    public $bln, $thn;
    public function __construct($thn, $bln)
    {
        $this->thn = $thn;
        $this->bln = $bln;
    }

    public function view(): View
    {
        return view('exports.spplog', [
            'data' => DB::table('spp_logs')
            ->leftJoin('users','users.id','spp_logs.id_user')
            ->leftJoin('groups','groups.id_grup','users.id_grup')
            ->where('spp_logs.updated_at', 'like','%'.$this->thn.'-'.$this->bln.'%')
            ->orderBy('id_log', 'desc')
            ->select('id_log','name','nama_grup','subsidi','nominal','spp_logs.updated_at','spp_logs.created_at','dll','no_ref','bayar','keterangan')
            ->get()
        ]);
    }
}
