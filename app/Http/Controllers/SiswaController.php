<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function siswaData(){
        $data = DataSiswa::where('id_user', Auth::user()->id)->first();
        return view('siswa.editdata', compact('data'));
    }
    public function updateData(Request $request){
        DataSiswa::where('id_user', Auth::user()->id)->update([
            'nis' => $request->nis,
            'nik' => $request->nik,
            'nohp' => $request->nohp,
            'alamat' => $request->alamat,
            'ayah' => $request->ayah,
            'ibu' => $request->ibu,
            'agama' => $request->agama,
            'no_va' => $request->no_va,
        ]);
        return redirect()->route('siswadata')->with('sukses', 'Data berhasil diupdate!');
    }
}
