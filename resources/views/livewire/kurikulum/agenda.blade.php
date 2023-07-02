<div>
    @if(session('sukses'))
    <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-check"></i> Sukses!</h5>
    {{session('sukses')}}
    </div>
    @endif
    @if(session('gagal'))
    <div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-times"></i> Gagal!</h5>
    {{session('gagal')}}
    </div>
    @endif
    <div class="row">
        @if (Auth::user()->id_grup == 6)
        <div class="col-lg-3">
            <a class="btn btn-primary btn-sm mb-3" data-toggle="modal" data-target="#add"><i class="fa fa-plus"> </i> Tambah</a>
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
        <div class="col-lg-2 mb-1">
            <input type="date" wire:model="caritgl" class="form-control">
        </div>
            <div class="col-lg-3 mb-1">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Cari Kelas" wire:model="cari">
                    <div class="input-group-append">
                      <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                  </div>
            </div>
    </div>
    <table class="table table-striped">
        <tr>
            <th>No</th>
            <th>Materi</th>
            <th>Kelas</th>
            <th>Guru</th>
            <th>Jam ke</th>
            <th>Tanggal</th>
            @if (Auth::user()->id_grup == 6)
            <th>Aksi</th>
            @endif
        </tr>
        <?php $no=1;?>
        @foreach ($data as $d)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $d->materi }}</td>
                <td>{{ $d->nama_grup }}</td>
                <td>{{ $d->name }}</td>
                <td>{{ $d->jam_awal }} - {{ $d->jam_akhir }}</td>
                <td>{{date('l, d M Y - h:i A', strtotime($d->created_at))}}</td>
                @if (Auth::user()->id_grup == 6)
                <td>
                    <a class="btn btn-success btn-sm mb-1" data-toggle="modal" data-target="#edit" wire:click="edit({{ $d->id_agenda }})"><i class="fa fa-edit"></i></a>
                    <a class="btn btn-danger btn-sm mb-1" data-toggle="modal" data-target="#k_hapus" wire:click="k_hapus({{ $d->id_agenda }})"><i class="fa fa-trash"></i></a>
                </td>
                @endif
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
                <label for="">Materi</label>
                <input type="text" wire:model="materi" class="form-control">
                <div class="text-danger">
                    @error('materi')
                        {{$message}}
                    @enderror
                </div>
              </div>
            
              <div class="form-group">
                <label for="">Kelas</label>
                <select wire:model="id_grup" class="form-control">
                    <option value="">Pilih Kelas</option>
                    @foreach ($kelas as $k)
                        <option value="{{$k->id_grup}}">{{$k->nama_grup}}</option>
                    @endforeach
                </select>
                <div class="text-danger">
                    @error('id_grup')
                        {{$message}}
                    @enderror
                </div>
              </div>
            <div class="row">
                <div class="col-lg-6">
                        <div class="form-group">
                          <label for="">Jam ke</label>
                          <div class="row">
                            <div class="col-lg-6">
                                <input type="number" wire:model="jam_awal" class="form-control">
                                    <div class="text-danger">
                                        @error('jam_awal')
                                            {{$message}}
                                        @enderror
                                    </div>
                            </div>
                            <div class="col-lg-6">
                                <input type="number" wire:model="jam_akhir" class="form-control">
                                    <div class="text-danger">
                                        @error('jam_akhir')
                                            {{$message}}
                                        @enderror
                                    </div>
                            </div>
                          </div>
                        </div>
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
                  <label for="">Materi</label>
                  <input type="text" wire:model="materi" class="form-control">
                  <div class="text-danger">
                      @error('materi')
                          {{$message}}
                      @enderror
                  </div>
                </div>
              
                <div class="form-group">
                <label for="">Kelas</label>
                <select wire:model="id_grup" class="form-control">
                    <option value="">Pilih Kelas</option>
                    @foreach ($kelas as $k)
                        <option value="{{$k->id_grup}}">{{$k->nama_grup}}</option>
                    @endforeach
                </select>
                <div class="text-danger">
                    @error('id_grup')
                        {{$message}}
                    @enderror
                </div>
              </div>
              <div class="row">
                  <div class="col-lg-6">
                          <div class="form-group">
                            <label for="">Jam ke</label>
                            <div class="row">
                              <div class="col-lg-6">
                                  <input type="number" wire:model="jam_awal" class="form-control">
                                      <div class="text-danger">
                                          @error('jam_awal')
                                              {{$message}}
                                          @enderror
                                      </div>
                              </div>
                              <div class="col-lg-6">
                                  <input type="number" wire:model="jam_akhir" class="form-control">
                                      <div class="text-danger">
                                          @error('jam_akhir')
                                              {{$message}}
                                          @enderror
                                      </div>
                              </div>
                            </div>
                          </div>
                  </div>
              </div>
          </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary suksestambah" wire:click="update()">Save changes</button>
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
      </script>

</div>
