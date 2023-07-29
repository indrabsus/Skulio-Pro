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