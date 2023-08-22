<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class PersentaseExport implements FromView
{
    public $bln, $jbtn;
    public function __construct($bln, $jbtn)
    {
        $this->bln = $bln;
        $this->jbtn = $jbtn;
    }

    public function view(): View
    {
        return view('exports.persentase', [
            'data' => DB::table('hitung_absens')
                    ->leftJoin('users','users.id','hitung_absens.id_user')
                    ->leftJoin('groups','groups.id_grup','users.id_grup')
                    ->where('bulan', $this->bln)
                    ->where('nama_grup', $this->jbtn)
                    ->orderBy('kode', 'asc')
                    ->get(),
            'max' => DB::table('hitung_absens')
            ->leftJoin('users','users.id','hitung_absens.id_user')
            ->leftJoin('groups','groups.id_grup','users.id_grup')
            ->where('bulan', $this->bln)
            ->where('nama_grup',  $this->jbtn)
            ->max('total')
        ]);
    }
}
