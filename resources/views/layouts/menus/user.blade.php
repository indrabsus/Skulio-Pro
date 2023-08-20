
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

  @if (Auth::user()->kode >= 1000 && Auth::user()->kode < 2000)
  <li class="nav-item">
    <a href="{{route('agendamgmtguru')}}" class="nav-link {{ Route::currentRouteName() == 'agendamgmtguru' ? 'active':''}}">
    <i class="fa-solid fa-calendar-days"></i>
      <p>
        Agenda
      </p>
    </a>
  </li>
  @endif
  @if (Auth::user()->kode >= 1000 && Auth::user()->kode < 2000)
  <li class="nav-item">
    <a href="{{route('mapelkelasguru')}}" class="nav-link {{ Route::currentRouteName() == 'mapelkelasguru' ? 'active':''}}">
      <i class="fa-solid fa-hand-point-up"></i>
      <p>
        Poin Kelas
      </p>
    </a>
  </li>
  @endif