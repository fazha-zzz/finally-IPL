 <nav class="sidebar-nav scroll-sidebar" data-simplebar>
          <ul id="sidebarnav">
            <!-- ---------------------------------- -->
            <!-- Home -->
            <!-- ---------------------------------- -->
            <li class="nav-small-cap ">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Home</span>
            </li>
            <!-- ---------------------------------- -->
            <!-- Dashboard -->
            <!-- ---------------------------------- -->
           <li class="sidebar-item">
            <a class="sidebar-link {{ request()->routeIs('admin.pembayaran.*') ? 'bg-primary text-white rounded' : '' }}" href="{{ route('admin.pembayaran.index') }}">
              <span><i class="ti ti-cash"></i></span>
              <span class="hide-menu">Pembayaran</span>
            </a>
          </li>

          <li class="sidebar-item" >
           <a class="sidebar-link {{ request()->routeIs('admin.biaya_setting.*') ? 'bg-primary text-white rounded' : '' }}" 
                href="{{ route('admin.biaya_setting.index') }}">
                <span><i class="ti ti-settings"></i></span>
                <span class="hide-menu">Biaya Setting</span>
             </a>
          </li>

          <li class="sidebar-item" >
           <a class="sidebar-link {{ request()->routeIs('admin.Tempo.jatuh-tempo') ? 'bg-primary text-white rounded' : '' }}" 
                href="{{ route('admin.Tempo.jatuh-tempo') }}">
                <span><i class="ti ti-clock"></i></span>
                <span class="hide-menu">Tenggat waktu</span>
             </a>
          </li>

            <li class="sidebar-item ">
              <a class="sidebar-link {{ request()->routeIs('admin.iklan.*') ? 'bg-primary text-white rounded' : '' }}" href="{{ route('admin.iklan.index') }}">
                <span><i class="ti ti-broadcast"></i></span>
                <span class="hide-menu">Iklan</span>
              </a>
            </li>
            <li class="sidebar-item ">
              <a class="sidebar-link {{ request()->routeIs('admin.pengumuman.*') ? 'bg-primary text-white rounded' : '' }}" href="{{ route('admin.pengumuman.index') }}">
                <span><i class="fa fa-bullhorn"></i></span>
                <span class="hide-menu">Pengumuman</span>
              </a>
            </li>
            <li class="sidebar-item ">
              <a class="sidebar-link {{ request()->routeIs('admin.kegiatan.*') ? 'bg-primary text-white rounded' : '' }}" href="{{ route('admin.kegiatan.index') }}">
                <span><i class="ti ti-calendar-event"></i></span>
                <span class="hide-menu">Kegiatan</span>
              </a>
            </li>
            <li class="sidebar-item ">
              <a class="sidebar-link {{ request()->routeIs('admin.saran.*') ? 'bg-primary text-white rounded' : '' }}" href="{{ route('admin.saran.index') }}">
                <span><i class="ti ti-message-dots"></i></span>
                <span class="hide-menu">Saran & Kritik</span>
              </a>
            </li>
            <li class="sidebar-item ">
              <a class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'bg-primary text-white rounded' : '' }}" href="{{ route('admin.users.index') }}">
                <span><i class="fas fa-user"></i></span>
                <span class="hide-menu">User</span>
              </a>
            </li>
          </ul>
        </nav>
