<?php

namespace App\Http\Controllers;

use App\Exports\PersentaseExport;
use App\Exports\SppExport;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function absen($bln, $jbtn)
    {
        return Excel::download(new PersentaseExport($bln, $jbtn), 'persentase-'.$jbtn.'-'.$bln.'.xlsx');
    }

    public function sppLog($thn, $bln)
    {
        
        return Excel::download(new SppExport($thn, $bln), 'spplog-'.$thn.'-'.$bln.'.xlsx');
        
    }
}
