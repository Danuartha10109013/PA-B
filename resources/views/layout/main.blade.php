<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
  <link rel="shortcut icon" type="image/png" href="{{asset('PT. Bersama Sahabat Makmur Logo.png')}}" />
  <link rel="stylesheet" href="{{asset('vendor')}}/assets/css/styles.min.css" />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="./index.html" class="text-nowrap logo-img">
            <img src="{{asset('PT. Bersama Sahabat Makmur Logo.png')}}" width="70" alt="" />
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
          </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          @if (Auth::user()->role == 0)
        @include('layout.sidebar')
      @else
        @include('layout.pegawai.sidebar')
      @endif
        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          @include('layout.topbar')
        </nav>
      </header>
      <!--  Header End -->
      <div class="container-fluid">
        <!--  Row 1 -->

        @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

        @if (session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <ul>
          @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
          </ul>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

        @yield('content')
      </div>
      @include('layout.footer')
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script src="{{asset('vendor')}}/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{asset('vendor')}}/assets/js/sidebarmenu.js"></script>
  <script src="{{asset('vendor')}}/assets/js/app.min.js"></script>
  <script src="{{asset('vendor')}}/assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="{{asset('vendor')}}/assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="{{asset('vendor')}}/assets/js/dashboard.js"></script>

  <script>
    setInterval(function () {
      $.ajax({
        url: '/run-schedule',
        method: 'GET',
        success: function (response) {
          console.log(response.status);
        },
        error: function (xhr) {
          console.error('Error:', xhr.responseText);
        }
      });
    }, 60000); // 60000ms = 1 menit
  </script>
  @stack('scripts')

</body>

</html>