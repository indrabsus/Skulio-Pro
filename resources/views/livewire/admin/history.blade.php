<div>
        <div class="row justify-content-end">
            <div class="col-lg-3 mb-1">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="2023-24-02" wire:model="tanggal">
                    <div class="input-group-append">
                      <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                  </div>
            </div>
            @if (Auth::user()->level == 'admin')
            <div class="col-lg-2 mb-1">
                <select wire:model='role' class="form-control">
                    <option value="">Pilih Jabatan</option>
                    <option value="guru">Guru</option>
                    <option value="tendik">Tendik</option>
                    <option value="siswa">Siswa</option>
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
        </tr>
        <?php $no=1; ?>
        @foreach ($data as $d)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $d->name }}</td>
                @if (Auth::user()->level == 'admin')
                <td>{{ ucwords($d->jabatan) }}</td>
                @endif
                <td>{{ $d->tanggal }}</td>
                <td>{{ $d->waktu }}</td>
                <td>{{ ucwords($d->ket) }}</td>
            </tr>
        @endforeach
    </table>
</div>
