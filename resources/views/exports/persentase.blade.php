<table class="table table-striped table-responsive-sm">
        <tr>
            <th>No</th>
            <th>Nama Lengkap</th>
            <th>Hadir</th>
            <th>Kegiatan</th>
            <th>Sakit</th>
            <th>Izin</th>
            <th>Libur</th>
            <th>Total</th>
            <th>Persentase</th>
            <th>Bulan</th>
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
                <td>{{ round(($d->total/$max)*100) }} %</td>
                <td>{{ $d->bulan }}</td>
            </tr>
        @endforeach
    </table>
