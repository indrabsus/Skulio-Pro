<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table>
        <tr>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th>Nominal</th>
            <th>Bulan</th>
            <th>Biaya Dll</th>
            <th>Subsidi</th>
            <th>Total</th>
            <th>Tanggal</th>
            <th>No Ref</th>
        </tr>
        @foreach ($data as $d)
            <tr>
               <td>{{ ucwords($d->name) }}</td>
                <td>{{$d->nama_grup}}</td>
                <td>Rp.{{number_format($d->nominal)}}</td>
                <td>{{$d->keterangan}}</td>
                <td>Rp.{{number_format($d->dll)}}</td>
                <td>Rp.{{number_format($d->subsidi)}}</td>
                <td>Rp. {{number_format(($d->bayar * $d->nominal) + $d->dll - $d->subsidi)}}</td>
                <td>{{date('d/m/y h:i', strtotime($d->updated_at))}}</td>
                <td>{{$d->no_ref}}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>