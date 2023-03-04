<div>
<div class="row">
    <div class="col">
        <h1 class="display">Dashboard</h1>
    </div>
    <div class="col-lg-2">
        <a href="" class="btn btn-outline-danger" data-toggle="modal" data-target="#pass" wire:click="k_ubah({{ Auth::user()->id }})"><i class="fa fa-puzzle-piece" aria-hidden="true"> Ubah Password</i></a>
    </div>
</div>
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
                <div class="form-group">
                        <label for="">Nama :</label>
                        <select wire:model="id_user" class="form-control">
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
                    <div class="form-group">
                        <label for="">Keterangan :</label>
                        <select wire:model="ket" class="form-control">
                            <option value="">Keterangan</option>
                            <option value="hadir">Hadir</option>
                            <option value="izin">Izin</option>
                            <option value="sakit">Sakit</option>
                            <option value="nojadwal">Tidak ada jadwal</option>
                        </select>
                        <div class="text-danger">
                            @error('ket')
                                {{$message}}
                            @enderror
                        </div>
                    </div>

                        <button class="btn btn-primary btn-sm ml-auto" wire:click="absen()">Absen</button>

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

        <iframe src="https://maps.google.com/maps?q={{ $config->lat }},{{ $config->long }}&z=15&output=embed" width="450px" height="300px" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</div>

<div class="modal fade" id="pass" wire:ignore.self>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Ubah Password</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="">Password Saat ini</label>
            <input type="password" wire:model="oldPass" class="form-control">
            <div class="text-danger">
                @error('oldPass')
                    {{$message}}
                @enderror
            </div>
          </div>
          <div class="form-group">
            <label for="">Password Baru</label>
            <input type="password" wire:model="password" class="form-control">
            <div class="text-danger">
                @error('password')
                    {{$message}}
                @enderror
            </div>
          </div>
          <div class="form-group">
            <label for="">Konfirmasi Password</label>
            <input type="password" wire:model="k_password" class="form-control">
            <div class="text-danger">
                @error('k_password')
                    {{$message}}
                @enderror
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary suksestambah" wire:click="ubah()">Save changes</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
  <script>
    window.addEventListener('closeModal', event => {
        $('#pass').modal('hide');
    })
  </script>
</div>
