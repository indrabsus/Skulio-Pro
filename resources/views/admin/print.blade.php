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

    <label for="">Absen Guru</label>
               <div class="row">
                <div class="col-lg-2">
                    <div class="form-group">
                        <select name="bulan" class="form-control">
                            <option value="">Pilih Bulan</option>
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="August">August</option>
                            <option value="September">September</option>
                            <option value="October">October</option>
                            <option value="November">November</option>
                            <option value="December">December</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <select name="tahun" class="form-control">
                            <option value="">Pilih Tahun</option>
                            <option value="{{date('Y') - 1}}">{{date('Y') -1}}</option>
                            <option value="{{date('Y')}}">{{date('Y')}}</option>
                            <option value="{{date('Y') + 1}}">{{date('Y') + 1}}</option>
    
                        </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <button class="btn btn-primary">Download PDF</button>
                </div>
               </div>

@endsection
