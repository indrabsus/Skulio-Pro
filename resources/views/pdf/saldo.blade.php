<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous"> --}}
    <style>
        body{
            width: 80%;
            margin: auto;
        }
        h3{
            line-height: 1px;
            text-align: center;
        }
        #noref {
            text-align: center;
        }
        #ttd{
            text-align: right;
            margin-bottom: 50px;
        }
        table {
        width: 100%;
        }

        td {
        height: 30px;
        }
        th, td {
        border-bottom: 1px solid #ddd;
        }
    </style>
    <title>Struk Bukti Pembayaran</title>
</head>
<body>
    <h3>Struk Bukti Pembayaran</h3>
    <h3>{{$config->instansi}}</h3>
    <p id="noref">No Ref: {{$data->no_ref}}</p>
    <div class="container">
        
        <table class="table table-sm mt-3">
            <tr>
                <td>Status</td>
                <td>:</td>
                <td>{{ ucwords($data->status) }}</td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{ $data->name }}</td>
            </tr>
            <tr>
                <td>Kelas</td>
                <td>:</td>
                <td>{{ $data->nama_grup }}</td>
            </tr>
            <tr>
                <td>Nominal</td>
                <td>:</td>
                <td>Rp {{number_format($data->total,2,',','.')}}</td>
            </tr>
            <tr>
                <td>Tanggal Bayar</td>
                <td>:</td>
                <td>{{date('d-m-Y h:i A', strtotime($data->updated_at))}}</td>
            </tr>
        </table>
        <p id="ttd">{{ date('d F Y', strtotime(now()))}}</p>
        <p id="ttd">Petugas</p>
    </div>

    

</body>
</html>
                
  
