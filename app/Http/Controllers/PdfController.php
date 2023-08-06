<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Month;
use Barryvdh\DomPDF\Facade\Pdf;
use DB;

class PdfController extends Controller
{
    public function print(){
        return view('admin.print');
    }

    public function invoiceSaldo($id){
        $config = Config::where('id_config',1)->first();
        $data = DB::table('saldo_logs')
        ->leftJoin('users','users.id','saldo_logs.id_user')
        ->leftJoin('groups','groups.id_grup','users.id_grup')
        ->select('no_ref','name','status','nama_grup','total','saldo_logs.updated_at')
        ->where('id_log', $id)
        ->first();
        $pdf = Pdf::loadView('pdf.saldo', compact('data','config'));
        return $pdf->stream();
    }
    public function invoiceSpp($id){
        $config = Config::where('id_config',1)->first();
        $data = DB::table('spp_logs')
        ->leftJoin('users','users.id','spp_logs.id_user')
        ->leftJoin('groups','groups.id_grup','users.id_grup')
        ->select('no_ref','name','bayar','nama_grup','nominal','spp_logs.updated_at','dll','subsidi','id')
        ->where('id_log', $id)
        ->first();
        $spp = DB::table('spps')->leftJoin('months','months.kode','spps.kode')->where('id_user',$data->id)->first();
       
        $bulan = $spp->kode - $data->bayar + 1;
        $awal = Month::where('kode', $bulan)->first();
        $pdf = Pdf::loadView('pdf.spp', compact('data','config','spp','awal'));
        return $pdf->stream();
    }
}
