@if (Auth::check())
    @if (Auth::user()->level == 'admin')
    <script>window.location = "{{ route('indexadmin') }}";</script>
    @elseif (Auth::user()->level == 'karyawan')
    <script>window.location = "{{ route('indexkaryawan') }}";</script>
    @endif
@endif
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Skulio - Sistem Informasi Sekolah</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('adminv') }}/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('adminv') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('adminv') }}/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
  @if (session('status'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
            {{ session('status') }}
          </div>
    @endif
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="{{ url('/') }}" class="h1">Skulio<b> PRO</b></a>
    </div>
    <div class="card-body">
        
        @if (session('gagal'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-times"></i> Gagal!</h5>
            {{ session('gagal') }}
          </div>
    @endif

      <form action="{{ route('login') }}" method="post">
        @csrf
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Masukan Username" name="username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Masukan Password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3" id="mesin">
          <input type="text" class="form-control" placeholder="Masukan Kode Mesin" name="id_mesin">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-laptop-code"></span>
            </div>
          </div>
        </div>
        <div class="row justify-content-center">
          <!-- /.col -->
          <div class="col-3">
            <a href="" id="show" class="btn btn-danger" onclick="return false">Show</a>
          </div>
          <div class="col-3">
            <a href="" id="hide" class="btn btn-danger" onclick="return false">Hide</a>
          </div>
          <div class="col-6">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
        </form>
        <p class="mt-3">Belum Punya Akun? <a href="{{route('registrasi')}}">Daftar disini!</a></p>
      </div>
    </div>
  </div>
          <!-- /.col -->
          
     


 
  <!-- /.card -->

<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('adminv') }}/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('adminv') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ asset('adminv') }}/dist/js/adminlte.min.js"></script>
<script>
  $('#mesin').hide()
  $('#hide').hide()
   $("#show").click(function(){
  $('#mesin').show()
  $('#show').hide()
  $('#hide').show()
});
   $("#hide").click(function(){
  $('#mesin').hide()
  $('#show').show()
  $('#hide').hide()
});
</script>
</body>
</html>
