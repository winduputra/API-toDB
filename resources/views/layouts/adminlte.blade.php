<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'SiBAJA')</title>

  {{-- Favicon --}}
  <link rel="apple-touch-icon" sizes="180x180" href="{{ url('logo.png') }}"/>
  <link rel="icon" type="image/png" sizes="32x32" href="{{ url('32x32.png') }}"/>
  <link rel="icon" type="image/png" sizes="16x16" href="{{ url('16x16.png') }}"/>

  {{-- Styles --}}
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="{{ url('plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="{{ url('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <link rel="stylesheet" href="{{ url('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ url('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ url('plugins/jqvmap/jqvmap.min.css') }}">
  <link rel="stylesheet" href="{{ url('dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ url('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <link rel="stylesheet" href="{{ url('plugins/daterangepicker/daterangepicker.css') }}">
  

  @stack('style')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  {{-- Preloader --}}
  @include('components.preloader')

  {{-- ===== NAVBAR ===== --}}
  @hasSection('navbar')
    {{-- Gunakan navbar override --}}
    @yield('navbar')
  @else
    {{-- Default Admin Navbar --}}
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button">
            <i class="fas fa-bars"></i>
          </a>
        </li>
        @yield('navbar-extra')
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
          <a class="nav-link text-danger" href="{{ route('logout') }}">
            <i class="fas fa-sign-out-alt"></i>
          </a>
        </li>
      </ul>
    </nav>
  @endif

  {{-- ===== SIDEBAR ===== --}}
@if(trim($__env->yieldContent('hideSidebar')) == 'true')
  {{-- Tidak tampilkan sidebar --}}
  <style>
    .content-wrapper, .main-footer {
      margin-left: 0 !important;
    }
  </style>
@else
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ url('/') }}" class="brand-link">
      <span class="brand-text font-weight-light">SIBAJA</span>
    </a>
    @include('components.sidebar') {{-- <- sidebar adminmu di sini --}}
  </aside>
@endif

  {{-- ===== KONTEN UTAMA ===== --}}
  <div class="content-wrapper pt-4">
    @yield('content')
  </div>

  {{-- ===== FOOTER ===== --}}
  @hasSection('footer')
    @yield('footer')
  @else
    <footer class="main-footer">
      <div class="d-block d-md-flex justify-content-between">
        <p>
          &copy; {{ date('Y') }}. <a href="https://bpbjprovlampung.id/">Biro Pengadaan Barang dan Jasa Provinsi Lampung</a>
        </p>
        <div>
          <b>Time</b> <span id="time">{{ date('Y-m-d H:i:s') }}</span>.
          <b>Server Status</b> <span class="text-success">Good</span>.
          <b>Version</b> <span>0.1.1</span>
        </div>
      </div>
    </footer>
  @endif

  {{-- Control Sidebar (Kosong) --}}
  <aside class="control-sidebar control-sidebar-dark"></aside>
</div>
{{-- Modal Filter Non Tender --}}
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Download Realisasi Non Tender</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

      </div>
      <div class="modal-body">
        <label for="nonYear">Tahun:</label>
        <select name="nonYear" id="nonYear" class="form-control">
          @foreach ($nonTenderYears as $year)
            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
          @endforeach
        </select>

        <label for="month">Bulan:</label>
        <select id="month" class="form-control">
          <option value="ALL">KESELURUHAN</option>
          @foreach (range(1, 12) as $month)
            <option value="{{ $month }}">{{ strtoupper(getMonthName($month)) }}</option>
          @endforeach
        </select>

        <label for="day" id="dayLabel" style="display: none;">Tanggal:</label>
        <select id="day" class="form-control" style="display: none;">
          <option value="ALL">KESELURUHAN</option>
        </select>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" id="viewButton">Lihat</button>
        <button class="btn btn-success" id="downloadButton">Download</button>
      </div>
    </div>
  </div>
</div>

{{-- Modal Filter Tender --}}
<div class="modal fade" id="filterTenderModal" tabindex="-1" aria-labelledby="filterTenderModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Download Realisasi Tender</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

      </div>
      <div class="modal-body">
        <label for="tenderYear">Tahun:</label>
        <select name="tenderYear" id="tenderYear" class="form-control">
          @foreach ($tenderYears as $year)
            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
          @endforeach
        </select>

        <label for="tenderMonth">Bulan:</label>
        <select id="tenderMonth" class="form-control">
          <option value="ALL">KESELURUHAN</option>
          @foreach (range(1, 12) as $month)
            <option value="{{ $month }}">{{ strtoupper(getMonthName($month)) }}</option>
          @endforeach
        </select>

        <label for="tenderDay" id="tenderDayLabel" style="display: none;">Tanggal:</label>
        <select id="tenderDay" class="form-control" style="display: none;">
          <option value="ALL">KESELURUHAN</option>
        </select>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" id="viewTenderButton">Lihat</button>
        <button class="btn btn-success" id="downloadTenderButton">Download</button>
      </div>
    </div>
  </div>
</div>


{{-- Scripts --}}

{{-- jQuery dan jQuery UI --}}
<script src="{{ url('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ url('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script>
  // Fix konflik jQuery UI & Bootstrap
  $.widget.bridge('uibutton', $.ui.button);
</script>

{{-- Bootstrap 4 (dari AdminLTE, sudah termasuk Popper.js) --}}
<script src="{{ url('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

{{-- Plugin tambahan --}}
<script src="{{ url('plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ url('plugins/chart.js/Chart.min.js') }}"></script>
<script src="{{ url('plugins/sparklines/sparkline.js') }}"></script>
<script src="{{ url('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ url('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<script src="{{ url('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<script src="{{ url('plugins/moment/moment.min.js') }}"></script>
<script src="{{ url('plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ url('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ url('plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ url('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

{{-- AdminLTE Core --}}
<script src="{{ url('dist/js/adminlte.js') }}"></script>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- AOS & Bootstrap 5 (jika perlu untuk tampilan) --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>AOS.init();</script>

{{-- Jam Real-time --}}
<script>
  const today = new Date("{{ getCurrentDateTime() }}");
  const timeDiv = document.getElementById('time');

  function startTime() {
    today.setSeconds(today.getSeconds() + 1);
    let h = today.getHours();
    let m = today.getMinutes();
    let s = today.getSeconds();
    h = checkTime(h);
    m = checkTime(m);
    s = checkTime(s);
    timeDiv.innerHTML = h + ":" + m + ":" + s;
    setTimeout(startTime, 1000);
  }

  function checkTime(i) {
    return (i < 10) ? "0" + i : i;
  }

  if (timeDiv) {
    startTime();
  }
</script>

{{-- Filter Modal Scripts --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
  // === NON-TENDER ===
  const nonYear = document.getElementById('nonYear');
  const nonMonth = document.getElementById('month');
  const nonDay = document.getElementById('day');
  const nonDayLabel = document.getElementById('dayLabel');

  nonMonth.value = 'ALL';
  nonDayLabel.style.display = 'none';
  nonDay.style.display = 'none';

  function updateNonTenderDays() {
    const year = parseInt(nonYear.value);
    const month = parseInt(nonMonth.value);

    if (!isNaN(year) && !isNaN(month)) {
      const daysInMonth = new Date(year, month, 0).getDate();
      nonDay.innerHTML = '<option value="ALL">KESELURUHAN</option>';
      for (let i = 1; i <= daysInMonth; i++) {
        const opt = document.createElement('option');
        opt.value = i;
        opt.textContent = i;
        nonDay.appendChild(opt);
      }
      nonDayLabel.style.display = 'block';
      nonDay.style.display = 'block';
    }
  }

  nonMonth.addEventListener('change', function () {
    if (this.value !== 'ALL') {
      updateNonTenderDays();
    } else {
      nonDay.innerHTML = '<option value="ALL">KESELURUHAN</option>';
      nonDayLabel.style.display = 'none';
      nonDay.style.display = 'none';
    }
  });

  nonYear.addEventListener('change', function () {
    if (nonMonth.value !== 'ALL') {
      updateNonTenderDays();
    }
  });

  document.getElementById('viewButton').addEventListener('click', function () {
    const query = `?year=${nonYear.value}&month=${nonMonth.value}&day=${nonDay.value}`;
    window.open(`/non-tender/view-pdf${query}`, '_blank');
  });

  document.getElementById('downloadButton').addEventListener('click', function () {
    const query = `?year=${nonYear.value}&month=${nonMonth.value}&day=${nonDay.value}`;
    window.location.href = `/non-tender/download-pdf${query}`;
  });

  // === TENDER ===
  const tenderYear = document.getElementById('tenderYear');
  const tenderMonth = document.getElementById('tenderMonth');
  const tenderDay = document.getElementById('tenderDay');
  const tenderDayLabel = document.getElementById('tenderDayLabel');

  tenderMonth.value = 'ALL';
  tenderDayLabel.style.display = 'none';
  tenderDay.style.display = 'none';

  function updateTenderDays() {
    const year = parseInt(tenderYear.value);
    const month = parseInt(tenderMonth.value);

    if (!isNaN(year) && !isNaN(month)) {
      const daysInMonth = new Date(year, month, 0).getDate();
      tenderDay.innerHTML = '<option value="ALL">KESELURUHAN</option>';
      for (let i = 1; i <= daysInMonth; i++) {
        const opt = document.createElement('option');
        opt.value = i;
        opt.textContent = i;
        tenderDay.appendChild(opt);
      }
      tenderDayLabel.style.display = 'block';
      tenderDay.style.display = 'block';
    }
  }

  tenderMonth.addEventListener('change', function () {
    if (this.value !== 'ALL') {
      updateTenderDays();
    } else {
      tenderDay.innerHTML = '<option value="ALL">KESELURUHAN</option>';
      tenderDayLabel.style.display = 'none';
      tenderDay.style.display = 'none';
    }
  });

  tenderYear.addEventListener('change', function () {
    if (tenderMonth.value !== 'ALL') {
      updateTenderDays();
    }
  });

  document.getElementById('viewTenderButton').addEventListener('click', function () {
    const query = `?year=${tenderYear.value}&month=${tenderMonth.value}&day=${tenderDay.value}`;
    window.open(`/tender/view-pdf${query}`, '_blank');
  });

  document.getElementById('downloadTenderButton').addEventListener('click', function () {
    const query = `?year=${tenderYear.value}&month=${tenderMonth.value}&day=${tenderDay.value}`;
    window.location.href = `/tender/download-pdf${query}`;
  });
});
</script>



@stack('script')
</body>
</html>
