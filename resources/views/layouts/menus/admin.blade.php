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
                <i class="fa-solid fa-paperclip"></i>
                <p>
                  Manajemen
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
            <li class="nav-item">
              <a href="{{route('logsaldo')}}" class="nav-link {{ Route::currentRouteName() == 'logsaldo' ? 'active':''}}">
                <i class="fa-solid fa-timeline"></i>
                <p>
                  Log Saldo
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
            <a href="{{route('mapel')}}" class="nav-link {{ Route::currentRouteName() == 'mapel' ? 'active':''}}">
              <i class="fa-solid fa-book"></i>
              <p>
                Mata Pelajaran
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('mapelkelas')}}" class="nav-link {{ Route::currentRouteName() == 'mapelkelas' ? 'active':''}}">
              <i class="fa-solid fa-swatchbook"></i>
              <p>
                Mapel Kelas
              </p>
            </a>
          </li>

          

          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fa-solid fa-money-bill-transfer"></i>
            <p>
              SPP
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{route('dataspp')}}" class="nav-link {{ Route::currentRouteName() == 'dataspp' ? 'active':''}}">
              <i class="fa-solid fa-hand-holding-dollar"></i>
              <p>
                Data SPP
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('pengajuansubsidi')}}" class="nav-link {{ Route::currentRouteName() == 'pengajuansubsidi' ? 'active':''}}">
              <i class="fa-solid fa-code-pull-request"></i>
              <p>
                  Pengajuan Subsidi
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('spplog')}}" class="nav-link {{ Route::currentRouteName() == 'spplog' ? 'active':''}}">
              <i class="fa-solid fa-timeline"></i>
              <p>
                  Log SPP
              </p>
            </a>
          </li>

          

          </ul>
        </li>

        <li class="nav-item">
          <a href="{{route('konfig')}}" class="nav-link {{ Route::currentRouteName() == 'konfig' ? 'active':''}}">
            <i class="fa-solid fa-gears"></i>
            <p>
              Konfigurasi
            </p>
          </a>
        </li>