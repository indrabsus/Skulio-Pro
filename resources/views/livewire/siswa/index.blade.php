<div>
    <h3>Dashboard</h3>
    <hr>
<div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>Rp. {{number_format($user->saldo)}}</h3>

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
                <h3>{{$user->poin}}</h3>

                <p>Poin</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
               </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{$user->nama_grup}}</h3>

                <p>Kelas</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
               </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{$user->username}}</h3>

                <p>Username</p>
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
