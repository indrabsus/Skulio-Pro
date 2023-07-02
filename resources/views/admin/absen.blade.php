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
    <form action="{{route('insertsiswa')}}" method="post">
@csrf
               
                <div id="cekkartu"></div>
                
                 
</form>
    </div>
</div>
<script>
                $(document).ready(function(){
                    setInterval(function(){
                        $("#cekkartu").load("{{route('absenscan')}}")
                    },1000)
                })
            </script>
@endsection
