<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
         with font-awesome or any other icon font library -->
    @if (Auth::user()->level == 'admin')
    <li class="nav-item">
      <a href="{{route('indexadmin')}}" class="nav-link {{ Route::currentRouteName() == 'indexadmin' ? 'active':''}}">
      <i class="fa-solid fa-house"></i>
        <p>
          Dashboard
        </p>
      </a>
    </li>
    <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fa-solid fa-people-roof"></i>
              <p>
                User Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('manajemen')}}" class="nav-link {{ Route::currentRouteName() == 'manajemen' ? 'active':''}}">
                  <i class="fa-brands fa-squarespace"></i>
                  <p>
                    Manajemen
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('jurusan')}}" class="nav-link {{ Route::currentRouteName() == 'jurusan' ? 'active':''}}">
                  <i class="fa-brands fa-squarespace"></i>
                  <p>
                    Jurusan
                  </p>
                </a>
              </li>
      <li class="nav-item">
        <a href="{{route('kelasmgmt')}}" class="nav-link {{ Route::currentRouteName() == 'kelasmgmt' ? 'active':''}}">
        <i class="fa-solid fa-diagram-project"></i>
          <p>
            Kelas
          </p>
        </a>
      </li>

      
      
      <li class="nav-item">
        <a href="{{route('usermgmt')}}" class="nav-link {{ Route::currentRouteName() == 'usermgmt' ? 'active':''}}">
        <i class="fa-solid fa-briefcase"></i>
          <p>
            Staff Management
          </p>
        </a>
      </li>
      
      <li class="nav-item">
  <a href="{{route('datasiswa')}}" class="nav-link {{ Route::currentRouteName() == 'datasiswa' ? 'active':''}}">
  <i class="fa-solid fa-children"></i>
    <p>
      Data Siswa
    </p>
  </a>
  </li>
    </ul>
          </li>
    <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fa-solid fa-fingerprint"></i>
              <p>
                Presensi Karyawan
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            
            <li class="nav-item">
        <a href="{{route('absenkaryawan')}}" class="nav-link {{ Route::currentRouteName() == 'absenkaryawan' ? 'active':''}}">
        <i class="fa-solid fa-file-pen"></i>
          <p>
            Absen
          </p>
        </a>
      </li>

      
      
      <li class="nav-item">
        <a href="{{route('history')}}" class="nav-link {{ Route::currentRouteName() == 'history' ? 'active':''}}">
        <i class="fa-solid fa-clock-rotate-left"></i>
          <p>
            History
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('persentase')}}" class="nav-link {{ Route::currentRouteName() == 'persentase' ? 'active':''}}">
        <i class="fa-solid fa-chart-line"></i>
          <p>
            Persentase
          </p>
        </a>
      </li>


            </ul>
          </li>
    <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fa-solid fa-users-viewfinder"></i>
              <p>
                Presensi Siswa
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

      
      
      <li class="nav-item">
        <a href="{{route('historysiswa')}}" class="nav-link {{ Route::currentRouteName() == 'historysiswa' ? 'active':''}}">
        <i class="fa-solid fa-clock-rotate-left"></i>
          <p>
            History Siswa
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('persentasesiswa')}}" class="nav-link {{ Route::currentRouteName() == 'persentasesiswa' ? 'active':''}}">
        <i class="fa-solid fa-chart-line"></i>
          <p>
            Persentase Siswa
          </p>
        </a>
      </li>


            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fa-brands fa-nfc-directional"></i>
              <p>
                RFID
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('poin')}}" class="nav-link {{ Route::currentRouteName() == 'poin' ? 'active':''}}">
                  <i class="fa-solid fa-star-half-stroke"></i>
                  <p>
                    Poin Siswa
                  </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{route('topupform')}}" class="nav-link {{ Route::currentRouteName() == 'topupform' ? 'active':''}}">
                  <i class="fa-regular fa-money-bill-1"></i>
                  <p>
                    Top Up
                  </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{route('log')}}" class="nav-link {{ Route::currentRouteName() == 'log' ? 'active':''}}">
                  <i class="fa-solid fa-timeline"></i>
                  <p>
                    Log
                  </p>
                </a>
              </li>

            </ul>
          </li>



          <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fa-solid fa-school"></i>
              <p>
                Kurikulum
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('agendamgmt')}}" class="nav-link {{ Route::currentRouteName() == 'agendamgmt' ? 'active':''}}">
              <i class="fa-solid fa-calendar-days"></i>
                <p>
                  Agenda
                </p>
              </a>
            </li>

            

            </ul>
          </li>



            

    @endif
    @if (Auth::user()->level == 'user')
    <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fa-solid fa-fingerprint"></i>
              <p>
                Presensi
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
        <a href="{{route('indexuser')}}" class="nav-link {{ Route::currentRouteName() == 'indexuser' ? 'active':''}}">
        <i class="fa-solid fa-file-pen"></i>
          <p>
            Absen
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('userhistory')}}" class="nav-link {{ Route::currentRouteName() == 'userhistory' ? 'active':''}}">
        <i class="fa-solid fa-clock-rotate-left"></i>
          <p>
            History
          </p>
        </a>
      </li>
      
            </ul>
          </li>
          @if (Auth::user()->id_grup == 6)
          <li class="nav-item">
            <a href="{{route('agendamgmtguru')}}" class="nav-link {{ Route::currentRouteName() == 'agendamgmtguru' ? 'active':''}}">
            <i class="fa-solid fa-calendar-days"></i>
              <p>
                Agenda
              </p>
            </a>
          </li>
          @endif


    
      @endif
    @if (Auth::user()->level == 'piket')
    <li class="nav-item">
        <a href="{{route('indexpiket')}}" class="nav-link {{ Route::currentRouteName() == 'indexpiket' ? 'active':''}}">
        <i class="fa-solid fa-fingerprint"></i>
          <p>
            Absen Karyawan
          </p>
        </a>
      </li>
    <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fa-solid fa-table"></i>
              <p>
                Data Karyawan
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            
            <li class="nav-item">
        <a href="{{route('historypiket')}}" class="nav-link {{ Route::currentRouteName() == 'historypiket' ? 'active':''}}">
        <i class="fa-solid fa-clock-rotate-left"></i>
          <p>
            History Karyawan
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('persentasepiket')}}" class="nav-link {{ Route::currentRouteName() == 'persentasepiket' ? 'active':''}}">
        <i class="fa-solid fa-chart-line"></i>
          <p>
            Persentase Karyawan
          </p>
        </a>
      </li> 
      
            </ul>
          </li>


          <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fa-solid fa-users-viewfinder"></i>
              <p>
                Data Siswa
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            
            

  <li class="nav-item">
  <a href="{{route('datasiswapiket')}}" class="nav-link {{ Route::currentRouteName() == 'datasiswapiket' ? 'active':''}}">
  <i class="fa-solid fa-children"></i>
    <p>
      Data Siswa
    </p>
  </a>
  </li>
  <li class="nav-item">
        <a href="{{route('historysiswapiket')}}" class="nav-link {{ Route::currentRouteName() == 'historysiswapiket' ? 'active':''}}">
        <i class="fa-solid fa-clock-rotate-left"></i>
          <p>
            History Siswa
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('persentasesiswapiket')}}" class="nav-link {{ Route::currentRouteName() == 'persentasesiswapiket' ? 'active':''}}">
        <i class="fa-solid fa-chart-line"></i>
          <p>
            Persentase Siswa
          </p>
        </a>
      </li>

            </ul>
          </li>
    
     
      


    
      @endif
    @if (Auth::user()->level == 'kurikulum')
    <li class="nav-item">
      <a href="{{route('jurusankurikulum')}}" class="nav-link {{ Route::currentRouteName() == 'jurusankurikulum' ? 'active':''}}">
        <i class="fa-brands fa-squarespace"></i>
        <p>
          Jurusan
        </p>
      </a>
    </li>
<li class="nav-item">
<a href="{{route('kelasmgmtkurikulum')}}" class="nav-link {{ Route::currentRouteName() == 'kelasmgmtkurikulum' ? 'active':''}}">
<i class="fa-solid fa-diagram-project"></i>
<p>
  Kelas
</p>
</a>
</li>
    <li class="nav-item">
      <a href="{{route('indexkurikulum')}}" class="nav-link {{ Route::currentRouteName() == 'indexkurikulum' ? 'active':''}}">
      <i class="fa-solid fa-calendar-days"></i>
        <p>
          Agenda
        </p>
      </a>
    </li>
      @endif
      
    @if (Auth::user()->level == 'siswa')
  
    <li class="nav-item">
      <a href="{{route('indexsiswa')}}" class="nav-link {{ Route::currentRouteName() == 'indexsiswa' ? 'active':''}}">
      <i class="fa-solid fa-house"></i>
        <p>
          Dashboard
        </p>
      </a>
    </li>
      @endif

<li class="nav-item">
              <a href="{{route('ubahpassword')}}" class="nav-link {{ Route::currentRouteName() == 'ubahpassword' ? 'active':''}}">
              <i class="fa-solid fa-key"></i>
                <p>
                  Ganti Password
                </p>
              </a>
            </li>
    <li class="nav-item">
      <a href="{{route('logout')}}" class="nav-link">
        <i class="fas fa-sign-out-alt"></i>
        <p>
          Logout
        </p>
      </a>
    </li>
  </ul>
</nav>
