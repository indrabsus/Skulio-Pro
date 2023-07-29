<?php

namespace App\Http\Controllers;

use App\Exports\PersentaseExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function absen($bln, $jbtn)
    {
        return Excel::download(new PersentaseExport($bln, $jbtn), 'persentase-'.$jbtn.'-'.$bln.'.xlsx');
    }
}
