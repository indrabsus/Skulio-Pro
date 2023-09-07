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
                <td>{{$d->nominal}}</td>
                <td>{{$d->keterangan}}</td>
                <td>{{$d->dll}}</td>
                <td>{{$d->subsidi}}</td>
                <td>{{($d->bayar * $d->nominal) + $d->dll - $d->subsidi}}</td>
                <td>{{date('d/m/y h:i', strtotime($d->updated_at))}}</td>
                <td>{{$d->no_ref}}</td>
            </tr>
        @endforeach
        <tr></tr>
        <tr>
            <td>SPP</td><td>Rp. {{number_format($spp,0,',',',')}}</td> 
        </tr>
        <tr>
            <td>Biaya Lainnya</td><td>Rp. {{number_format($dll,0,',',',')}}</td>
        </tr>
        <tr>
            <td>Subsidi</td><td>Rp. {{number_format($subsidi,0,',',',')}}</td>
        </tr>
        <tr>
            <td>Total Uang SPP</td><td>Rp. {{number_format($spp + $dll - $subsidi,0,',',',')}}</td>
        </tr>
    </table>
    
</body>
</html>