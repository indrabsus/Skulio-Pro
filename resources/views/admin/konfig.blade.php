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
        <form action="{{route('updatekonfig')}}" method="post">
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Nama Instansi</label>
                        <input type="text" class="form-control" name="instansi" value="{{$data->instansi}}">
                    </div>
                    <div class="form-group">
                        <label for="">Longitude</label>
                        <input type="text" class="form-control" name="long" value="{{$data->long}}">
                    </div>
                    <div class="form-group">
                        <label for="">Latitude</label>
                        <input type="text" class="form-control" name="lat" value="{{$data->lat}}">
                    </div>
                    <div class="form-group">
                        <label for="">Token Telegram</label>
                        <input type="text" class="form-control" name="token_telegram" value="{{$data->token_telegram}}">
                    </div>
                    <div class="form-group">
                        <label for="">Chat Id Grup Telegram</label>
                        <input type="text" class="form-control" name="chat_id_telegram" value="{{$data->chat_id_telegram}}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">SPP 1</label>
                        <input type="text" class="form-control" name="x_spp" value="{{$data->x_spp}}">
                    </div>
                    <div class="form-group">
                        <label for="">SPP 2</label>
                        <input type="text" class="form-control" name="xi_spp" value="{{$data->xi_spp}}">
                    </div>
                    <div class="form-group">
                        <label for="">SPP 3</label>
                        <input type="text" class="form-control" name="xii_spp" value="{{$data->xii_spp}}">
                    </div>
                    <div class="form-group">
                        <label for="">Uang Pendaftaran PPDB</label>
                        <input type="text" class="form-control" name="daftar" value="{{$data->daftar}}">
                    </div>
                    <div class="form-group">
                        <label for="">Uang Masuk PPDB</label>
                        <input type="text" class="form-control" name="ppdb" value="{{$data->ppdb}}">
                    </div>
                </div>
                <button class="btn btn-primary btn-block" type="submit">Update</button>
            </div>
        </form>
    </div>

@endsection
