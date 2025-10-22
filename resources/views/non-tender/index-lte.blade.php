@extends('layouts.adminlte')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6"><h1 class="m-0">Non Tender</h1></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right"><li class="breadcrumb-item active">Non Tender</li></ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    @include('components.summary')

    <div class="row filter-row">
      <div class="col-md-2 col-sm-6">
        <label for="filter-kode" class="filter-label">Kode</label>
        <input id="filter-kode" type="text" placeholder="Kode" class="form-control" value="{{ request('code') }}">
      </div>
      <div class="col-md-3 col-sm-6">
        <label for="filter-nama" class="filter-label">Nama Paket</label>
        <input id="filter-nama" type="text" placeholder="Nama Paket" class="form-control" value="{{ request('name') }}">
      </div>
      <div class="col-md-3 col-sm-6">
        <label for="kd_satker" class="filter-label">Satuan Kerja</label>
        <select name="kd_satker" id="kd_satker" class="form-control select2" onchange="filterBySatker()">
          <option value="">--Semua Satuan Kerja---</option>
          @foreach ($satkers as $item)
            <option value="{{ $item->kd_satker_str }}" {{ $satkerCode == $item->kd_satker_str ? 'selected' : '' }}>
              {{ $item->nama_satker }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2 col-sm-6">
        <label for="year" class="filter-label">Tahun</label>
        <select name="year" id="year" class="form-control" onchange="filterBySatker()">
          <option value="">--Pilih---</option>
          @foreach ($years as $item)
            <option value="{{ $item }}" {{ $year == $item ? 'selected' : '' }}>{{ $item }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2 col-sm-6">
        <label for="status_nontender" class="filter-label">Status</label>
        <select name="status_nontender" id="status_nontender" class="form-control" onchange="filterBySatker()">
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
        . '&status_nontender=' . urlencode($status);
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
            <table id="nontenderTable" class="table table-head-fixed table-hover">
              <thead>
                <tr>
                  <th>Kode Non Tender</th>
                  <th>Nama Paket</th>
                  <th>Status Non Tender</th>
                  <th>HPS</th>
                  <th>Nilai PDN Kontrak</th>
                  <th>Nilai UMK Kontrak</th>
                </tr>
              </thead>
              <tbody>
                @include('components.tables.nontender-rows', ['data' => $data])
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

@push('style')
<style>
  /* Responsive filter row */
  .filter-row > [class^="col-"] {
    margin-bottom: 12px;
  }
  @media (max-width: 767.98px) {
    .filter-row > [class^="col-"] {
      flex: 0 0 100%;
      max-width: 100%;
    }
  }
  @media (min-width: 768px) and (max-width: 991.98px) {
    .filter-row > [class^="col-"] {
      flex: 0 0 50%;
      max-width: 50%;
    }
  }
  /* Filter label: lebih kecil, bold, agak naik */
  .filter-label {
    font-size: 12px;
    font-weight: 500;
    color: #444;
    margin-bottom: 1px;
    margin-top: -3px;
    display: inline-block;
    letter-spacing: 0.2px;
  }
  /* Select2 - Full width always, text turun, padding top sedikit lebih kecil */
  .select2-container {
    width: 100% !important;
    min-width: 0 !important;
  }
  .select2-selection--single {
    height: 38px !important;
    padding: 4px 12px 2px 12px !important; /* padding top lebih kecil, bottom sedikit, biar isi turun */
    font-size: 1rem;
    display: flex;
    align-items: flex-end; /* text isi lebih turun */
  }
  .select2-selection__rendered {
    line-height: 32px !important;
    padding-left: 6px !important;
    color: #222 !important;
  }
  .select2-selection__arrow {
    height: 34px !important;
    right: 8px !important;
  }
  /* Table responsiveness */
  .table-responsive {
    overflow-x: auto;
  }
  /* Pagination mobile scroll */
  @media (max-width: 576px) {
    .pagination-container {
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
      width: 100%;
      padding-bottom: 8px;
    }
    .pagination {
      flex-wrap: nowrap !important;
      white-space: nowrap;
    }
    .pagination li.page-item {
      display: inline-block;
    }
    .pagination li.page-item a, .pagination li.page-item span {
      font-size: 13px;
      padding: 6px 8px;
      min-width: 36px;
      text-align: center;
    }
    .pagination li.page-item.active a {
      font-weight: bold;
    }
  }
</style>
@endpush

@push('script')
<script src="{{ url('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script>
$(function () {
  $('.select2').select2();

  // Keep the category param up-to-date in JS
  let categoryParam = @json($categoryParam);

  // Always reset to page 1 when search box changed
  $('#filter-kode, #filter-nama').on('keyup', function () {
    searchNonTender(1);
  });

  // Pagination click AJAX
  $(document).on('click', '.pagination-container a', function(e) {
    e.preventDefault();
    let url = new URL($(this).attr('href'), window.location.origin);
    let page = url.searchParams.get('page') || 1;
    searchNonTender(page);
  });

  function searchNonTender(page = 1) {
    const code = $('#filter-kode').val().trim();
    const name = $('#filter-nama').val().trim();
    const kd_satker = $('#kd_satker').val();
    const year = $('#year').val();
    const status_nontender = $('#status_nontender').val();

    $.ajax({
      url: "{{ route('non-tender.search') }}",
      data: {
        code, name, kd_satker, year,
        category: categoryParam,
        status_nontender,
        page
      },
      success: function (response) {
        $('#nontenderTable tbody').html(response.html);
        if (response.lastPage > 1) {
          $('.pagination-container').html(response.pagination).show();
        } else {
          $('.pagination-container').hide();
        }
      },
      error: function () {
        $('#nontenderTable tbody').html('<tr><td colspan="6" class="text-center text-danger">Gagal memuat data</td></tr>');
        $('.pagination-container').hide();
      }
    });
  }

  // Dropdowns reload page (biar SEO friendly)
  window.filterBySatker = function() {
    const satker = $('#kd_satker').val();
    const year = $('#year').val();
    const status = $('#status_nontender').val();
    const url = new URL(window.location.href.split('?')[0]);
    if (satker) url.searchParams.set('kd_satker', satker);
    if (year) url.searchParams.set('year', year);
    if (status) url.searchParams.set('status_nontender', status);
    else url.searchParams.delete('status_nontender');
    window.location.href = url.toString();
  }
});
</script>
@endpush
