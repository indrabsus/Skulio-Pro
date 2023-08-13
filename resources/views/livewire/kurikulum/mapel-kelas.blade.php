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
    <h5><i class="icon fas fa-check"></i> Gagal!</h5>
    {{session('gagal')}}
    </div>
    @endif
    <div class="row justify-content-between">
      @if (Auth::user()->level == 'admin' || Auth::user()->level == 'kurikulum')
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
                    <input type="text" class="form-control" placeholder="Cari Mapel" wire:model="cari">
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
            @if (Auth::user()->level == 'admin' || Auth::user()->level == 'kurikulum')
            <th>Nama</th>
            @endif
            
            <th>Mata Pelajaran</th>
            <th>Kelas</th>
            <th>Aksi</th>
        </tr>
        <?php $no=1;?>
        @foreach ($data as $d)
            <tr>
                <td>{{ $no++ }}</td>
                @if (Auth::user()->level == 'admin' || Auth::user()->level == 'kurikulum')
                <td>@if ($d->name == NULL)
                  <span class="text-danger">Not SET</span>
              @else
                  {{$d->name}}
              @endif</td>
            @endif
                
                <td>{{ ucwords($d->nama_mapel) }}</td>
                <td>{{ ucwords($d->nama_grup) }}</td>
                <td>
            @if (Auth::user()->level == 'admin' || Auth::user()->level == 'kurikulum')
                    @if ($d->name == NULL)  
                    <a class="btn btn-success btn-sm mb-1" data-toggle="modal" data-target="#edit" wire:click="edit({{ $d->id_ks }})"><i class="fa fa-edit"></i> Edit</a>
                    @else
                    <a class="btn btn-primary btn-sm mb-1" data-toggle="modal" data-target="#set" wire:click="set({{ $d->id_ks }})"><i class="fa fa-edit"></i> Unset</a>
                    @endif
                    <a class="btn btn-danger btn-sm mb-1" data-toggle="modal" data-target="#k_hapus" wire:click="k_hapus({{ $d->id_ks }})"><i class="fa fa-trash"></i></a>
            
            @else
            <a href="{{route('kelasguru',['id_ks' => $d->id_ks])}}" class="btn btn-success btn-sm">Kelas</a>
            <a href="{{route('poingrup',['id_ks' => $d->id_ks, 'sts' => 'plus', 'id_kelas' => $d->id_kelas])}}" class="btn btn-primary btn-sm">Poin +</a>
            <a href="{{route('poingrup',['id_ks' => $d->id_ks, 'sts' => 'minus','id_kelas' => $d->id_kelas])}}" class="btn btn-danger btn-sm">Poin -</a>
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
                <label for="">Nama Guru</label>
                <select class="form-control" wire:model="id_user">
                    <option value="">Pilih Guru</option>
                    @foreach ($guru as $m)
                    <option value="{{$m->id}}">{{$m->name}}</option>
                    @endforeach
                </select>
                <div class="text-danger">
                    @error('id_user')
                        {{$message}}
                    @enderror
                </div>
              </div>
              <div class="form-group">
                <label for="">Mapel</label>
                <select class="form-control" wire:model="id_mapel">
                    <option value="">Pilih Mapel</option>
                    @foreach ($mapel as $m)
                    <option value="{{$m->id_mapel}}">{{$m->nama_mapel}}</option>
                    @endforeach
                </select>
                <div class="text-danger">
                    @error('id_mapel')
                        {{$message}}
                    @enderror
                </div>
              </div>
              <div class="form-group">
                <label for="">Kelas</label>
                <select class="form-control" wire:model="id_kelas">
                    <option value="">Pilih Kelas</option>
                    @foreach ($kelas as $m)
                    <option value="{{$m->id_grup}}">{{$m->nama_grup}}</option>
                    @endforeach
                </select>
                <div class="text-danger">
                    @error('id_kelas')
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
                  <label for="">Nama Guru</label>
                  <select class="form-control" wire:model="id_user">
                      <option value="">Pilih Guru</option>
                      @foreach ($guru as $m)
                      <option value="{{$m->id}}">{{$m->name}}</option>
                      @endforeach
                  </select>
                  <div class="text-danger">
                      @error('id_user')
                          {{$message}}
                      @enderror
                  </div>
                </div>
                <div class="form-group">
                  <label for="">Mapel</label>
                  <select class="form-control" wire:model="id_mapel" disabled>
                      <option value="">Pilih Mapel</option>
                      @foreach ($mapel as $m)
                      <option value="{{$m->id_mapel}}">{{$m->nama_mapel}}</option>
                      @endforeach
                  </select>
                  <div class="text-danger">
                      @error('id_mapel')
                          {{$message}}
                      @enderror
                  </div>
                </div>
                <div class="form-group">
                  <label for="">Kelas</label>
                  <select class="form-control" wire:model="id_kelas" disabled>
                      <option value="">Pilih Kelas</option>
                      @foreach ($kelas as $m)
                      <option value="{{$m->id_grup}}">{{$m->nama_grup}}</option>
                      @endforeach
                  </select>
                  <div class="text-danger">
                      @error('id_kelas')
                          {{$message}}
                      @enderror
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
      <div class="modal fade" id="set" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Delete Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                Apakah Kamu yakin meng Unset data ini?

            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click="upset()">Save changes</button>
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
            $('#set').modal('hide');
        })
      </script>

</div>
