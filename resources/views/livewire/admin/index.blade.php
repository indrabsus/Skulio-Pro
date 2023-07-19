<div>
    <h3>Dashboard</h3>
    <hr>
<div class="row">
          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>Rp. {{number_format($saldo)}}</h3>

                <p>Saldo</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{$karyawan}}</h3>

                <p>Karyawan</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              </div>
          </div>
          <!-- ./col -->
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{$siswa}}</h3>

                <p>Siswa</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
             </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
</div>
