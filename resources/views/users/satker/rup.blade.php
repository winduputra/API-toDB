@extends('layouts.user-adminlte')

@section('title', 'RUP Provinsi Lampung')

@push('style')
<link rel="stylesheet" href="{{ url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ url('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
  body { background-color: #F5F8FD !important; }
  .content-wrapper, section.content { background-color: #F5F8FD; padding-bottom: 4rem; }
  .card { background-color: white; border-radius: 6px; }
  .box-softblue { background-color: #5ca8dd !important; color: white; }
  .box-green { background-color: #319b74 !important; color: white; }
  .filter-container { background-color: white; padding: 1rem; border-radius: 6px; box-shadow: 0 0 10px rgba(91, 123, 154, 0.1);}
  .filter-row .form-control,
  .select2-container--default .select2-selection--single { margin-top: 2px; }
  .select2-container--default .select2-selection--single { border: 1px solid #ced4da !important; border-radius: 4px; height: calc(1.8125rem + 2px) !important; font-size: 0.875rem; padding: 0.25rem 0.5rem; display: flex; align-items: center;}
  .select2-container--default .select2-selection--single .select2-selection__rendered {display: flex; align-items: center; padding-left: 0.25rem; padding-top: 6px !important; line-height: normal !important; height: 100%;}
  .select2-container--default .select2-results__option[aria-selected=true] {background-color: white !important; color: #212529;}
  .select2-container--default .select2-results__option--highlighted[aria-selected] {background-color: #2181EF !important; color: white !important;}
  .select2-container--default .select2-selection--single .select2-selection__arrow {height: 100%; top: 2px !important; right: 4px;}
  .table th, .table td { font-size: 0.875rem; }
  .dataTables_wrapper .dataTables_paginate, .dataTables_wrapper .dataTables_info {margin-top: 15px !important;}
  .swakelola-col { min-width: 80px; }
  .dataTables_length select {min-width: 60px;}
</style>
@endpush

@section('navbar-extra')
<div class="container-fluid mt-3 mb-3 px-0">
  <div class="filter-container w-100">
    <form id="filterForm" action="{{ route('report.rup') }}" method="GET" class="form-inline">
      <div class="row w-100 filter-row">

        <div class="col-md-2 mb-2">
          <input type="text" class="form-control form-control-sm w-100" value="Provinsi Lampung" disabled>
        </div>

        <div class="col-md-2 mb-2">
          <select name="tahun" class="form-control form-control-sm select2 w-100">
            @foreach($tahunTersedia as $t)
              <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-3 mb-2">
          <select name="satker" class="form-control form-control-sm select2 w-100">
            <option value="Semua" {{ $kdSatkerFilter == 'Semua' ? 'selected' : '' }}>Semua Satuan Kerja</option>
            @foreach($allSatker as $kdSatker => $nama)
              <option value="{{ $kdSatker }}" {{ $kdSatkerFilter == $kdSatker ? 'selected' : '' }}>{{ $nama }}</option>
            @endforeach
          </select>
        </div>

      </div>
    </form>
  </div>
</div>
@endsection

@section('content')
<section class="content">
  <div class="container-fluid">

    {{-- Header --}}
    <div class="mt-3 mb-4 ps-1">
      <h4 class="fw-bold" style="color: #1f3d7a;">
        Rencana Umum Pengadaan (RUP) - Tahun {{ $tahun }}
      </h4>
    </div>

    {{-- Summary Box --}}
    <div class="row mt-3 mb-3">
      <div class="col-md-6">
        <div class="card box-softblue text-white shadow-sm">
          <div class="card-body d-flex align-items-center">
            <div class="flex-grow-1">
              <div class="text-uppercase small font-weight-bold">TOTAL PAKET</div>
              <div class="h3 mb-0">{{ number_format($grandTotal['paket_total'], 0, ',', '.') }}</div>
            </div>
            <div class="text-end">
              <i class="fas fa-box fa-2x ms-3"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card box-green text-white shadow-sm">
          <div class="card-body d-flex align-items-center">
            <div class="flex-grow-1">
              <div class="text-uppercase small font-weight-bold">TOTAL PAGU</div>
              <div class="h3 mb-0">Rp {{ number_format($grandTotal['pagu_total'], 0, ',', '.') }}</div>
            </div>
            <div class="text-end">
              <i class="fas fa-money-bill-wave fa-2x ms-3"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Tabel --}}
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Rekapitulasi RUP</h3>
        <div class="ml-auto">
          <a href="{{ route('report.rup.pdf', ['tahun' => $tahun, 'satker' => $kdSatkerFilter]) }}"
             class="btn btn-success btn-sm" target="_blank">
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

    // Select2 untuk filter
    $('select[name="tahun"], select[name="satker"]').select2({
      width: 'resolve',
      minimumResultsForSearch: 5
    }).on('change', function () {
      $('#filterForm').submit();
    });
  });
</script>
@endpush
