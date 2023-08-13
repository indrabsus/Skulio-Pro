
<div class="row justify-content-center">
    <div class="col-lg-6 text-center">
    <h1>Mode Poin {{ucwords($sts)}}</h1> 
    </div>
</div>
@if ($hitung > 0)
    <div class="row justify-content-center">
        <div class="col-lg-6 text-center">
            <h3>{{$status}}</h3>
        </div>
    </div>
@else
<div class="row justify-content-center">
    <div class="col-lg-6 text-center">
        <h3>Silakan Tempelkan Kartu RFID</h3>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-lg-6 text-center">
        <img src="{{ asset('adminv/assets/img/rfid.png') }}" width="250px">
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-lg-6 text-center">
        <img src="{{ asset('adminv/assets/img/loading.gif') }}" width="250px">
    </div>
</div>
@endif

            
