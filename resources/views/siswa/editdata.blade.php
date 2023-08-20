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
        <form action="{{route('updatedata')}}" method="post">
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">NIS</label>
                        <input type="text" class="form-control" name="nis" value="{{$data->nis}}">
                    </div>
                    <div class="form-group">
                        <label for="">NIK</label>
                        <input type="text" class="form-control" name="nik" value="{{$data->nik}}">
                    </div>
                    
                    <div class="form-group">
                        <label for="">No Hp</label>
                        <input type="text" class="form-control" name="nohp" value="{{$data->nohp}}">
                    </div>
                    <div class="form-group">
                        <label for="">Alamat</label>
                        <input type="text" class="form-control" name="alamat" value="{{$data->alamat}}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Nama Ayah</label>
                        <input type="text" class="form-control" name="ayah" value="{{$data->ayah}}">
                    </div>
                    <div class="form-group">
                        <label for="">Nama Ibu</label>
                        <input type="text" class="form-control" name="ibu" value="{{$data->ibu}}">
                    </div>
                    <div class="form-group">
                        <label for="">Agama</label>
                        <select name="agama" class="form-control">
                            <option value="{{$data->agama}}">{{$data->agama}}</option>
                            <option value="islam">Islam</option>
                            <option value="kristen">Kristen</option>
                            <option value="hindu">Hindu</option>
                            <option value="budha">Budha</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">No Virtual Account</label>
                        <input type="text" class="form-control" name="no_va" value="{{$data->no_va}}">
                    </div>
                </div>
                <button class="btn btn-primary btn-block" type="submit">Update</button>
            </div>
        </form>
    </div>

@endsection
