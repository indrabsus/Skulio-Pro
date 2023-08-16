<li class="nav-item">
    <a href="{{route('indexkeuangan')}}" class="nav-link {{ Route::currentRouteName() == 'indexkeuangan' ? 'active':''}}">
      <i class="fa-solid fa-hand-holding-dollar"></i>
      <p>
        Data SPP
      </p>
    </a>
  </li>

  <li class="nav-item">
    <a href="{{route('pengajuansubsidikeuangan')}}" class="nav-link {{ Route::currentRouteName() == 'pengajuansubsidikeuangan' ? 'active':''}}">
      <i class="fa-solid fa-code-pull-request"></i>
      <p>
          Pengajuan Subsidi
      </p>
    </a>
  </li>
  <li class="nav-item">
    <a href="{{route('spplogkeuangan')}}" class="nav-link {{ Route::currentRouteName() == 'spplogkeuangan' ? 'active':''}}">
      <i class="fa-solid fa-timeline"></i>
      <p>
          Log SPP
      </p>
    </a>
  </li>