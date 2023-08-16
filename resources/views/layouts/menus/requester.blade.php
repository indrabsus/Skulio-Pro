<li class="nav-item">
    <a href="{{route('indexrequester')}}" class="nav-link {{ Route::currentRouteName() == 'indexrequester' ? 'active':''}}">
      <i class="fa-solid fa-hand-holding-dollar"></i>
      <p>
        Data SPP
      </p>
    </a>
  </li>

  <li class="nav-item">
    <a href="{{route('pengajuansubsidirequester')}}" class="nav-link {{ Route::currentRouteName() == 'pengajuansubsidirequester' ? 'active':''}}">
      <i class="fa-solid fa-code-pull-request"></i>
      <p>
          Pengajuan Subsidi
      </p>
    </a>
  </li>