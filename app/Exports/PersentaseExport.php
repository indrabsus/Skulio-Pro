<?php

namespace App\Exports;

use App\Models\HitungAbsen;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
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
                    ->leftJoin('jabatans','jabatans.id_jabatan','users.id_jabatan')
                    ->where('users.id_config', Auth::user()->id_config)
                    ->where('bulan', $this->bln)
                    ->where('jabatan', $this->jbtn)
                    ->get(),
            'max' => DB::table('hitung_absens')
            ->leftJoin('users','users.id','hitung_absens.id_user')
            ->leftJoin('jabatans','jabatans.id_jabatan','users.id_jabatan')
            ->where('users.id_config', Auth::user()->id_config)
            ->where('bulan', $this->bln)
            ->where('jabatan',  $this->jbtn)
            ->max('total')
        ]);
    }
}
