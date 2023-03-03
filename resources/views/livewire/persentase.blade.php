<div>
        <div class="row justify-content-end">
            <div class="col-lg-3 mb-1">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="January 2023" wire:model="bulan">
                    <div class="input-group-append">
                      <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                  </div>
            </div>
            <div class="col-lg-2 mb-1">
                <select wire:model='role' class="form-control">
                    <option value="">Pilih Jabatan</option>
                    <option value="guru">Guru</option>
                    <option value="tendik">Tendik</option>
                    <option value="siswa">Siswa</option>
                </select>
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
    <table class="table table-striped table-responsive-sm">
        <tr>
            <th>No</th>
            <th>Nama Guru</th>
            <th>Hadir</th>
            <th>Kegiatan</th>
            <th>Sakit</th>
            <th>Izin</th>
            <th>Libur</th>
            <th>Total</th>
            <th>Bulan</th>
            <th>Jabatan</th>
        </tr>
        <?php $no=1; ?>
        @foreach ($data as $d)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $d->name }}</td>
                <td>{{ $d->hadir }}</td>
                <td>{{ $d->kegiatan }}</td>
                <td>{{ $d->sakit }}</td>
                <td>{{ $d->izin }}</td>
                <td>{{ $d->nojadwal }}</td>
                <td>{{ $d->hadir + $d->kegiatan + $d->nojadwal}}</td>
                <td>{{ $d->bulan }}</td>
                <td>{{ ucwords($d->jabatan) }}</td>
            </tr>
        @endforeach
    </table>
    {{ $data->links() }}
</div>
