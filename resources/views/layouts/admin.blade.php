<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}" />

  <title>PP8B</title>
  <link rel="stylesheet" href="{{ asset('assets/libs/owl.carousel/dist/assets/owl.carousel.min.css') }}" />
</head>

<body>
  <div class="toast toast-onload align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body hstack align-items-start gap-6">
      <i class="ti ti-alert-circle fs-6"></i>
      <div>
        <h5 class="text-white fs-3 mb-1">Welcome Admin</h5>
        <h6 class="text-white fs-2 mb-0">HOM</h6>
      </div>
      <button type="button" class="btn-close btn-close-white fs-2 m-0 ms-auto shadow-none" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>

  <div class="preloader">
    <img src="{{ asset('assets/images/logos/favicon.png') }}" alt="loader" class="lds-ripple img-fluid" />
  </div>

  <div id="main-wrapper">
    <!-- Sidebar Start -->
   <aside class="left-sidebar with-vertical" id="sidebarDesktop">
    <div class="brand-logo d-flex align-items-center justify-content-between">
        
        <img src="{{ asset('assets/images/big/HOM.png') }}" alt="Logo"
     class="rounded-circle border border-2 border-primary mx-auto d-block"
     style="width:130px; height:130px; object-fit:cover;"  id="sidebarTitle">
     
        <a href="javascript:void(0)" class="sidebartoggler d-block d-xl-none" id="sidebarToggleMobile">
            <i class="ti ti-x"></i>
        </a>
    </div>

     

      @include('layouts.components.sidebar')

  <div class="fixed-profile p-3 mx-4 mb-2 bg-secondary-subtle rounded"
    style="margin-top:-50px; position: relative; z-index: 1000;">
  <div class="hstack gap-3">
    <div class="john-img">
      <img src="{{ asset('assets/images/profile/user-1.jpg') }}" class="rounded-circle" width="40" height="40" alt="modernize-img" />
    </div>
    <div class="john-title">
      <h6 class="mb-0 fs-4 fw-semibold">{{ Auth::user()->name ?? 'Admin' }}</h6>
      <span class="fs-2">{{ Auth::user()->role ?? 'Admin' }}</span>
    </div>

    <!-- Tombol Logout -->
<form action="{{ route('logout') }}" method="POST" class="ms-auto align-self-start">
  @csrf
  <button type="submit" class="border-0 bg-transparent text-danger mt-n1" title="Logout">
    <i class="ti ti-power fs-6"></i>
  </button>
</form>
  </div>
</div>
    </aside>
    <!-- Sidebar End -->

    <div class="page-wrapper">
      @include('layouts.components.navbar')

      <div class="container-fluid">
        @yield('content')

      </div>
    </div>
  </div>

  <!-- JS Vendor -->
  <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
  <script src="{{ asset('assets/js/theme/app.init.js') }}"></script>
  <script src="{{ asset('assets/js/theme/theme.js') }}"></script>
  <script src="{{ asset('assets/js/theme/app.min.js') }}"></script>
  <script src="{{ asset('assets/js/theme/sidebarmenu.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
  <script src="{{ asset('assets/libs/owl.carousel/dist/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/js/dashboards/dashboard.js') }}"></script>
  <script>
const sidebarToggle = document.getElementById('headerCollapse');
const sidebar = document.getElementById('sidebarDesktop');
const sidebarTitle = document.getElementById('sidebarTitle');

sidebarToggle.addEventListener('click', () => {
    sidebar.classList.toggle('collapsed');

    // sembunyikan judul saat sidebar collapsed
    if(sidebar.classList.contains('collapsed')){
        sidebarTitle.style.display = 'none';
    } else {
        sidebarTitle.style.display = 'block';
    }
});
</script>
</body>

</html>
