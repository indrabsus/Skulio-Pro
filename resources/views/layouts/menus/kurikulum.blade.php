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