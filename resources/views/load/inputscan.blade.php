<div class="form-group">
    <label for="">No Kartu</label>
    <input type="text" name="kode" value="{{$scan}}" class="form-control" placeholder="Tempelkan Kartu!" readonly>
    <div class="text-danger">
                    @error('kode')
                        {{$message}}
                    @enderror
                </div>
</div>