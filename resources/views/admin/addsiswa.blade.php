@extends('layouts.app')
@section('content')
@if (session('gagal'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-times"></i> Gagal!</h5>
            {{ session('gagal') }}
          </div>
    @endif
<form action="{{route('insertsiswa')}}" method="post">
@csrf
                <div class="row">
                <div class="col-lg-6">
                <div id="cekkartu"></div>
                    
                    <div id="cekkartu"></div>
                <div class="form-group">
                    <label for="">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" placeholder="Masukan Nama Lengkap">
                    <div class="text-danger">
                    @error('name')
                        {{$message}}
                    @enderror
                </div>
                </div>
                <div class="form-group">
                    <label for="">Kelas</label>
                    <select name="id_grup" class="form-control">
                        <option value="">Pilih Kelas</option>
                        @foreach($kelas as $k)
                        <option value="{{$k->id_grup}}">{{$k->nama_grup}}</option>
                        @endforeach
                    </select>
                    <div class="text-danger">
                    @error('id_kelas')
                        {{$message}}
                    @enderror
                </div>
                </div>
                <div class="form-group">
                    <label for="">Jenis Kelamin</label>
                    <select name="jenkel" class="form-control">
                        <option value="">Pilih Gender</option>
                        <option value="l">Laki-laki</option>
                        <option value="p">Perempuan</option> 
                    </select>
                    <div class="text-danger">
                    @error('jenkel')
                        {{$message}}
                    @enderror
                </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <button class="btn btn-primary btn-block">Absen</button>
                    </div>
                </div>
                    </div>
                </div>
</form>
<script>
                $(document).ready(function(){
                    setInterval(function(){
                        $("#cekkartu").load("{{route('inputscan')}}")
                    },1000)
                })
            </script>
@endsection
