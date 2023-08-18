<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Daftar Skulio Pro</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('adminv') }}/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('adminv') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('adminv') }}/dist/css/adminlte.min.css">
</head>
<body>
    
    <div class="container">
        <div class="row justify-content-center">
        <div class="col-lg-6 mt-5 mb-3">
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif
                    

                    <div class="card card-outline card-primary">
                    <div class="register-logo">
                      <a href=""><b>Daftar </b>Skulio Pro</a>
                    </div>
                    <hr>
                      <div class="card-body register-card-body">
                        <form action="{{route('prosesregis')}}" method="post">
                            @csrf
                            <div class="form-group">
                            <label for="nama_siswa">NIS</label>
                            <input type="number" class="form-control" placeholder="Masukan NIS" name="nis" value="{{ old('nis') }}">
                            <div class="text-danger">
                                @error('nis')
                                    {{$message}}
                                @enderror
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="name">Nama Siswa</label>
                            <input type="text" class="form-control" placeholder="Nama Lengkap" name="name" value="{{ old('name') }}">
                            <div class="text-danger">
                                @error('name')
                                    {{$message}}
                                @enderror
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="jk_siswa">Jenis Kelamin</label>
                            <select name="jenkel" class="form-control">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="l">Laki-laki</option>
                                <option value="p">Perempuan</option>
                            </select>
                            <div class="text-danger">
                                @error('jenkel')
                                    {{$message}}
                                @enderror
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="id_kelas">Kelas</label>
                            <select name="id_grup" class="form-control" value="{{ old('id_grup') }}">
                                <option value="">Pilih Kelas</option>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id_grup }}">{{ $k->nama_grup }}</option>
                                @endforeach
                            </select>
                            <div class="text-danger">
                                @error('id_grup')
                                    {{$message}}
                                @enderror
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="nohp">No Handphone</label>
                            <input type="number" class="form-control" placeholder="No Handphone" name="nohp" value="{{ old('nohp') }}">
                            <div class="text-danger">
                                @error('nohp')
                                    {{$message}}
                                @enderror
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="nohp">No Virtual Account</label>
                            <input type="number" class="form-control" placeholder="Boleh dikosongkan" name="no_va" value="{{ old('no_va') }}">
                            <div class="text-danger">
                                @error('no_va')
                                    {{$message}}
                                @enderror
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-8">
                            </div>
                            <!-- /.col -->
                            <div class="col-4">
                              <button type="submit" class="btn btn-primary btn-block">Register</button>
                            </div>
                            <!-- /.col -->
                          </div>
                        </form>
                      </div>
                      <!-- /.form-box -->
                    </div><!-- /.card -->
            </div>
        </div>
    </div>

            <!-- jQuery -->
<script src="{{ asset('adminv') }}/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('adminv') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ asset('adminv') }}/dist/js/adminlte.min.js"></script>
</body>
</html>