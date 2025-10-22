@extends('layouts.adminlte')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Grafik Summary Report</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item active">Grafik Summary Report</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Tender dan Non Tender</h3>
          </div>
          <div class="card-body">
            <canvas id="tender-non-tender" style="min-height: 270px; height: 270px; max-height: 270px; max-width: 100%;">
            </canvas>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Pengelompokkan Jenis Pengadaan Barang dan Jasa</h3>
            <!-- Dropdown untuk memilih Tender atau Non Tender -->
              <select id="jenis_pengadaan" class="form-control form-control-sm" style="width: 150px; font-size: 16px; margin-left: 50px;">
              <option value="Non Tender" {{ $jenisPengadaan == 'Non Tender' ? 'selected' : '' }}>Non Tender</option>
              <option value="Tender" {{ $jenisPengadaan == 'Tender' ? 'selected' : '' }}>Tender</option>
            </select>
          </div>
          <div class="card-body">
            <canvas id="categorize" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;">
            </canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@push('script')
<script>
$(function() {
    // Pie Chart - Tender vs Non Tender
    var pieChartCanvas = $('#tender-non-tender').get(0).getContext('2d');
    var pieData = {
        labels: ['Non Tender', 'Tender'],
        datasets: [
            {
                data: [{{ $chart1Data['Non Tender'] }}, {{ $chart1Data['Tender'] }}],
                backgroundColor: ['#f56954', '#00a65a'],
            }
        ]
    };
    var pieOptions = {
        maintainAspectRatio: false,
        responsive: true,
    };
    new Chart(pieChartCanvas, {
        type: 'pie',
        data: pieData,
        options: pieOptions
    });

    // Pie Chart - Pengelompokkan Jenis Pengadaan
    var pieChartCanvas = $('#categorize').get(0).getContext('2d');
    var pieData = {
        labels: {!! json_encode(array_keys($chart2Data->toArray())) !!},
        datasets: [
            {
                data: {!! json_encode(array_values($chart2Data->toArray())) !!},
                backgroundColor: ['#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
            }
        ]
    };
    var pieOptions = {
        maintainAspectRatio: false,
        responsive: true,
    };
    new Chart(pieChartCanvas, {
        type: 'pie',
        data: pieData,
        options: pieOptions
    });

    // Handle dropdown change to reload chart based on selected type
    $('#jenis_pengadaan').change(function() {
        var jenis = $(this).val();
        window.location.href = "{{ route('report') }}?jenis_pengadaan=" + jenis + "&tahun=" + {{ $tahun }};
    });
});
</script>
@endpush
