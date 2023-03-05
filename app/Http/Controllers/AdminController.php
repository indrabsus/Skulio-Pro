<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Exports\PersentaseExport;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function export($bln, $jbtn)
    {
        return Excel::download(new PersentaseExport($bln, $jbtn), 'persentase-'.$jbtn.'-'.$bln.'.xlsx');
    }
}
