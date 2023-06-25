<div>
    
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
        <div class="row justify-content-end">
        <div class="col-lg-3 mb-1">
        <a href="" class="btn btn-outline-danger" data-toggle="modal" data-target="#pass" wire:click="k_ubah({{ Auth::user()->id }})"><i class="fa fa-puzzle-piece" aria-hidden="true"> Ubah Password</i></a>
    </div>
            <div class="col-lg-3 mb-1">
                <div class="input mb-3">
                    <input type="date" class="form-control" wire:model="caritgl">
                  </div>
            </div>
            @if (Auth::user()->level == 'admin')
            <div class="col-lg-2 mb-1">
                <select wire:model='role' class="form-control">
                    <option value="">Pilih Jabatan</option>
                   @foreach ($jbtan as $d)
                   <option value="{{$d->jabatan}}">{{$d->jabatan}}</option>
                   @endforeach
                    
                </select>
            </div>
            @endif
            <div class="col-lg-1 mb-1">
                <select wire:model='result' class="form-control">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            @if (Auth::user()->level == 'admin')
            <div class="col-lg-3 mb-1">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Cari Nama" wire:model="cari">
                    <div class="input-group-append">
                      <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                  </div>
            </div>
            @endif
        </div>
    <table class="table table-striped table-responsive-sm">
        <tr>
            <th>No</th>
            <th>Nama Lengkap</th>
            @if (Auth::user()->level == 'admin')
            <th>Jabatan</th>
            @endif
            <th>Tanggal</th>
            <th>Waktu</th>
            <th>Keterangan</th>
            <th>Jarak</th>
        </tr>
        <?php $no=1; ?>
        @foreach ($data as $d)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $d->name }}</td>
                @if (Auth::user()->level == 'admin')
                <td>{{ ucwords($d->jabatan) }}</td>
                @endif
                <td>{{ date('l, d M Y', strtotime($d->tanggal)) }}</td>
                <td>{{ $d->waktu }}</td>
                <td>{{ ucwords($d->ket) }}</td>
                <td>{{ $d->selisih != null ? $d->selisih." meter" : "Absen disekolah"}}</td>
            </tr>
        @endforeach
    </table>

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
