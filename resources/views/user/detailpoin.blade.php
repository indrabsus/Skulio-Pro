@extends('layouts.app')
@section('content')
@if (session('gagal'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-times"></i> Gagal!</h5>
            {{ session('gagal') }}
          </div>
    @endif
@if (session('sukses'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
            {{ session('sukses') }}
          </div>
    @endif

    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2>Detail Poin</h2>
                <table class="table table-md">
                    <tr>
                        <td>Nama</td><td>:</td><td>{{$user->name}}</td>
                    </tr>
                    <tr>
                        <td>Kelas</td><td>:</td><td>{{$detail->nama_grup}}</td>
                    </tr>
                    <tr>
                        <td>Mata Pelajaran</td><td>:</td><td>{{$detail->nama_mapel}}</td>
                    </tr>
                    <tr>
                        <td>Plus - Minus</td><td>:</td><td>{{$plus}} - {{$minus}}</td>
                    </tr>
                    <tr>
                        <th>Total</th><th>:</th><th>{{$plus - $minus}} Poin</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>

@endsection
