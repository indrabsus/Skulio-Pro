<li class="nav-item">
    <a href="{{route('indexmanajemen')}}" class="nav-link {{ Route::currentRouteName() == 'indexmanajemen' ? 'active':''}}">
    <i class="fa-solid fa-children"></i>
      <p>
        Data Siswa
      </p>
    </a>
    </li>

    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="fa-solid fa-hard-drive"></i>
        <p>
          RFID Control
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">

        <li class="nav-item">
          <a href="{{route('datamesinmanajemen')}}" class="nav-link {{ Route::currentRouteName() == 'datamesinmanajemen' ? 'active':''}}">
            <i class="fa-solid fa-magnifying-glass-chart"></i>
            <p>
              Data Mesin
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('mesintokenmanajemen')}}" class="nav-link {{ Route::currentRouteName() == 'mesintokenmanajemen' ? 'active':''}}">
            <i class="fa-solid fa-user-astronaut"></i>
            <p>
              Mesin Token
            </p>
          </a>
        </li>

      </ul>
    </li>