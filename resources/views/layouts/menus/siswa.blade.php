<li class="nav-item">
    <a href="{{route('indexsiswa')}}" class="nav-link {{ Route::currentRouteName() == 'indexsiswa' ? 'active':''}}">
    <i class="fa-solid fa-house"></i>
      <p>
        Dashboard
      </p>
    </a>
  </li>
<li class="nav-item">
    <a href="{{route('siswadata')}}" class="nav-link {{ Route::currentRouteName() == 'siswadata' ? 'active':''}}">
      <i class="fa-solid fa-file-shield"></i>
      <p>
        Data Siswa
      </p>
    </a>
  </li>
  <li class="nav-item">
    <a href="{{route('mapelkelassiswa')}}" class="nav-link {{ Route::currentRouteName() == 'mapelkelassiswa' ? 'active':''}}">
      <i class="fa-solid fa-swatchbook"></i>
      <p>
        Poin Mapel
      </p>
    </a>
  </li>
  <li class="nav-item">
    <a href="{{route('historysiswa2')}}" class="nav-link {{ Route::currentRouteName() == 'historysiswa2' ? 'active':''}}">
    <i class="fa-solid fa-clock-rotate-left"></i>
      <p>
        History Absen
      </p>
    </a>
  </li>