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
<a href="{{route('mapelkurikulum')}}" class="nav-link {{ Route::currentRouteName() == 'mapelkurikulum' ? 'active':''}}">
  <i class="fa-solid fa-book"></i>
  <p>
    Mata Pelajaran
  </p>
</a>
</li>
<li class="nav-item">
<a href="{{route('mapelkelaskurikulum')}}" class="nav-link {{ Route::currentRouteName() == 'mapelkelaskurikulum' ? 'active':''}}">
  <i class="fa-solid fa-swatchbook"></i>
  <p>
    Mapel Kelas
  </p>
</a>
</li>
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
    <li class="nav-item">
      <a href="{{route('konfig')}}" class="nav-link {{ Route::currentRouteName() == 'konfig' ? 'active':''}}">
        <i class="fa-solid fa-gears"></i>
        <p>
          Konfigurasi
        </p>
      </a>
    </li>