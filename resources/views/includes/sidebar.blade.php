<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      {{-- <img src="{{ asset('assets/logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
      <span class="brand-text font-weight-light ml-3">CV Rama Jaya</span>
    </a>


    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ url('assets/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          @if (Auth::user()->roles == 'ADMIN')
          <li class="nav-item">
            <a href="{{ route('admin.dashboard.index') }}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.klien.index') }}" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Data Klien
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.portfolio.index') }}" class="nav-link">
              <i class="nav-icon fas fa-image"></i>
              <p>
                Data Portfolio
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.transaksi.index') }}" class="nav-link">
              <i class="nav-icon fas fa-money-bill-wave-alt"></i>
              <p>
                Data Transaksi
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.mandor.index') }}" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Data Mandor
              </p>
            </a>
          </li>
          @endif

          @if (Auth::user()->roles == 'MANDOR')
          <li class="nav-item">
            <a href="{{ route('mandor.dashboard.index') }}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          @endif

        @if (Auth::user()->roles == 'KLIEN')
          <li class="nav-item">
            <a href="{{ route('klien.dashboard.index') }}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('klien.order.index') }}" class="nav-link">
              <i class="nav-icon fas fa-box"></i>
              <p>
                Order
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('pembayaran.index') }}" class="nav-link">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>
                Pembayaran
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('klien.profile.index') }}" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Profile
              </p>
            </a>
          </li>
          @endif

          <li class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Logout
              </p>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
