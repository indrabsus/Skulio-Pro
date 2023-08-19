@extends('layouts.app')
@section('content')
@if (session('gagal'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-times"></i> Gagal!</h5>
            {{ session('gagal') }}
          </div>
    @endif
@if (Auth::user()->level == 'admin')
<form action="{{route('updatesiswa')}}" method="post">
@else
<form action="{{route('updatesiswamanajemen')}}" method="post">
@endif
@csrf
                <div class="row">
                <div class="col-lg-6">
                    <input type="text" value="{{$data->id}}" name="id" hidden>
                    <input type="text" value="{{$data->level}}" name="level" hidden>
                <div id="cekkartu"></div>
                    
                    <div id="cekkartu"></div>
                <div class="form-group">
                    <label for="">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" placeholder="Masukan Nama Lengkap" value="{{$data->name}}">
                    <div class="text-danger">
                    @error('name')
                        {{$message}}
                    @enderror
                </div>
                </div>
                <div class="form-group">
                    <label for="">Kelas</label>
                    <select name="id_grup" class="form-control">
                        <option value="{{$data->id_grup}}">{{$data->nama_grup}}</option>
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
                        <option value="{{$data->jenkel}}">{{$data->jenkel == 'l' ? 'Laki-laki':'Perempuan'}}</option>

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
                        <button class="btn btn-primary btn-block">Submit</button>
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
