<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="{{route('dashboard')}}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->
      @if(Auth::user()->role == 1)
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#superadmin-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>City</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="superadmin-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('city.index')}}">
              <i class="bi bi-circle"></i><span>All Cities</span>
            </a>
          </li>
          
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#superadmin-nav1" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Admin</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="superadmin-nav1" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('admin.index')}}">
              <i class="bi bi-circle"></i><span>All Admin</span>
            </a>
          </li>
          
        </ul>
      </li>
      @elseif(Auth::user()->role == 2)
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#admin-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Area</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="admin-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('area.index')}}">
              <i class="bi bi-circle"></i><span>All Areas</span>
            </a>
          </li>
          
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#admin-nav1" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Dealer</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="admin-nav1" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('dealer.index')}}">
              <i class="bi bi-circle"></i><span>All Dealer</span>
            </a>
          </li>
          
        </ul>
      </li>
      @elseif(Auth::user()->role == 3)
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#dealer-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>User</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="dealer-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('user.index')}}">
              <i class="bi bi-circle"></i><span>All Users</span>
            </a>
          </li>
          
        </ul>
      </li>
      @endif
      <li class="nav-item">
        <a class="nav-link" href="{{route('ledger')}}">
          <i class="bi bi-grid"></i>
          <span>Ledger</span>
        </a>
      </li>
    
      <li class="nav-item">
        <a href="{{route('admin.logout')}}" class="nav-link">
          <i class="bi bi-circle"></i><span>Logout</span>
        </a>
      </li>
      

    </ul>

  </aside>