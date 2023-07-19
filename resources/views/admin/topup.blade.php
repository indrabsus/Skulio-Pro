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
            <h5><i class="icon fas fa-check"></i> Sukses!</h5>
            {{ session('sukses') }}
          </div>
    @endif
    <h3>Top Up Saldo</h3>
    <hr>
<form action="{{route('topupproses')}}" method="post">
@csrf
                <div class="row">
                <div class="col-lg-6">
                <div id="cekkartu"></div>
                    
                <div class="form-group">
                    <label for="">Top Up</label>
                    <input type="text" name="saldo" class="form-control" placeholder="Masukan Nominal">
                    <div class="text-danger">
                    @error('saldo')
                        {{$message}}
                    @enderror
                </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <button class="btn btn-primary btn-block">Top Up</button>
                    </div>
                </div>
                    </div>
                </div>
</form>
<script>
                $(document).ready(function(){
                    setInterval(function(){
                        $("#cekkartu").load("{{route('topup')}}")
                    },1000)
                })
            </script>
@endsection
