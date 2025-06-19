<ul class="navbar-nav">
    <li class="nav-item d-block d-xl-none">
      <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
        <i class="ti ti-menu-2"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link nav-icon-hover" href="javascript:void(0)">
        <i class="ti ti-bell-ringing"></i>
        <div class="notification bg-primary rounded-circle"></div>
      </a>
    </li>
  </ul>
  <h5>PT. Bersama Sahabat Makmur</h5>
  <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
  <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">

    {{-- Tampilkan Role --}}
    <li class="nav-item d-flex align-items-center me-3">
      <span class="fw-semibold">
        {{ Auth::user()->role == 0 ? 'Admin' : 'Pegawai' }} |
      </span>
    </li>

    {{-- Dropdown Profil --}}
    <li class="nav-item dropdown">
      <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
         aria-expanded="false">
        <img src="{{ asset('storage/' . Auth::user()->profile) }}" alt="Profile"
             width="35" height="35" class="rounded-circle object-fit-cover">
      </a>
      <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
        <div class="message-body">

          <a href="{{ route('profile', Auth::user()->id) }}"
             class="d-flex align-items-center gap-2 dropdown-item">
            <i class="ti ti-user fs-6"></i>
            <p class="mb-0 fs-6">My Profile</p>
          </a>

          <a href="{{ route('karyawan') }}"
             class="d-flex align-items-center gap-2 dropdown-item">
            <i class="ti ti-users fs-6"></i>
            <p class="mb-0 fs-6">Semua Karyawan</p>
          </a>

          <a href="{{ route('logout') }}"
             class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>

        </div>
      </div>
    </li>

  </ul>
</div>
