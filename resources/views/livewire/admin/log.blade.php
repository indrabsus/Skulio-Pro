<div>
    @if(session('sukses'))
    <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-check"></i> Sukses!</h5>
    {{session('sukses')}}
    </div>
    @endif
    <div class="row">
            <div class="col-lg-1 mb-1">
                <select wire:model='result' class="form-control">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div class="col-lg-3 mb-1">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Cari Nama" wire:model="cari">
                    <div class="input-group-append">
                      <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                  </div>
            </div>
    </div>
    <table class="table table-striped">
        <tr>
            <th>Waktu</th>
            <th>Nama</th>
            <th>Status</th>
            <th>Log</th>
            <th>No Ref</th>
            <th>Ket</th>
            <th>Hapus</th>
        </tr>
        <?php $no=1;?>
        @foreach ($data as $d)
            <tr>
                <td>{{ date('d/m/y h:i A', strtotime($d->created_at)) }}</td>
                <td>{{ ucwords($d->name) }}</td>
                <td>{{$d->status}}</td>
                <td>{{number_format($d->total)}}</td>
                <td>{{$d->no_ref}}</td>
                <td>{{$d->keterangan}}</td>
                <td>
                  <a class="btn btn-success btn-sm mb-1" data-toggle="modal" data-target="#edit" wire:click="edit({{ $d->id_log }})"><i class="fa fa-edit"></i></a>
                  <a class="btn btn-danger btn-sm mb-1" data-toggle="modal" data-target="#k_hapus" wire:click="k_hapus({{ $d->id_log }})"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
        @endforeach
    </table>

            {{ $data->links() }}




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
                <label for="">Keterangan</label>
                <input type="text" wire:model="keterangan" class="form-control">
                <div class="text-danger">
                    @error('keterangan')
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
