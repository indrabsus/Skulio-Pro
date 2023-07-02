@if($mode->mode == 1)
<div class="row justify-content-center">
    <div class="col-lg-6 text-center">
    <h1>Mode Absen</h1> 
    </div>
</div>
@elseif($mode->mode == 2)
<div class="row justify-content-center">
    <div class="col-lg-6 text-center">
    <h1>Mode Poin</h1> 
    </div>
</div>
@endif


@if ($status == 1)
<div class="row justify-content-center">
    <div class="col-lg-6 text-center">
    <h1>Absen Berhasil</h1> 
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-lg-6 text-center">
    <h1>{{$user->name}}</h1> 
    </div>
</div>
@elseif($status == 0)
<div class="row justify-content-center">
    <div class="col-lg-6 text-center">
        <h1>Data User Tidak Ada</h1>
    </div>
</div>
@elseif($status == 3) 
    <div class="row justify-content-center">
        <div class="col-lg-6 text-center">
            <h1>Anda sudah absen hari ini!</h1>
        </div>
    </div>
@elseif($status == 4) 
    <div class="row justify-content-center">
        <div class="col-lg-6 text-center">
            <h1>{{$user->name}} menambah +1 Poin</h1>
            <h1>Poin anda : {{$poin->poin}}</h1>
        </div>
    </div>

@elseif($status == 2)
<div class="row justify-content-center">
    <div class="col-lg-6 text-center">
        <h3>Silakan Tempelkan Kartu RFID</h3>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-lg-6 text-center">
        <img src="{{ asset('img/rfid.png') }}" width="250px">
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-lg-6 text-center">
        <img src="{{ asset('img/loading.gif') }}" width="250px">
    </div>
</div>
@endif
            
