@extends('layouts.user-adminlte')

@push('style')
<link rel="stylesheet" href="{{ url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ url('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/sibaja.css') }}">
<style>
  .small-box.bg-warning { background-color: #ffc107 !important; color: #000 !important; }
  .small-box.bg-info { background-color: #17a2b8 !important; color: #fff !important; }
  .small-box.bg-success { background-color: #28a745 !important; color: #fff !important; }
  .small-box.bg-danger { background-color: #dc3545 !important; color: #fff !important; }
  .small-box .inner h3, .small-box .inner p { color: inherit !important; }

  /* === FILTER BAR: Seragamkan, Responsive, Select2 Ikut Bundar === */
  .filter-bar .form-control,
  .filter-bar select.form-control,
  .filter-bar input.form-control {
    border-radius: 8px !important;
    border: 1.5px solid #d5d7e4 !important;
    box-shadow: none !important;
    background: #fff !important;
    font-size: 1rem;
    height: 38px;
    transition: border-color 0.2s;
  }
  .filter-bar .form-control:focus {
    border-color: #2b529a !important;
    outline: none !important;
    box-shadow: 0 0 0 2px rgba(43,82,154,0.10);
  }
  .filter-bar label {
    font-weight: 500;
    color: #1d3c77;
    font-size: 0.97rem;
    margin-bottom: 4px;
  }
  .select2-container--default .select2-selection--single {
    border-radius: 8px !important;
    border: 1.5px solid #d5d7e4 !important;
    height: 38px !important;
    padding: 4px 12px !important;
    font-size: 1rem;
    background: #fff !important;
    transition: border-color 0.2s;
    display: flex;
    align-items: center;
  }
  .select2-container--default .select2-selection--single:focus {
    border-color: #2b529a !important;
    box-shadow: 0 0 0 2px rgba(43,82,154,0.12);
  }
  /* Agar select2 full width */
  .select2-container {
    width: 100% !important;
    min-width: 0 !important;
    max-width: 100% !important;
    box-sizing: border-box;
  }
  /* Responsive: kolom filter jadi satu baris per filter di mobile */
  @media (max-width: 991px) {
    .filter-bar .col-md-2,
    .filter-bar .col-md-3 {
      width: 100%;
      max-width: 100%;
      flex: 0 0 100%;
      margin-bottom: 16px;
    }
  }
  @media (max-width: 768px) {
    .filter-bar label {
      font-size: 1rem;
    }
    .filter-bar .form-control,
    .select2-container--default .select2-selection--single {
      font-size: 0.97rem;
      height: 38px !important;
    }
    .filter-bar .col-md-2,
    .filter-bar .col-md-3 {
      margin-bottom: 12px;
    }
  }

  /* ======= KHUSUS SELECT2 FILTER SATKER: label turun ======= */
  #kd_satker.select2-hidden-accessible + .select2-container .select2-selection--single {
    padding-top: 7px !important; 
    min-height: 38px !important;
  }
  #kd_satker.select2-hidden-accessible + .select2-container .select2-selection__rendered {
    padding-top: 2px !important;  
  }
</style>
@endpush

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6"><h1 class="m-0">Tender</h1></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right"><li class="breadcrumb-item active">Tender</li></ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    @include('components.summary')

    <div class="row filter-bar">
      <div class="col-md-2">
        <label for="filter-kode">Kode</label>
        <input id="filter-kode" type="text" placeholder="Kode" class="form-control" value="{{ request('code') }}">
      </div>
      <div class="col-md-3">
        <label for="filter-nama">Nama Paket</label>
        <input id="filter-nama" type="text" placeholder="Nama Paket" class="form-control" value="{{ request('name') }}">
      </div>
      <div class="col-md-3">
        <label for="kd_satker">Satuan Kerja</label>
        <select name="kd_satker" id="kd_satker" class="form-control select2" onchange="filterBySatker()">
          <option value="">--Semua Satuan Kerja---</option>
          @foreach ($satkers as $item)
            <option value="{{ $item->kd_satker_str }}" {{ $satkerCode == $item->kd_satker_str ? 'selected' : '' }}>
              {{ $item->nama_satker }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
        <label for="year">Tahun</label>
        <select name="year" id="year" class="form-control" onchange="filterBySatker()">
          <option value="">--Pilih---</option>
          @foreach ($years as $item)
            <option value="{{ $item }}" {{ $year == $item ? 'selected' : '' }}>{{ $item }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
        <label for="status_tender">Status</label>
        <select name="status_tender" id="status_tender" class="form-control" onchange="filterBySatker()">
          @foreach ($statusList as $key => $val)
            <option value="{{ $key }}" {{ $status == $key ? 'selected' : '' }}>{{ $val }}</option>
          @endforeach
        </select>
      </div>
    </div>

    @php
      $urlBase = url()->current()
        . '?year=' . urlencode($year)
        . '&kd_satker=' . urlencode($satkerCode)
        . '&code=' . urlencode($code)
        . '&name=' . urlencode($name)
        . '&status_tender=' . urlencode($status);
    @endphp

    <div class="row mt-3">
      <div class="col-12">
        <div class="mb-3">
          <a href="{{ $urlBase }}" class="text-sm @if(!$categoryParam) bg-success @else bg-secondary @endif py-1 px-2 d-inline-block mb-1 rounded">
            Semua ({{ $totalFull }})
          </a>
          @foreach ($categories as $key => $value)
            <a href="{{ $urlBase . '&category=' . urlencode($value) }}" class="text-sm @if($categoryParam == $value) bg-success @else bg-secondary @endif py-1 px-2 d-inline-block rounded mb-1">
              {{ $value . ' (' . $categoriesCount[$key] . ')' }}
            </a>
          @endforeach
        </div>

        <div class="card">
          <div class="card-body table-responsive p-0">
            <table id="tenderTable" class="table table-head-fixed table-hover">
              <thead>
                <tr>
                  <th>Kode Tender</th>
                  <th>Nama Paket</th>
                  <th>Status Tender</th>
                  <th>HPS</th>
                  <th>Nilai PDN Kontrak</th>
                  <th>Nilai UMK Kontrak</th>
                </tr>
              </thead>
              <tbody>
                @include('components.tables.tender-rows', ['data' => $data])
              </tbody>
            </table>
          </div>
          <div class="card-footer clearfix">
            @if ($data->lastPage() > 1)
              <div class="pagination-container">
                {{ $data->links('pagination::bootstrap-4') }}
              </div>
            @endif
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
@endsection

@push('script')
<script src="{{ url('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script>
$(function () {
  $('.select2').select2();

  let categoryParam = @json($categoryParam);

  $('#filter-kode, #filter-nama').on('keyup', function () {
    searchTender(1);
  });

  $(document).on('click', '.pagination-container a', function(e) {
    e.preventDefault();
    let url = new URL($(this).attr('href'), window.location.origin);
    let page = url.searchParams.get('page') || 1;
    searchTender(page);
  });

  function searchTender(page = 1) {
    const code = $('#filter-kode').val().trim();
    const name = $('#filter-nama').val().trim();
    const kd_satker = $('#kd_satker').val();
    const year = $('#year').val();
    const status_tender = $('#status_tender').val();

    $.ajax({
      url: "{{ route('tender.search') }}",
      data: {
        code, name, kd_satker, year,
        category: categoryParam,
        status_tender,
        page
      },
      success: function (response) {
        $('#tenderTable tbody').html(response.html);
        if (response.lastPage > 1) {
          $('.pagination-container').html(response.pagination).show();
        } else {
          $('.pagination-container').hide();
        }
      },
      error: function () {
        $('#tenderTable tbody').html('<tr><td colspan="6" class="text-center text-danger">Gagal memuat data</td></tr>');
        $('.pagination-container').hide();
      }
    });
  }

  // Dropdowns reload page
  window.filterBySatker = function() {
    const satker = $('#kd_satker').val();
    const year = $('#year').val();
    const status = $('#status_tender').val();
    const url = new URL(window.location.href.split('?')[0]);
    if (satker) url.searchParams.set('kd_satker', satker);
    if (year) url.searchParams.set('year', year);
    if (status) url.searchParams.set('status_tender', status);
    else url.searchParams.delete('status_tender');
    window.location.href = url.toString();
  }
});
</script>
@endpush
