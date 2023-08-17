@extends('layouts.app')
@section('content')
@if (session('gagal'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-times"></i> Gagal!</h5>
            {{ session('gagal') }}
          </div>
    @endif
    
<div class="row justify-content-center">
    <div class="col-lg-6">
    <div id="cekkartu"></div>
    </div>
</div>
<script>
                $(document).ready(function(){
                    setInterval(function(){
                        $("#cekkartu").load("{{route('poingrupscan',['id_ks' => $id, 'sts' => $sts, 'id_kelas' => $id_kelas, 'id_mesin' => $id_mesin])}}")
                    },1000)
                })
            </script>

<script>
    $("#switch").click(function(){
  $.get("{{route('ubahmode')}}", function(data, status){
    console.log('sukses')
  });
});
</script>
@endsection
