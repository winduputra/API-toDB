<!-- Sidebar -->
<div class="sidebar">
  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

      <!-- Menu Lain -->
      <li class="nav-item">
        <a href="{{ route('tender.list') }}" class="nav-link">
          <i class="nav-icon fa fa-list-ol"></i>
          <p>Tender</p>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('non-tender.list') }}" class="nav-link">
          <i class="nav-icon fa fa-list-ul"></i>
          <p>Non Tender</p>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('report.rup') }}" class="nav-link">
          <i class="nav-icon fas fa-file-alt"></i>
          <p>RUP</p>
        </a>
      </li>

      <!-- E-Purchasing -->
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-shopping-cart"></i>
          <p>
            E-Purchasing
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('report.ekatalog') }}" class="nav-link">
              <p>E-Katalog</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('report.tokodaring') }}" class="nav-link">
              <p>Toko Daring</p>
            </a>
          </li>
        </ul>
      </li>

      <!-- Summary Report -->
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-download"></i>
          <p>
            Summary Report
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="#" class="nav-link" data-toggle="modal" data-target="#filterModal">
              <p>Realisasi Non Tender</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" data-toggle="modal" data-target="#filterTenderModal">
              <p>Realisasi Tender</p>
            </a>
          </li>
        </ul>
      </li>
<!-- Monitoring -->
<li class="nav-item has-treeview">
  <a href="#" class="nav-link">
    <i class="nav-icon fas fa-eye"></i>
    <p>
      Monitoring
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{ route('monitoring.realisasi.satker') }}" class="nav-link">
        <p>Realisasi Satker</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('monitoring.rekap.realisasi') }}" class="nav-link">
        <p>Rekap Realisasi</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('monitoring.rekap.realisasi-berlangsung') }}" class="nav-link">
        <p>Rekap Berlangsung</p>
      </a>
    </li>

    <!-- Monitoring Kontrak Belum Dinput -->
    <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <p>
          Monitoring Kontrak Belum Dinput
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ route('monitoring.kontrak') }}" class="nav-link">
            <p>Kontrak Tender</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('monitoring.kontrak.non_tender') }}" class="nav-link">
            <p>Kontrak Non Tender</p>
          </a>
        </li>
      </ul>
    </li>
  </ul>
</li>


      <!-- Grafik -->
      <li class="nav-item">
        <a target="_blank" href="{{ route('report') }}" class="nav-link">
          <i class="nav-icon fa fa-chart-pie"></i>
          <p>Grafik Report</p>
        </a>
      </li>

      <!-- Admin -->
      @if (Auth::check() && Auth::user()->role_id == 1)
      <li class="nav-item">
        <a href="{{ route('user.list') }}" class="nav-link">
          <i class="nav-icon fa fa-users"></i>
          <p>Manajemen User</p>
        </a>
      </li>
      @endif

    </ul>
  </nav>
  <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
