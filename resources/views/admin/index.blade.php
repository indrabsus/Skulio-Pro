@extends('admin.layouts.app')
@section('content')
<h1 class="display">Dashboard</h1>
<hr>
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                @if (session('sukses'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
                        {{ session('sukses') }}
                    </div>
                @endif
                @if(session('gagal'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-ban"></i> Gagal!</h5>
                    {{ session('gagal') }}
                  </div>
                @endif
                <form action="{{ route('absen') }}" method="post">
                    @csrf
                    <input type="text" name="lat" id="lat" hidden>
                    <input type="text" name="long" id="long" hidden>
                    <div class="form-group">
                        <label for="">Keterangan :</label>
                        <select name="ket" class="form-control">
                            <option value="">Keterangan</option>
                            <option value="hadir">Hadir</option>
                            <option value="izin">Izin</option>
                            <option value="sakit">Sakit</option>
                        </select>
                        <div class="text-danger">
                            @error('ket')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Nama :</label>
                        <select name="id_user" class="form-control">
                            <option value="">Pilih Nama</option>
                            @foreach ($nama as $d)
                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                            @endforeach
                        </select>
                        <div class="text-danger">
                            @error('id_user')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                        <button class="btn btn-primary btn-sm ml-auto">Absen</button>
                </form>
            </div>
        </div>
        <table class="table table-sm">
            <tr>
                <td>Nama Instansi</td>
                <td>:</td>
                <td>{{ $config->nama_instansi }}</td>
            </tr>
            <tr>
                <td>Latitude</td>
                <td>:</td>
                <td>{{ $config->lat }}</td>
            </tr>
            <tr>
                <td>Longitude</td>
                <td>:</td>
                <td>{{ $config->long }}</td>
            </tr>
        </table>
    </div>
    <div class="col-lg-6">

        <iframe src="https://maps.google.com/maps?q=-6.865116, 107.540232&z=15&output=embed" width="450px" height="300px" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</div>

<script>
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }
    getLocation()
    function showPosition(position) {
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;
        document.getElementById('lat').value = latitude
        document.getElementById('long').value = longitude
    }




</script>
@endsection
