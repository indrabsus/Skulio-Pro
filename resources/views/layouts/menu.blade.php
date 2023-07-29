<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
         with font-awesome or any other icon font library -->

    @if (Auth::user()->level == 'admin')
    @include('layouts.menus.admin')
    @endif


    @if (Auth::user()->level == 'user')
    @include('layouts.menus.user')
      @endif


    @if (Auth::user()->level == 'piket')
    @include('layouts.menus.piket')
      @endif


    @if (Auth::user()->level == 'kurikulum')
    @include('layouts.menus.kurikulum')
      @endif
      
    @if (Auth::user()->level == 'siswa')
  @include('layouts.menus.siswa')
      @endif

<li class="nav-item">
              <a href="{{route('ubahpassword')}}" class="nav-link {{ Route::currentRouteName() == 'ubahpassword' ? 'active':''}}">
              <i class="fa-solid fa-key"></i>
                <p>
                  Ganti Password
                </p>
              </a>
            </li>
    <li class="nav-item">
      <a href="{{route('logout')}}" class="nav-link">
        <i class="fas fa-sign-out-alt"></i>
        <p>
          Logout
        </p>
      </a>
    </li>
  </ul>
</nav>
