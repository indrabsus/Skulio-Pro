<div class="form-group">
    <label for="">No Kartu</label>
    <input type="text" name="kode" value="{{$scan}}" class="form-control" placeholder="Tempelkan Kartu!" readonly>
    <div class="text-danger">
                    @error('kode')
                        {{$message}}
                    @enderror
                </div>
</div>
<div class="form-group">
    <label for="">Nama</label>
    <input type="text" name="name" value="{{$nama}}" class="form-control" readonly>
    <div class="text-danger">
                    @error('name')
                        {{$message}}
                    @enderror
                </div>
</div>
<div class="form-group">
    <label for="">No Reff</label>
    <input type="text" name="no_ref" value="{{$noref}}" class="form-control" readonly>
    <div class="text-danger">
                    @error('no_ref')
                        {{$message}}
                    @enderror
                </div>
</div>
<div class="form-group">
    <label for="">Saldo Sekarang</label>
    <input type="text" name="saldos" value="{{$saldo}}" class="form-control" readonly hidden>
    <div>Rp. {{number_format($saldo)}}</div>
    <div class="text-danger">
                    @error('saldos')
                        {{$message}}
                    @enderror
                </div>
</div>