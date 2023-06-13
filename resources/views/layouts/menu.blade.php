<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
         with font-awesome or any other icon font library -->
    @if (Auth::user()->level == 'admin')
    <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Presensi
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
        <a href="{{route('rolemgmt')}}" class="nav-link {{ Route::currentRouteName() == 'rolemgmt' ? 'active':''}}">
          <i class="nav-icon fas fa-users"></i>
          <p>
            Role Management
          </p>
        </a>
      </li>

            <li class="nav-item">
        <a href="{{route('usermgmt')}}" class="nav-link {{ Route::currentRouteName() == 'usermgmt' ? 'active':''}}">
          <i class="nav-icon fas fa-user"></i>
          <p>
            User Management
          </p>
        </a>
      </li>
            <li class="nav-item">
        <a href="{{route('indexadmin')}}" class="nav-link {{ Route::currentRouteName() == 'indexadmin' ? 'active':''}}">
          <i class="nav-icon fas fa-table"></i>
          <p>
            Absen
          </p>
        </a>
      </li>

      
      
      <li class="nav-item">
        <a href="{{route('history')}}" class="nav-link {{ Route::currentRouteName() == 'history' ? 'active':''}}">
          <i class="nav-icon fa fa-history"></i>
          <p>
            History
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('persentase')}}" class="nav-link {{ Route::currentRouteName() == 'persentase' ? 'active':''}}">
          <i class="nav-icon fa fa-calculator"></i>
          <p>
            Persentase
          </p>
        </a>
      </li>


            </ul>
          </li>


            

    @endif
    @if (Auth::user()->level == 'user')
    <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Presensi
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
        <a href="{{route('indexuser')}}" class="nav-link {{ Route::currentRouteName() == 'indexuser' ? 'active':''}}">
          <i class="nav-icon fas fa-home"></i>
          <p>
            Absen
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('userhistory')}}" class="nav-link {{ Route::currentRouteName() == 'userhistory' ? 'active':''}}">
          <i class="nav-icon fa fa-history"></i>
          <p>
            History
          </p>
        </a>
      </li>
            </ul>
          </li>


    
      @endif
    @if (Auth::user()->level == 'piket')
    
     <li class="nav-item">
        <a href="{{route('indexpiket')}}" class="nav-link {{ Route::currentRouteName() == 'indexpiket' ? 'active':''}}">
          <i class="nav-icon fas fa-home"></i>
          <p>
            Absen
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('historypiket')}}" class="nav-link {{ Route::currentRouteName() == 'historypiket' ? 'active':''}}">
          <i class="nav-icon fa fa-history"></i>
          <p>
            History
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('persentasepiket')}}" class="nav-link {{ Route::currentRouteName() == 'persentasepiket' ? 'active':''}}">
          <i class="nav-icon fa fa-calculator"></i>
          <p>
            Persentase
          </p>
        </a>
      </li> 


    
      @endif


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
