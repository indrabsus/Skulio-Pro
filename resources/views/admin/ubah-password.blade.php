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

               <div class="row">
                <div class="col-lg-6">
               <form action="{{route('updatepassword')}}" method="post">
               <div class="form-group">
                <label for="">Password Saat Ini</label>
                <input type="password" name="old_pass" class="form-control">
                <div class="text-danger">
                    @error('old_pass')
                        {{$message}}
                    @enderror
                </div>
              </div>
               <div class="form-group">
                <label for="">Password Baru</label>
                <input type="password" name="password" class="form-control">
                <div class="text-danger">
                    @error('password')
                        {{$message}}
                    @enderror
                </div>
              </div>
               <div class="form-group">
                <label for="">Konfirmasi Password</label>
                <input type="password" name="k_pass" class="form-control">
                <div class="text-danger">
                    @error('k_pass')
                        {{$message}}
                    @enderror
                </div>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
               </form>
                </div>
               </div>


@endsection
