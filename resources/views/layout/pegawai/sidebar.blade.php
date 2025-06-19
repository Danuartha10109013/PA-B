<style>
  #sidebarnav {
    padding: 1.5rem 1rem;
    background: #fff;
    height: 100%;
    box-shadow: 0 0 35px 0 rgba(154, 161, 171, 0.15);
  }

  .nav-small-cap {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    color: #6c757d;
    margin: 1.5rem 0 0.5rem;
    padding: 0 1rem;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .nav-small-cap i {
    font-size: 0.8rem;
    color: #6a93ff;
  }

  .sidebar-item {
    margin: 0.3rem 0;
    position: relative;
  }

  .sidebar-link {
    display: flex;
    align-items: center;
    padding: 0.8rem 1rem;
    color: #3b4861;
    text-decoration: none;
    border-radius: 8px;
    transition: background 0.4s ease, color 0.4s ease, transform 0.3s ease, box-shadow 0.4s ease;
    position: relative;
    overflow: hidden;
  }

  .sidebar-link:hover {
    background: #f0f6ff;
    color: #6a93ff;
    transform: translateX(5px);
  }

  .sidebar-link.active {
    background: linear-gradient(90deg, #6a93ff 0%, #a4cafe 100%);
    color: #fff;
    box-shadow: 0 2px 8px rgba(93, 135, 255, 0.15);
  }

  .sidebar-link.active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 4px;
    background: #fff;
    border-radius: 0 4px 4px 0;
  }

  .sidebar-link span:first-child {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.5rem;
    height: 2.5rem;
    background: #f8faff;
    border-radius: 8px;
    margin-right: 1rem;
    transition: all 0.3s ease;
    flex-shrink: 0;
  }

  .sidebar-link:hover span:first-child {
    background: #e6f0ff;
    transform: scale(1.1);
  }

  .sidebar-link.active span:first-child {
    background: rgba(255, 255, 255, 0.2);
  }

  .sidebar-link i {
    font-size: 1.2rem;
    color: #6a93ff;
    transition: all 0.3s ease;
  }

  .sidebar-link:hover i,
  .sidebar-link.active i {
    color: #6a93ff;
    transform: scale(1.1);
  }

  .sidebar-link.active i {
    color: #fff;
  }

  .hide-menu {
    font-weight: 500;
    font-size: 0.95rem;
    white-space: nowrap;
    flex-grow: 1;
  }

  .sidebar-link.active .hide-menu {
    font-weight: 600;
  }

  /* Hover effect for the entire sidebar */
  #sidebarnav:hover {
    box-shadow: 0 0 35px 0 rgba(154, 161, 171, 0.2);
  }

  /* Active state indicator */
  .sidebar-item.active::after {
    content: '';
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 4px;
    height: 70%;
    background: #6a93ff;
    border-radius: 4px 0 0 4px;
  }
</style>

<ul id="sidebarnav">
  <li class="nav-small-cap">
    <i class="fa fa-home"></i>
    <span class="hide-menu">Home</span>
  </li>
  <li class="sidebar-item {{ request()->routeIs('pegawai.dashboard') ? 'active' : '' }}">
    <a class="sidebar-link {{ request()->routeIs('pegawai.dashboard') ? 'active' : '' }}"
      href="{{route('pegawai.dashboard')}}" aria-expanded="false">
      <span>
        <i class="fa fa-chart-line"></i>
      </span>
      <span class="hide-menu">Dashboard</span>
    </a>
  </li>
  <li class="nav-small-cap">
    <i class="fa fa-clipboard-check"></i>
    <span class="hide-menu">Presensi</span>
  </li>

  <li class="sidebar-item {{ request()->routeIs('pegawai.absensi') ? 'active' : '' }}">
    <a class="sidebar-link {{ request()->routeIs('pegawai.absensi') ? 'active' : '' }}"
      href="{{route('pegawai.absensi')}}" aria-expanded="false">
      <span>
        <i class="fa fa-calendar-check"></i>
      </span>
      <span class="hide-menu">Absensi</span>
    </a>
  </li>
  <li class="sidebar-item {{ request()->routeIs('pegawai.cuti') ? 'active' : '' }}">
    <a class="sidebar-link {{ request()->routeIs('pegawai.cuti') ? 'active' : '' }}" href="{{route('pegawai.cuti')}}"
      aria-expanded="false">
      <span>
        <i class="fa fa-calendar-alt"></i>
      </span>
      <span class="hide-menu">Ajukan Cuti</span>
    </a>
  </li>
  <li class="sidebar-item {{ request()->routeIs('pegawai.absensi.data') ? 'active' : '' }}">
    <a class="sidebar-link {{ request()->routeIs('pegawai.absensi.data') ? 'active' : '' }}"
      href="{{route('pegawai.absensi.data')}}" aria-expanded="false">
      <span>
        <i class="fa fa-file-alt"></i>
      </span>
      <span class="hide-menu">Data Absensi</span>
    </a>
  </li>
</ul>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Add hover effect to sidebar items
    const sidebarItems = document.querySelectorAll('.sidebar-item');
    sidebarItems.forEach(item => {
      item.addEventListener('mouseenter', function () {
        this.style.transform = 'translateX(5px)';
      });
      item.addEventListener('mouseleave', function () {
        this.style.transform = 'translateX(0)';
      });
    });

    // Add active state to current route
    const currentPath = window.location.pathname;
    const sidebarLinks = document.querySelectorAll('.sidebar-link');
    sidebarLinks.forEach(link => {
      if (link.getAttribute('href') === currentPath) {
        link.classList.add('active');
        link.parentElement.classList.add('active');
      }
    });
  });
</script>