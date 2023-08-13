<div>
@if (session('sukses'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
            {{ session('sukses') }}
          </div>
    @endif
@if (session('gagal'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-times"></i> Gagal!</h5>
            {{ session('gagal') }}
          </div>
    @endif

    <div class="row justify-content-between">
        @if(Auth::user()->level == 'admin')
        <div class="col-lg-3">
          <a class="btn btn-primary btn-sm mb-3" href="{{route('addsiswa')}}"><i class="fa fa-plus"></i> Tambah</a>
      </div>
      @endif
        <div class="row justify-content-end">
            <div class="col-lg-3 mb-1">
                <select wire:model='result' class="form-control">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div class="col-lg-6 mb-1">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Cari Nama" wire:model="cari">
                    <div class="input-group-append">
                      <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                  </div>
            </div>
        </div>
    </div>
    <table class="table table-striped">
        <tr>
        <th>No</th>
        <th>Nama Siswa</th>
        <th>Kelas</th>
        @if(Auth::user()->level == 'admin' || Auth::user()->level == 'piket')
        <th>Absen</th>
        @endif
        @if(Auth::user()->level == 'admin')
        <th>No RFID</th>
        <th>Username</th>
        <th>Poin</th>
        <th>Saldo</th>
        <th>Acc</th>
        <th>Aksi</th>
        @endif
        </tr>
        <?php $no=1;?>
        @foreach ($data as $d)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ ucwords($d->name) }}</td>
                <td>{{$d->nama_grup}}</td>
                @if(Auth::user()->level == 'admin' || Auth::user()->level == 'piket')
                <td><a class="btn btn-primary btn-sm mb-1" data-toggle="modal" data-target="#absen" wire:click="absen({{ $d->id }})"><i class="fa-solid fa-square-pen"></i></i></a></td>
                @endif
                
                @if(Auth::user()->level == 'admin')
                <td>{{$d->kode}}</td>
                <td>{{$d->username}}</td>
                <td>{{$d->poin}}</td>
                <td>Rp. {{number_format($d->saldo)}}</td>
                <td>
                  @if ($d->acc == 'y')
                  <a class="btn btn-success btn-sm" wire:click="changeAcc({{$d->id}})"><i class="fa-solid fa-check"></i></a>
                  @else
                  <a class="btn btn-danger btn-sm" wire:click="changeAcc({{$d->id}})"><i class="fa-solid fa-xmark"></i></a>
                  @endif
                </td>
                <td>
                  <a class="btn btn-dark btn-sm mb-1" data-toggle="modal" data-target="#k_reset" wire:click="k_reset({{ $d->id }})"><i class="fa fa-cogs"></i> Reset</a>
                  <a class="btn btn-success btn-sm mb-1" href="{{route('editsiswa',['id' => $d->id])}}"><i class="fa fa-edit"></i></a>
                    <a class="btn btn-danger btn-sm mb-1" data-toggle="modal" data-target="#k_hapus" wire:click="k_hapus({{ $d->id }})"><i class="fa fa-trash"></i></a>
                </td>
                @endif
            </tr>
        @endforeach
    </table>

            {{ $data->links() }}

   

      <div class="modal fade" id="absen" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Absen</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="">Keterangan</label>
                <select wire:model="ket" class="form-control">
                  <option value="">Pilih Keterangan</option>
                  <option value="hadir">Hadir</option>
                  <option value="kegiatan">Kegiatan</option>
                  <option value="sakit">Sakit</option>
                  <option value="izin">Izin</option>
                </select>
                <div class="text-danger">
                    @error('ket')
                        {{$message}}
                    @enderror
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary suksestambah" wire:click="updateAbsen()">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->


      <div class="modal fade" id="k_hapus" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Delete Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                Apakah Kamu yakin menghapus data ini?

            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click="delete()">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

     
      <div class="modal fade" id="k_reset" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Reset Password</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <p>Dengan me Reset Password, user ini akan menggunakan password "{{$nom->default_pass}}" tanpa tanda kutip</p>

            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click="do_reset()">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->


      <script>
        window.addEventListener('closeModal', event => {
            $('#absen').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#k_hapus').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#k_reset').modal('hide');
        })
      </script>

</div>
