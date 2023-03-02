<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(){
        $nama = DB::table('users')->get();
        return view('user.index', compact('nama'));
    }
}
