{{-- File: resources/views/layouts/partials/user-navbar.blade.php --}}

<style>
  body {
    margin: 0;
    padding: 0;
    font-family: 'Public Sans', sans-serif;
    background-color: #ffffff;
}

.dropdown-menu {
    background-color: #ffffff !important;
    min-width: 220px;
    border: 1px solid #ddd;
    padding: 0.25rem;
    border-radius: 0.5rem;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.dropdown-item {
    border-radius: 0.375rem;
    transition: background-color 0.2s ease;
    padding: 0.5rem 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 0.15rem 0;
}

.dropdown-item:hover {
    background-color: #f1f1f1;
}

/* Toggle caret */
.dropdown-toggle::after {
    margin-left: 0.5rem;
    vertical-align: middle;
    border-top: 0.4em solid;
    border-right: 0.4em solid transparent;
    border-left: 0.4em solid transparent;
    transition: transform 0.2s ease;
}

.show > .dropdown-toggle::after {
    transform: rotate(-180deg);
}

/* Submenu styling */
.dropdown-submenu {
    position: relative;
}

.dropdown-submenu > .dropdown-item::after {
    content: "";
    display: inline-block;
    margin-left: 0.5rem;
    vertical-align: middle;
    border-left: 0.4em solid transparent;
    border-right: 0.4em solid transparent;
    border-top: 0.4em solid;
    transition: transform 0.2s ease;
}

/* Rotate caret on open */
.dropdown-submenu.show > .dropdown-item::after {
    transform: rotate(90deg);
}

.dropdown-submenu .dropdown-menu {
    top: 100% !important;
    left: 0 !important;
    margin-top: 0;
    background-color: #ffffff !important;
    display: none; /* default: hidden */
}

/* Tambahan khusus layar antara 1155px sampai 992px */
@media (max-width: 1155px) and (min-width: 992px) {
    .dropdown-menu {
        width: 100vw;
        left: 0 !important;
        right: 0 !important;
        margin: 0 !important;
        padding-left: 1rem;
        padding-right: 1rem;
        border-radius: 0;
        box-shadow: none;
    }

    .dropdown-submenu .dropdown-menu {
        position: relative !important;
        left: 0 !important;
        top: auto !important;
        margin-left: 0 !important;
        width: 100%;
        box-shadow: none;
    }

    .dropdown-submenu > .dropdown-item {
        padding-left: 1.25rem;
    }

    .dropdown-item {
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .dropdown-submenu > .dropdown-item i {
        margin-left: auto;
    }
}


/* Tampilkan submenu sebagai dropdown biasa di mobile */
@media (max-width: 991.98px) {
    .dropdown-menu {
        margin-left: 1rem;
        border: none;
        box-shadow: none;
    }

    .dropdown-submenu > .dropdown-menu {
        display: block !important;
        position: relative;
        top: auto;
        left: auto;
        margin-left: 1.5rem;
    }

    .dropdown-submenu > .dropdown-item::after {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
    }

    .dropdown-submenu.show > .dropdown-item::after {
        transform: translateY(-50%) rotate(90deg);
    }

    .dropdown-item {
        padding-left: 0.5rem;
    }
}
.dropdown-item.active {
    background-color: #ffffff !important;
    color: #000000 !important;
}
.dropdown-submenu > .dropdown-item i {
  margin-left: auto;
  font-size: 0.75rem;
}

.dropdown-toggle > i {
  font-size: 0.75rem;
}

  /* Ikon panah rotate saat submenu aktif */
  .dropdown-submenu .dropdown-toggle[aria-expanded="true"] i {
    transform: rotate(90deg); /* dari kanan ke bawah */
  }

  .dropdown-submenu .dropdown-toggle i {
    transition: transform 0.3s ease;
  }
  .transition {
  transition: transform 0.3s ease;
}

.rotate-90 {
  transform: rotate(90deg);
}
/* Pastikan panah default tidak muncul */
.dropdown-submenu > .dropdown-item::after {
  content: none !important;
}

</style>

<nav class="navbar navbar-expand-lg navbar-dark navbar-blue shadow-sm sticky-top">
  <div class="container-fluid px-4">
    <!-- Logo -->
    <div class="d-flex align-items-center me-4 sibaja-logo-box shadow-sm">
      <img src="{{ asset('images/sibaja-logo.png') }}" alt="Logo" class="me-2">
      <div class="sibaja-header-text">
        <div class="sibaja-header-title">
          <strong>SiBAJA</strong>
          <span class="text-divider">|</span>
          <span>Provinsi Lampung</span>
        </div>
        <hr class="sibaja-divider">
        <div class="sibaja-subtitle">Sistem Informasi Barang dan Jasa</div>
      </div>
    </div>

    <!-- Toggle Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu Items -->
    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="navbar-nav ms-4 me-auto">

        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('tender.list') ? 'active' : '' }}" href="{{ route('tender.list') }}">Tender</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('non-tender.list') ? 'active' : '' }}" href="{{ route('non-tender.list') }}">Non Tender</a>
        </li>

        <!-- Dropdown: E-Purchasing -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle {{ request()->routeIs('report.ekatalog') || request()->routeIs('report.tokodaring') ? 'active' : '' }}" href="#" id="epurchasingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            E-Purchasing
          </a>
          <ul class="dropdown-menu" aria-labelledby="epurchasingDropdown">
            <li><a class="dropdown-item" href="{{ route('report.ekatalog') }}">E-Katalog</a></li>
            <li><a class="dropdown-item" href="{{ route('report.tokodaring') }}">Toko Daring</a></li>
          </ul>
        </li>

        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('report.rup') ? 'active' : '' }}" href="{{ route('report.rup') }}">RUP</a>
        </li>

        <!-- Dropdown: Summary Report -->
        <li class="nav-item dropdown">
          @php
            $isSummaryReportActive = 
              request()->routeIs('report.categorize') ||
              request()->routeIs('tender.fund.source') ||
              request()->routeIs('report.all') ||
              request()->routeIs('non-tender.realization') ||
              request()->routeIs('tender.realization') ||
              request()->routeIs('report.review');
          @endphp
          <a class="nav-link dropdown-toggle {{ $isSummaryReportActive ? 'active' : '' }}" href="#" id="summaryReportDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Summary Report
          </a>
          <ul class="dropdown-menu" aria-labelledby="summaryReportDropdown">
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#filterModal">Realisasi Non Tender</a></li>
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#filterTenderModal">Realisasi Tender</a></li>
          </ul>
        </li>


        <li class="nav-item dropdown">
  @php
    $isMonitoringActive = 
      request()->routeIs('monitoring.realisasi.satker') ||
      request()->routeIs('monitoring.rekap.realisasi-berlangsung') ||
      request()->routeIs('monitoring.rekap.realisasi') ||
      request()->routeIs('monitoring.kontrak') ||
      request()->routeIs('monitoring.kontrak.non_tender');
  @endphp

  <a class="nav-link dropdown-toggle {{ $isMonitoringActive ? 'active' : '' }}" 
     href="#" id="monitoringDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
    Monitoring 
  </a>

  <ul class="dropdown-menu" aria-labelledby="monitoringDropdown">
    <li>
      <a class="dropdown-item {{ request()->routeIs('monitoring.realisasi.satker') ? 'active' : '' }}" 
         href="{{ route('monitoring.realisasi.satker') }}">
        Realisasi Pengadaan
      </a>
    </li>
    <li>
      <a class="dropdown-item {{ request()->routeIs('monitoring.rekap.realisasi-berlangsung') ? 'active' : '' }}" 
         href="{{ route('monitoring.rekap.realisasi-berlangsung') }}">
        Realisasi Berlangsung
      </a>
    </li>
    <li>
      <a class="dropdown-item {{ request()->routeIs('monitoring.rekap.realisasi') ? 'active' : '' }}" 
         href="{{ route('monitoring.rekap.realisasi') }}">
        Realisasi Selesai
      </a>
    </li>

    <li class="dropdown-submenu position-relative">
  <a class="dropdown-item d-flex justify-content-between align-items-center px-3 py-2"
     href="#" aria-expanded="false" id="submenuToggle">
    <span class="d-flex align-items-center">
      Monitoring Belum Input
      <i class="bi bi-caret-down-fill ms-1 transition" id="arrowBelumInput"></i>
    </span>
  </a>

  <ul class="collapse list-unstyled bg-white" id="submenuBelumInput">
    <li>
      <a class="dropdown-item px-3 py-2 {{ request()->routeIs('monitoring.kontrak') ? 'active' : '' }}" 
         href="{{ route('monitoring.kontrak') }}">
        Kontrak Tender
      </a>
    </li>
    <li>
      <a class="dropdown-item px-3 py-2 {{ request()->routeIs('monitoring.kontrak.non_tender') ? 'active' : '' }}" 
         href="{{ route('monitoring.kontrak.non_tender') }}">
        Kontrak Non Tender
      </a>
    </li>
  </ul>
</li>


        </li>
      </ul>
    </li>
  </ul>
</li>


      <!-- User Account Menu -->
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarUserDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle" style="font-size: 1.4rem;"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarUserDropdown">
            <li><a class="dropdown-item text-danger" href="{{ route('logout') }}">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<script>
document.addEventListener('DOMContentLoaded', function () {
  // === Monitoring Belum Input Submenu Toggle ===
  const submenuToggle = document.getElementById('submenuToggle');
  const submenu = document.getElementById('submenuBelumInput');
  const arrowIcon = document.getElementById('arrowBelumInput');
  const monitoringDropdown = document.querySelector('#monitoringDropdown');

  if (submenuToggle && submenu && arrowIcon) {
    const collapse = new bootstrap.Collapse(submenu, { toggle: false });

    submenuToggle.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();

      const isShown = submenu.classList.contains('show');

      // Tutup submenu lain jika terbuka
      document.querySelectorAll('.collapse.show').forEach(el => {
        if (el !== submenu) {
          bootstrap.Collapse.getInstance(el)?.hide();
          el.closest('.dropdown-submenu')?.querySelector('.bi-caret-right-fill')?.classList.remove('rotate-90');
        }
      });

      // Toggle submenu
      if (isShown) {
        collapse.hide();
        arrowIcon.classList.remove('rotate-90');
      } else {
        collapse.show();
        arrowIcon.classList.add('rotate-90');
      }
    });

    // Tutup submenu jika dropdown utama ditutup
    monitoringDropdown?.addEventListener('hide.bs.dropdown', function () {
      if (submenu.classList.contains('show')) {
        collapse.hide();
        arrowIcon.classList.remove('rotate-90');
      }
    });

    // Tutup submenu jika klik di luar
    document.addEventListener('click', function (e) {
      const clickedInside = e.target.closest('.dropdown-submenu') || e.target.closest('.dropdown-menu');
      if (!clickedInside && submenu.classList.contains('show')) {
        collapse.hide();
        arrowIcon.classList.remove('rotate-90');
      }
    });
  }

  // Nonaktifkan hover behavior untuk semua dropdown (jaga-jaga)
  const allDropdownToggles = document.querySelectorAll('.dropdown-toggle');
  allDropdownToggles.forEach(toggle => {
    toggle.parentElement.onmouseenter = null;
    toggle.parentElement.onmouseleave = null;
    // Hanya klik, tidak hover
  });

  // === Active Menu Class
  const monitoringRoutes = [
    'monitoring.realisasi.satker',
    'monitoring.rekap.realisasi-berlangsung',
    'monitoring.rekap.realisasi',
    'monitoring.kontrak',
    'monitoring.kontrak.non_tender'
  ];
  const currentRoute = '{{ request()->route()->getName() }}';
  if (monitoringRoutes.includes(currentRoute)) {
    monitoringDropdown?.classList.add('monitoring-active');
  }
});
</script>

