<li class="nav-item">
    <a href="{{route('indexkesiswaan')}}" class="nav-link {{ Route::currentRouteName() == 'indexkesiswaan' ? 'active':''}}">
    <i class="fa-solid fa-children"></i>
      <p>
        Data Siswa
      </p>
    </a>
    </li>

    <li class="nav-item">
        <a href="{{route('poinkesiswaan')}}" class="nav-link {{ Route::currentRouteName() == 'poinkesiswaan' ? 'active':''}}">
          <i class="fa-solid fa-star-half-stroke"></i>
          <p>
            Poin Siswa
          </p>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{route('logkesiswaan')}}" class="nav-link {{ Route::currentRouteName() == 'logkesiswaan' ? 'active':''}}">
          <i class="fa-solid fa-timeline"></i>
          <p>
            Log Poin
          </p>
        </a>
      </li>