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
          <div class="col-lg-4 mb-1">
            <div class="input-group mb-3">
              <select class="form-control" wire:model="thn">
                <option value="">Pilih Tahun</option>
                <option value="{{date('Y') - 1}}">{{date('Y') - 1}}</option>
                <option value="{{date('Y')}}">{{date('Y')}}</option>
                <option value="{{date('Y') + 1}}">{{date('Y') + 1}}</option>
              </select>
              <select class="form-control" wire:model="bln">
                <option value="">Pilih Bulan</option>
                <option value="01">Januari</option>
                <option value="02">Februari</option>
                <option value="03">Maret</option>
                <option value="04">April</option>
                <option value="05">Mei</option>
                <option value="06">Juni</option>
                <option value="07">Juli</option>
                <option value="08">Agustus</option>
                <option value="09">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
              </select>
                <div class="input-group-append">
                  <a href="{{route('spplogxls',['thn' => $thn, 'bln' => $bln])}}" class="input-group-text"><i class="fas fa-print"></i></a>
                </div>
              </div>
        </div>

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
    <table class="table table-responsive">
        <tr>
            <th>Cetak</th>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th>Nominal</th>
            <th>Bulan</th>
            <th>Biaya Dll</th>
            <th>Subsidi</th>
            <th>Total</th>
            <th>Tanggal</th>
            <th>No Ref</th>
            <th>Aksi</th>
        </tr>
        <?php $no=1;?>
        @foreach ($data as $d)
            <tr>
              <td><a href="{{route('invoicespp',['id' => $d->id_log])}}" target="_blank"><i class="fa-solid fa-print"></i></a></td>
                <td>{{ ucwords($d->name) }}</td>
                <td>{{$d->nama_grup}}</td>
                <td>Rp.{{number_format($d->nominal)}}</td>
                <td>{{$d->keterangan}}</td>
                <td>Rp.{{number_format($d->dll)}}</td>
                <td>Rp.{{number_format($d->subsidi)}}</td>
                <td>Rp. {{number_format(($d->bayar * $d->nominal) + $d->dll - $d->subsidi)}}</td>
                <td>{{date('d/m/y h:i', strtotime($d->updated_at))}}</td>
                <td>{{$d->no_ref}}</td>
                <td>
                  <button class="btn btn-success btn-sm mb-1" data-toggle="modal" data-target="#k_edit" wire:click="k_edit({{ $d->id_log }})">Edit</button>
                  <button class="btn btn-danger btn-sm mb-1" data-toggle="modal" data-target="#k_hapus" wire:click="k_hapus({{ $d->id_log }})">Hapus</button>
                </td>
            </tr>
        @endforeach
    </table>

            {{ $data->links() }}

    

      


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


      <div class="modal fade" id="k_edit" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit SPP</h4>
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
                <label for="">Nominal</label>
                <input type="text" wire:model="nominal" class="form-control">
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
            $('#k_edit').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#k_req').modal('hide');
        })
      </script>

</div>
