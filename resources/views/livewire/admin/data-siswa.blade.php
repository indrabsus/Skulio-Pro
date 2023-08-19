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
        <a href="" class="btn btn-primary btn-sm mb-3" href="{{route('addsiswa')}}"><i class="fa-brands fa-nfc-symbol"></i> Tambah</a>
    </div>
    @endif
      @if(Auth::user()->level == 'admin' || Auth::user()->level == 'manajemen')
      <div class="col-lg-3">
        <a class="btn btn-primary btn-sm mb-3" data-toggle="modal" data-target="#add"><i class="fa fa-plus"> </i> Tambah</a>
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
        <th>No Va</th>
        @if(Auth::user()->level == 'admin' || Auth::user()->level == 'piket')
        <th>Absen</th>
        @endif
        @if(Auth::user()->level == 'admin' || Auth::user()->level == 'kesiswaan')
        <th>Poin</th>
        @endif
        @if(Auth::user()->level == 'admin')
        <th>No RFID</th>
        <th>Username</th>
        <th>Saldo</th>
        <th>Acc</th>
        @endif
        <th>Aksi</th>
        </tr>
        <?php $no=1;?>
        @foreach ($data as $d)
            <tr>
                <td>{{ $no++ }}</td>
                <td><a href="" data-toggle="modal" data-target="#edit" wire:click="edit({{ $d->id }})">{{ ucwords($d->name) }}</a></td>
                <td>{{$d->nama_grup}}</td>
                <td>{{$d->no_va}}</td>
                @if(Auth::user()->level == 'admin' || Auth::user()->level == 'piket')
                <td><a class="btn btn-primary btn-sm mb-1" data-toggle="modal" data-target="#absen" wire:click="absen({{ $d->id }})"><i class="fa-solid fa-square-pen"></i></i></a></td>
                @endif
                @if(Auth::user()->level == 'admin' || Auth::user()->level == 'kesiswaan')
                <td>{{$d->poin}}</td>
                @endif
                
                @if(Auth::user()->level == 'admin')
                <td><a href="http://skulio.my.id/poingrup/{{$d->kode}}/batara1001" target="_blank">{{$d->kode}}</a></td>
                <td>{{$d->username}}</td>
                <td>Rp. {{number_format($d->saldo)}}</td>
                <td>
                  @if ($d->acc == 'y')
                  <a class="btn btn-success btn-sm" wire:click="changeAcc({{$d->id}})"><i class="fa-solid fa-check"></i></a>
                  @else
                  <a class="btn btn-danger btn-sm" wire:click="changeAcc({{$d->id}})"><i class="fa-solid fa-xmark"></i></a>
                  @endif
                </td>
                @endif
                <td>
                  @if(Auth::user()->level == 'admin')
                  <a class="btn btn-success btn-sm mb-1" href="{{route('editsiswa',['id' => $d->id])}}"><i class="fa fa-edit"></i></a>  
                  @endif
                  @if(Auth::user()->level == 'admin' || Auth::user()->level == 'manajemen')
                  <a class="btn btn-dark btn-sm mb-1" data-toggle="modal" data-target="#k_reset" wire:click="k_reset({{ $d->id }})"><i class="fa fa-cogs"></i> Reset</a>
                  <a class="btn btn-danger btn-sm mb-1" data-toggle="modal" data-target="#k_hapus" wire:click="k_hapus({{ $d->id }})"><i class="fa fa-trash"></i></a>
                  @endif
                </td>
            </tr>
        @endforeach
    </table>

            {{ $data->links() }}

            <div class="modal fade" id="add" wire:ignore.self>
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Add Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="form-group">
                      <label for="">NIS</label>
                      <input type="text" wire:model="nis" class="form-control">
                      <div class="text-danger">
                          @error('nis')
                              {{$message}}
                          @enderror
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="">Nama Lengkap</label>
                      <input type="text" wire:model="name" class="form-control">
                      <div class="text-danger">
                          @error('name')
                              {{$message}}
                          @enderror
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="">Jenis Kelamin</label>
                      <select wire:model="jenkel" class="form-control">
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
                      <select wire:model="id_grup" class="form-control">
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
                      <input type="number" class="form-control" placeholder="No Handphone" wire:model="nohp" >
                      <div class="text-danger">
                          @error('nohp')
                              {{$message}}
                          @enderror
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="nohp">No Virtual Account</label>
                      <input type="number" class="form-control" placeholder="Boleh dikosongkan" wire:model="no_va">
                      <div class="text-danger">
                          @error('no_va')
                              {{$message}}
                          @enderror
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click="insert()">Save changes</button>
                  </div>
                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->

            <div class="modal fade" id="edit" wire:ignore.self>
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Edit Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="form-group">
                      <label for="">NIS</label>
                      <input type="text" wire:model="nis" class="form-control">
                      <div class="text-danger">
                          @error('nis')
                              {{$message}}
                          @enderror
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="">Nama Lengkap</label>
                      <input type="text" wire:model="name" class="form-control">
                      <div class="text-danger">
                          @error('name')
                              {{$message}}
                          @enderror
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="">Jenis Kelamin</label>
                      <select wire:model="jenkel" class="form-control">
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
                      <select wire:model="id_grup" class="form-control">
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
                      <input type="number" class="form-control" placeholder="No Handphone" wire:model="nohp" >
                      <div class="text-danger">
                          @error('nohp')
                              {{$message}}
                          @enderror
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="nohp">No Virtual Account</label>
                      <input type="number" class="form-control" placeholder="Boleh dikosongkan" wire:model="no_va">
                      <div class="text-danger">
                          @error('no_va')
                              {{$message}}
                          @enderror
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click="update()">Save changes</button>
                  </div>
                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->

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
        window.addEventListener('closeModal', event => {
            $('#add').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#edit').modal('hide');
        })
      </script>

</div>
