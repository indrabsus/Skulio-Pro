<div>
    @if(session('sukses'))
    <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-check"></i> Sukses!</h5>
    {{session('sukses')}}
    </div>
    @endif
    @if (session('gagal'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-times"></i> Gagal!</h5>
            {{ session('gagal') }}
          </div>
    @endif
        <div class="row justify-content-end">
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
            <th>No</th>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th>Pengajuan Subsidi</th>
            <th>Tgl Pengajuan</th>
            <th>Tgl Proses</th>
            <th>Aksi</th>
        </tr>
        <?php $no=1;?>
        @foreach ($data as $d)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ ucwords($d->name) }}</td>
                <td>{{$d->nama_grup}}</td>
                <td>Rp.{{number_format($d->subsidi)}}</td>
                <td>{{date('d F Y h:i', strtotime($d->created_at))}}</td>
                <td>{{$d->created_at == $d->updated_at ? "Belum diproses" : date('d F Y h:i', strtotime($d->updated_at))}}</td>
                <td><button class="btn btn-{{$d->sts == 'n' ? 'success' : 'primary'}} btn-sm mb-1" data-toggle="modal" data-target="#k_proses" wire:click="k_proses({{ $d->id_req }})" {{$d->sts == 'n' ? '' : 'disabled'}}><i class="fa-solid fa-code-pull-request"></i> {{$d->sts == 'n' ? 'Proses' : 'Selesai'}}</button>
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
                <label for="">Jabatan</label>
                <input type="text" wire:model="nama_grup" class="form-control">
                <div class="text-danger">
                    @error('nama_grup')
                        {{$message}}
                    @enderror
                </div>
              </div>
              <div class="form-group">
                <label for="">Keterangan</label>
                <select wire:model="kode_grup" class="form-control">
                  <option value="">Pilih Opsi</option>
                 
                </select>
                <div class="text-danger">
                    @error('kode_grup')
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
                <label for="">Jabatan</label>
                <input type="text" wire:model="nama_grup" class="form-control">
                <div class="text-danger">
                    @error('nama_grup')
                        {{$message}}
                    @enderror
                </div>
              </div>
              <div class="form-group">
                <label for="">Keterangan</label>
                <select wire:model="kode_grup" class="form-control">
                  <option value="">Pilih Opsi</option>
                  
                </select>
                <div class="text-danger">
                    @error('kode_grup')
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


      <div class="modal fade" id="k_proses" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Bayar SPP</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="">Nama</label>
                <input type="text" wire:model="nama" class="form-control" readonly>
              </div>
              <label for="">Pembayaran Terakhir</label>
              <div class="row">
                <div class="col-lg-4">
                  <div class="form-group">
                   
                    <input type="text" wire:model="bulan" class="form-control" readonly>
                  </div>
                </div>
                <div class="col-lg-8">
                  <div class="form-group">
                    <input type="text" wire:model="angkatan" class="form-control" readonly>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="">SPP</label>
                <select wire:model="bayar" class="form-control">
                  <option value="">Berapa bulan?</option>
                  <option value="1">1 Bulan</option>
                  <option value="2">2 Bulan</option>
                  <option value="3">3 Bulan</option>
                  <option value="4">4 Bulan</option>
                  <option value="5">5 Bulan</option>
                  <option value="6">6 Bulan</option>
                </select>
                <div class="text-danger">
                  @error('bayar')
                  {{$message}}
                  @enderror
                </div>
              </div>

              <div class="form-group">
                <label for="">Nominal</label>
                <select wire:model="nominal" class="form-control">
                  <option value="">Pilih Nominal</option>
                  <option value="{{$nom->x_spp}}">Kelas 1 Rp.{{ number_format($nom->x_spp) }}</option>
                  <option value="{{$nom->xi_spp}}">Kelas 2 Rp.{{ number_format($nom->xi_spp) }}</option>
                  <option value="{{$nom->xii_spp}}">Kelas 3 Rp.{{ number_format($nom->xii_spp) }}</option>
                </select>
                <div class="text-danger">
                  @error('nominal')
                  {{$message}}
                  @enderror
                </div>
              </div>
              <div class="form-group">
                
                <div class="row">
                  <div class="col-lg-6">
                    <label for="">Biaya Lainnya</label>
                    <input type="number" wire:model="dll" class="form-control">
                  </div>
                  <div class="text-danger">
                    @error('dll')
                    {{$message}}
                    @enderror
                  </div>
                  <div class="col-lg-6">
                    <label for="">Subsidi</label>
                    <input type="number" wire:model="subsidi" class="form-control">
                  </div>
                  <div class="text-danger">
                    @error('subsidi')
                    {{$message}}
                    @enderror
                  </div>
                </div>
                
              </div>

              <div class="form-group">
                <label for="">No Ref</label>
                <div class="row">
                  <div class="col-lg-8">
                    <input type="text" wire:model="noref" class="form-control" readonly>
                  </div>
                  <div class="col-lg-4">
                    <input type="number" wire:model="ref" class="form-control">
                  </div>
                </div>
                <div class="text-danger">
                  @error('ref')
                  {{$message}}
                  @enderror
                </div>
              </div>
              
              
            </div>
            
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click="proses()">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->


      <div class="modal fade" id="k_req" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Request Subsidi</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="">Nama</label>
                <input type="text" wire:model="nama" class="form-control" readonly>
              </div>
              <label for="">Pembayaran Terakhir</label>
              <div class="row">
                <div class="col-lg-4">
                  <div class="form-group">
                   
                    <input type="text" wire:model="bulan" class="form-control" readonly>
                  </div>
                </div>
                <div class="col-lg-8">
                  <div class="form-group">
                    <input type="text" wire:model="angkatan" class="form-control" readonly>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="">SPP</label>
                <select wire:model="bayar" class="form-control">
                  <option value="">Berapa bulan?</option>
                  <option value="1">1 Bulan</option>
                  <option value="2">2 Bulan</option>
                  <option value="3">3 Bulan</option>
                  <option value="4">4 Bulan</option>
                  <option value="5">5 Bulan</option>
                  <option value="6">6 Bulan</option>
                </select>
                <div class="text-danger">
                  @error('bayar')
                  {{$message}}
                  @enderror
                </div>
              </div>

              <div class="form-group">
                  <div class="col-lg-6">
                    <label for="">Subsidi</label>
                    <input type="number" wire:model="subsidi" class="form-control">
                  </div>
                  <div class="text-danger">
                    @error('subsidi')
                    {{$message}}
                    @enderror
                  </div>
                
                </div>
              
              
            </div>
            
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click="req()">Save changes</button>
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
            $('#k_proses').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#k_req').modal('hide');
        })
      </script>

</div>
