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
            <a href="{{route('usermgmtpiket')}}" class="nav-link {{ Route::currentRouteName() == 'usermgmtpiket' ? 'active':''}}">
            <i class="fa-solid fa-briefcase"></i>
              <p>
                Staff Management
              </p>
            </a>
          </li>
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