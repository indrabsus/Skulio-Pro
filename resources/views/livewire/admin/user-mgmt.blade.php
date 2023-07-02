<div>
    @if(session('sukses'))
    <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-check"></i> Sukses!</h5>
    {{session('sukses')}}
    </div>
    @endif
    <div class="row justify-content-between">
        <div class="col-lg-3">
            <a class="btn btn-primary btn-sm mb-3" data-toggle="modal" data-target="#add"><i class="fa fa-plus"> </i> Tambah</a>
        </div>
        <div class="row justify-content-end">
            <div class="col-lg-4 mb-1">
                <select wire:model='role' class="form-control">
                    <option value="">Pilih Jabatan</option>
                    @foreach ($jbtn as $d)
                        <option value="{{ $d->nama_grup }}">{{ $d->nama_grup }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2 mb-1">
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
            <th>Kode</th>
            <th>Nama Lengkap</th>
            <th>Username</th>
            <th>Jabatan</th>
            <th>Aksi</th>
        </tr>
        <?php $no=1;?>
        @foreach ($data as $d)
            <tr>
                <td>{{ $d->kode }}</td>
                <td>{{ $d->name }}</td>
                <td>{{ $d->username }}</td>
                <td>{{ ucwords($d->nama_grup) }}</td>
                <td><a class="btn btn-success btn-sm mb-1" data-toggle="modal" data-target="#edit" wire:click="edit({{ $d->id }})"><i class="fa fa-edit"></i></a>
                    <a class="btn btn-danger btn-sm mb-1" data-toggle="modal" data-target="#k_hapus" wire:click="k_hapus({{ $d->id }})"><i class="fa fa-trash"></i></a>
                    <a class="btn btn-dark btn-sm mb-1" data-toggle="modal" data-target="#k_reset" wire:click="k_reset({{ $d->id }})"><i class="fa fa-cogs"></i> Reset</a>
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
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="">Kode</label>
                        <input type="number" wire:model="kode" class="form-control">
                        <div class="text-danger">
                            @error('kode')
                                {{$message}}
                            @enderror
                        </div>
                      </div>
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
                <label for="">Username</label>
                <input type="text" wire:model="username" class="form-control">
                <div class="text-danger">
                    @error('username')
                        {{$message}}
                    @enderror
                </div>
              </div>
              <div class="form-group">
                <label for="">Jabatan</label>
                <select wire:model="id_grup" class="form-control">
                    <option value="">Pilih Jabatan</option>
                    @foreach ($jbtn as $d)
                        <option value="{{ $d->id_grup }}">{{ $d->nama_grup }}</option>
                    @endforeach
                </select>
                <div class="text-danger">
                    @error('id_grup')
                        {{$message}}
                    @enderror
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary suksestambah" wire:click="insert()">Save changes</button>
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
                <label for="">Nama Lengkap</label>
                <input type="text" wire:model="name" class="form-control">
                <div class="text-danger">
                    @error('name')
                        {{$message}}
                    @enderror
                </div>
              </div>
              <div class="form-group">
                <label for="">Username</label>
                <input type="text" wire:model="username" class="form-control" disabled>
                <div class="text-danger">
                    @error('username')
                        {{$message}}
                    @enderror
                </div>
              </div>
              <div class="form-group">
                <label for="">Jabatan</label>
                <select wire:model="id_grup" class="form-control">
                  <option value="">Pilih Jabatan</option>
                  @foreach ($jbtn as $d)
                      <option value="{{ $d->id_grup }}">{{ $d->nama_grup }}</option>
                  @endforeach
                </select>
                <div class="text-danger">
                    @error('id_grup')
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
                <p>Dengan me Reset Password, user ini akan menggunakan password "rahasia" tanpa tanda kutip</p>

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
            $('#add').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#edit').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#k_hapus').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#k_reset').modal('hide');
        })
      </script>

</div>
