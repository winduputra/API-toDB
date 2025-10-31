@extends('layouts.adminlte')

@section('title', 'RUP Provinsi Lampung')

@push('style')
<link rel="stylesheet" href="{{ url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ url('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
  div.dataTables_wrapper div.dataTables_info {
    margin-top: 15px !important;
  }
  div.dataTables_wrapper div.dataTables_paginate {
    margin-top: 15px !important;
  }
  .swakelola-col { min-width: 80px; }
  .select2-container--default .select2-selection--single {
    height: 31px !important;
    padding: 4px 10px;
    font-size: 0.885rem;
    border: 1px solid #ced4da !important;
    border-radius: 4px;
  }
  .select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 35px !important;
    color: #212529 !important;
  }
  .select2-container--default .select2-selection--single .select2-selection__arrow {
    top: 3px !important;
  }
  .form-inline .form-group {
    margin-bottom: 5px;
  }
  .select2-container { min-width: 200px; }
</style>
@endpush

@section('navbar-extra')
<li class="nav-item d-flex align-items-center">
  <form id="filterForm" action="{{ route('report.rup') }}" method="GET" class="form-inline flex-wrap">
    <div class="form-group mr-2 mb-1">
      <input type="text" class="form-control form-control-sm" value="Provinsi Lampung" readonly>
    </div>
    <div class="form-group mr-2 mb-1">
      <select name="tahun" class="form-control form-control-sm select2-rup" onchange="this.form.submit()">
        @foreach($tahunTersedia as $t)
          <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
        @endforeach
      </select>
    </div>
    <div class="form-group mr-2 mb-1">
      <select name="satker" class="form-control form-control-sm select2-rup" onchange="this.form.submit()">
        <option value="Semua" {{ $kdSatkerFilter == 'Semua' ? 'selected' : '' }}>Semua Satuan Kerja</option>
        @foreach($allSatker as $kdSatker => $namaSatker)
          <option value="{{ $kdSatker }}" {{ $kdSatkerFilter == $kdSatker ? 'selected' : '' }}>{{ $namaSatker }}</option>
        @endforeach
      </select>
    </div>
  </form>
</li>
@endsection

@section('content')
<section class="content">
  <div class="container-fluid">

    <div class="card mb-3 mt-3">
      <div class="card-body bg-light border rounded">
        <strong>Rencana Umum Pengadaan (RUP)</strong>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6 mb-3">
        <div class="card bg-info text-white shadow-sm">
          <div class="card-body d-flex align-items-center">
            <div class="flex-grow-1">
              <div class="text-uppercase small font-weight-bold">Total Paket</div>
              <div class="h3 mb-0">{{ number_format($grandTotal['paket_total'], 0, ',', '.') }}</div>
            </div>
            <div class="text-end">
              <i class="fas fa-box fa-2x ms-3"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 mb-3">
        <div class="card bg-success text-white shadow-sm">
          <div class="card-body d-flex align-items-center">
            <div class="flex-grow-1">
              <div class="text-uppercase small font-weight-bold">Total Pagu</div>
              <div class="h3 mb-0">Rp {{ number_format($grandTotal['pagu_total'], 0, ',', '.') }}</div>
            </div>
            <div class="text-end">
              <i class="fas fa-money-bill-wave fa-2x ms-3"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Rekapitulasi RUP</h3>
        <div class="ml-auto">
          <a href="{{ route('report.rup.pdf', ['tahun' => $tahun, 'satker' => $kdSatkerFilter]) }}" class="btn btn-success btn-sm" target="_blank">
            <i class="fas fa-file-pdf mr-1"></i> Export PDF
          </a>
        </div>
      </div>
      <div class="card-body table-responsive">
        <table id="rupTable" class="table table-bordered table-hover text-nowrap w-100">
          <thead class="thead-light">
            <tr>
              <th rowspan="2">No</th>
              <th rowspan="2">Satker</th>
              <th colspan="2">Penyedia</th>
              <th colspan="2">Swakelola</th>
              <th colspan="2" class="text-center">Penyedia Dalam Swakelola</th>
              <th colspan="2">Total</th>
            </tr>
            <tr>
              <th>Paket</th><th>Pagu</th>
              <th>Paket</th><th>Pagu</th>
              <th class="swakelola-col">Paket</th><th class="swakelola-col">Pagu</th>
              <th>Paket</th><th>Pagu</th>
            </tr>
          </thead>
          <tbody>
            @php $rowNum = 1; @endphp
            @foreach($rekap as $item)
              <tr>
                <td>{{ $rowNum++ }}</td>
                <td>{{ $item['nama_satker'] }}</td>
                <td>{{ number_format($item['paket_penyedia'], 0, ',', '.') }}</td>
                <td>{{ number_format($item['pagu_penyedia'], 0, ',', '.') }}</td>
                <td>{{ number_format($item['paket_swakelola'], 0, ',', '.') }}</td>
                <td>{{ number_format($item['pagu_swakelola'], 0, ',', '.') }}</td>
                <td class="swakelola-col">{{ number_format($item['paket_dalam'], 0, ',', '.') }}</td>
                <td class="swakelola-col">{{ number_format($item['pagu_dalam'], 0, ',', '.') }}</td>
                <td>{{ number_format($item['paket_total'], 0, ',', '.') }}</td>
                <td>{{ number_format($item['pagu_total'], 0, ',', '.') }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

  </div>
</section>
@endsection

@push('script')
<script src="{{ url('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ url('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
  $(function () {
    $('#rupTable').DataTable({
      scrollX: true,
      autoWidth: false,
      language: {
        search: "Cari:",
        lengthMenu: "Tampilkan _MENU_ entri",
        zeroRecords: "Tidak ditemukan",
        info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
        infoEmpty: "Tidak ada entri",
        paginate: { previous: "Sebelumnya", next: "Berikutnya" }
      }
    });

    $('.select2-rup').select2({
      minimumResultsForSearch: 5,
      width: 'resolve'
    }).on('change', function () {
      $('#filterForm').submit();
    });
  });
</script>
@endpush
