<!-- File: resources/views/users/home.blade.php -->
@extends('layouts.user')

@section('content')
<link href="{{ asset('css/sibaja.css') }}" rel="stylesheet">

<div class="hero-wrapper">
  <div class="hero-container">
    <div class="hero-box row align-items-center">
      <div class="col-md-6 text-center">
        <img src="{{ asset('images/gubernur-wakil.png') }}" alt="Pimpinan Daerah" class="img-fluid hero-img">
      </div>
      <div class="col-md-6 hero-text">
        <h1>Selamat Datang di Website<br>Sistem Informasi Barang<br>dan Jasa Provinsi Lampung</h1>
        <p class="mt-3">
        Selamat datang di portal resmi Sistem Informasi Barang dan Jasa Provinsi Lampung, sebuah platform digital yang dirancang untuk mendukung transparansi, akuntabilitas, dan kemudahan akses informasi terkait pengadaan barang dan jasa di lingkungan Pemerintah Provinsi Lampung. Melalui website ini, masyarakat, pelaku usaha, serta instansi terkait dapat memantau berbagai proses, data, dan perkembangan pengadaan secara terbuka dan terintegrasi, sehingga diharapkan dapat mewujudkan tata kelola pemerintahan yang lebih baik, bersih, dan berorientasi pada pelayanan publik yang prima.        </p>
        <a href="#tentang" class="hero-btn mt-3">
  Selengkapnya
  <i class="bi bi-arrow-down ms-2"></i>
</a>



      </div>
    </div>
  </div>
</div>

<!-- SECTION: Summary Report -->
<div class="py-4" style="background-color: #F5F8FD;">
  <div class="container-fluid px-4 py-4 d-flex justify-content-center">
    <div class="bg-white p-4 rounded w-100" style="max-width: 1140px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">

      <h3 class="fw-bold mb-0 text-primary">Statistik Umum Pengadaan</h3>
      <p class="text-muted">Menampilkan data ringkas mengenai jumlah paket pengadaan dan instansi aktif.</p>

      <div class="row row-cols-1 row-cols-md-2 g-3 mt-4">
        {{-- Non Tender --}}
        <div class="col">
          <div class="d-flex justify-content-between align-items-center border rounded p-3 bg-white shadow-sm">
            <div class="d-flex align-items-center">
              <div class="p-2 rounded me-3" style="background-color: #DDEEFF;">
                <i class="fas fa-chart-line fs-4" style="color: #3366CC;"></i>
              </div>
              <div>
                <div class="fw-bold fs-4">{{ number_format($nonTenderCount, 0, ',', '.') }}</div>
                <div class="text-muted">Non Tender</div>
              </div>
            </div>
            <a href="{{ route('non-tender.list') }}" class="btn"
               style="background-color: #1d3c77; color: white;"
               onmouseover="this.style.backgroundColor='#2181EF'"
               onmouseout="this.style.backgroundColor='#1d3c77'">
               Lihat
            </a>
          </div>
        </div>

        {{-- E-Katalog --}}
        <div class="col">
          <div class="d-flex justify-content-between align-items-center border rounded p-3 bg-white shadow-sm">
            <div class="d-flex align-items-center">
              <div class="p-2 rounded me-3" style="background-color: #DDEEFF;">
                <i class="fas fa-store fs-4" style="color: #3366CC;"></i>
              </div>
              <div>
                <div class="fw-bold fs-4">{{ number_format($ekatalogCount, 0, ',', '.') }}</div>
                <div class="text-muted">Total E-Katalog</div>
              </div>
            </div>
            <a href="{{ route('report.ekatalog') }}" class="btn"
               style="background-color: #1d3c77; color: white;"
               onmouseover="this.style.backgroundColor='#2181EF'"
               onmouseout="this.style.backgroundColor='#1d3c77'">
               Lihat
            </a>
          </div>
        </div>

        {{-- Tender --}}
        <div class="col">
          <div class="d-flex justify-content-between align-items-center border rounded p-3 bg-white shadow-sm">
            <div class="d-flex align-items-center">
              <div class="p-2 rounded me-3" style="background-color: #DDEEFF;">
                <i class="fas fa-chart-bar fs-4" style="color: #3366CC;"></i>
              </div>
              <div>
                <div class="fw-bold fs-4">{{ number_format($tenderCount, 0, ',', '.') }}</div>
                <div class="text-muted">Tender</div>
              </div>
            </div>
            <a href="{{ route('tender.list') }}" class="btn"
               style="background-color: #1d3c77; color: white;"
               onmouseover="this.style.backgroundColor='#2181EF'"
               onmouseout="this.style.backgroundColor='#1d3c77'">
               Lihat
            </a>
          </div>
        </div>

        {{-- Toko Daring --}}
        <div class="col">
          <div class="d-flex justify-content-between align-items-center border rounded p-3 bg-white shadow-sm">
            <div class="d-flex align-items-center">
              <div class="p-2 rounded me-3" style="background-color: #DDEEFF;">
                <i class="fas fa-shopping-cart fs-4" style="color: #3366CC;"></i>
              </div>
              <div>
                <div class="fw-bold fs-4">{{ number_format($belaCount, 0, ',', '.') }}</div>
                <div class="text-muted">Total Toko Daring</div>
              </div>
            </div>
            <a href="{{ route('report.tokodaring') }}" class="btn"
               style="background-color: #1d3c77; color: white;"
               onmouseover="this.style.backgroundColor='#2181EF'"
               onmouseout="this.style.backgroundColor='#1d3c77'">
               Lihat
            </a>
          </div>
        </div>
      </div>

<!-- CHART -->
<div class="row mt-5">
  <!-- Chart 1: Distribusi Sumber Pengadaan -->
  <div class="col-md-6 mb-4 mb-md-0">
    <div class="card border">
<div class="card-header fw-bold">
  Distribusi Pengadaan Tahun {{ $tahun }}
</div>

      <div class="card-body" style="background-color: white;">
        <canvas id="chart1" height="227"></canvas>
      </div>
    </div>
  </div>

  <!-- Chart 2: Jenis Barang dan Jasa -->
  <div class="col-md-6">
    <div class="card border">
      <div class="card-header fw-bold d-flex justify-content-between align-items-center">
        Pengelompokan Jenis Barang dan Jasa
        <form method="GET" id="kategoriForm">
          <input type="hidden" name="tahun" value="{{ $tahun }}">
          <select id="chart2Filter" name="kategori_chart2" class="form-select form-select-sm w-auto">
            <option value="tender" {{ $kategoriChart2 == 'tender' ? 'selected' : '' }}>Tender</option>
            <option value="non_tender" {{ $kategoriChart2 == 'non_tender' ? 'selected' : '' }}>Non Tender</option>
          </select>
        </form>
      </div>
      <div class="card-body" style="background-color: white;">
        <canvas id="chart2" height="220"></canvas>
      </div>
    </div>
  </div>
</div>



    </div>
  </div>
</div>








<!-- Strip Biru Vertikal -->
<div class="strip-wrapper position-relative">
  <div class="vertical-blue-strip"></div>

  <!-- SECTION: Tentang Kami -->
  <section id="tentang" class="tentang-kami-section">
    <div class="background-abu-kanan"></div>

    <div class="container-lg position-relative">
        <div class="kantor-wrapper d-flex justify-content-center">
    <div id="carouselKantor" class="carousel slide kantor-carousel" data-bs-ride="carousel">
        <div class="kantor-carousel-inner"> <!-- Ganti .carousel-inner jadi .kantor-carousel-inner -->
            <!-- Gambar Kantor 1 -->
            <div class="kantor-carousel-item active"> <!-- Ganti .carousel-item jadi .kantor-carousel-item -->
                <div class="carousel-image-wrapper">
                    <img src="{{ asset('images/Kantor1.png') }}" class="d-block kantor-carousel-img" alt="Kantor 1">
                    <div class="overlay"></div>
                </div>
            </div>          
            <!-- Gambar Kantor 2 -->
            <div class="kantor-carousel-item"> <!-- Ganti .carousel-item jadi .kantor-carousel-item -->
                <div class="carousel-image-wrapper">
                    <img src="{{ asset('images/Kantor2.png') }}" class="d-block kantor-carousel-img" alt="Kantor 2">
                    <div class="overlay"></div>
                </div>
            </div>
        </div>
    </div>
</div>


        <div class="tentang-box animate-up shadow">
            <h6 class="text-primary fw-semibold mb-1">Tentang Kami</h6>
            <h4 class="fw-bold mb-5">LPSE - Biro Pengadaan Barang dan Jasa Provinsi Lampung</h4>
            <div class="mb-0">
                <h6 class="fw-bold mb-4">VISI DAN MISI</h6>
                <div class="mb-3">
                    <strong>VISI</strong><br>
                    <em>"Terwujudnya Layanan Pengadaan Barang / Jasa Kualitas Prima Dan Berkesinambungan"</em>
                </div>

                <div>
                    <strong>MISI</strong>
                    <ol class="mt-2 mb-0 ps-3">
                        <li>Memberikan Layanan kepada Pengguna Sistem Pengadaan Secara Elektronik (SPSE) yang sederhana, Cepat, Tepat, Berkesinambungan dan Akuntabel Tanpa Dipungut Biaya.</li>
                        <li>Mengedepankan Pelayanan Yang Tertib Administrasi, Tertib Hukum dan Tertib Pelaksanaan.</li>
                    </ol>
                </div>
            </div>

            <!-- Tambahkan spacer DIV setelah teks -->
            <div style="height: 3rem;"></div>
        </div>
    </div>
</section>

</div>


<!-- SECTION: Laporan Pengadaan Tahun 2025 -->
<section class="transparansi-wrapper position-relative py-5">
  <div class="background-abu-kanan transparansi-abu"></div>

  <div class="container position-relative">
    <div class="transparansi-card shadow-lg p-4 bg-white">
      <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
        <div>
        <h4 class="fw-bold text-dark">Laporan Pengadaan Tahun {{ date('Y') }}</h4>
        <p class="text-muted">Publikasi data kinerja pengadaan barang/jasa Pemerintah Provinsi Lampung Tahun Anggaran {{ date('Y') }}</p>

        </div>
      </div>

      <div id="carouselPDF" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
        <div class="carousel-inner">
          <!-- SLIDE 1 -->
          <div class="carousel-item active">
            <div class="d-flex gap-3 flex-wrap justify-content-center">

              <!-- Tender -->
              <div class="pdf-card">
                <div class="text-center mb-2">
                  <img src="{{ asset('images/pdf-icon.png') }}" width="150" alt="PDF">
                </div>
                <small class="text-muted">Laporan Tender</small>
                <h6 class="fw-bold mt-1">Rekap Tender</h6>
                <p class="desc-text">Jumlah dan nilai seluruh paket tender aktif dan selesai</p>
                <div class="d-flex gap-2 mt-2">
                <a href="{{ route('tender.view-pdf', ['year' => $today->year, 'month' => 'ALL', 'day' => 'ALL']) }}" target="_blank" class="btn btn-sm btn-pdf-outline w-100"><i class="bi bi-eye"></i> Lihat</a>
                <a href="{{ route('tender.download-pdf', ['year' => $today->year, 'month' => 'ALL', 'day' => 'ALL']) }}" class="btn btn-sm hero-btn w-100 d-flex justify-content-center align-items-center"><i class="bi bi-download me-1"></i> Unduh</a>
                </div>
              </div>

              <!-- Non Tender -->
              @php $today = \Carbon\Carbon::now(); @endphp
              <div class="pdf-card">
                <div class="text-center mb-2">
                  <img src="{{ asset('images/pdf-icon.png') }}" width="150" alt="PDF">
                </div>
                <small class="text-muted">Laporan Non Tender</small>
                <h6 class="fw-bold mt-1">Rekap Non Tender</h6>
                <p class="desc-text">Data paket non tender yang berlangsung dan selesai</p>
                <div class="d-flex gap-2 mt-2">
                  <a href="{{ route('non-tender.viewPdf', ['year' => $today->year, 'month' => 'ALL', 'day' => 'ALL']) }}" target="_blank" class="btn btn-sm btn-pdf-outline w-100">
                    <i class="bi bi-eye"></i> Lihat
                  </a>
                  <a href="{{ route('non-tender.downloadPdf', ['year' => $today->year, 'month' => 'ALL', 'day' => 'ALL']) }}" class="btn btn-sm hero-btn w-100 d-flex justify-content-center align-items-center">
                    <i class="bi bi-download me-1"></i> Unduh
                  </a>
                </div>
              </div>

               <!-- RUP -->
               <div class="pdf-card">
                <div class="text-center mb-2">
                  <img src="{{ asset('images/pdf-icon.png') }}" width="150" alt="PDF">
                </div>
                <small class="text-muted">Laporan RUP</small>
                <h6 class="fw-bold mt-1">RUP Provinsi Lampung</h6>
                <p class="desc-text">Total paket RUP dan pagu belanja pengadaan untuk seluruh OPD</p>
                <div class="d-flex gap-2 mt-2">
                  <a href="{{ route('report.rup.pdf', ['tahun' => 2025]) }}" target="_blank" class="btn btn-sm btn-pdf-outline w-100">
                    <i class="bi bi-eye"></i> Lihat
                  </a>
                  <a href="{{ route('report.rup.pdf', ['tahun' => 2025, 'mode' => 'D']) }}" class="btn btn-sm hero-btn w-100 d-flex justify-content-center align-items-center">
                    <i class="bi bi-download me-1"></i> Unduh
                  </a>
                </div>
              </div>

            </div>
          </div>

          <!-- SLIDE 2 -->
          <div class="carousel-item">
            <div class="d-flex gap-3 flex-wrap justify-content-center">

              <!-- Toko Daring -->
              <div class="pdf-card">
                <div class="text-center mb-2">
                  <img src="{{ asset('images/pdf-icon.png') }}" width="150" alt="PDF">
                </div>
                <small class="text-muted">Laporan Toko Daring</small>
                <h6 class="fw-bold mt-1">Realisasi Toko Daring</h6>
                <p class="desc-text">Ringkasan pengadaan barang/jasa melalui sistem toko daring</p>
                <div class="d-flex gap-2 mt-2">
                  <a href="{{ route('report.tokodaring.exportpdf', ['tahun' => 2025]) }}" target="_blank" class="btn btn-sm btn-pdf-outline w-100">
                    <i class="bi bi-eye"></i> Lihat
                  </a>
                  <a href="{{ route('report.tokodaring.exportpdf', ['tahun' => 2025, 'mode' => 'D']) }}" class="btn btn-sm hero-btn w-100 d-flex justify-content-center align-items-center">
                    <i class="bi bi-download me-1"></i> Unduh
                  </a>
                </div>
              </div>

           
            <!-- e-Katalog V6 -->
            <div class="pdf-card">
                <div class="text-center mb-2">
                  <img src="{{ asset('images/pdf-icon.png') }}" width="150" alt="PDF">
                </div>
                <small class="text-muted">Laporan E-Katalog V6</small>
                <h6 class="fw-bold mt-1">Transaksi E-Katalog V6</h6>
                <p class="desc-text">Total nilai dan jumlah transaksi melalui e-Katalog versi 6</p>
                <div class="d-flex gap-2 mt-2">
                  <a href="{{ route('report.ekatalog.exportpdf', ['tahun' => 2025, 'versi' => 'V6']) }}" target="_blank" class="btn btn-sm btn-pdf-outline w-100">
                    <i class="bi bi-eye"></i> Lihat
                  </a>
                  <a href="{{ route('report.ekatalog.exportpdf', ['tahun' => 2025, 'versi' => 'V6', 'mode' => 'D']) }}" class="btn btn-sm hero-btn w-100 d-flex justify-content-center align-items-center">
                    <i class="bi bi-download me-1"></i> Unduh
                  </a>
                </div>
              </div>
             <!-- e-Katalog V5 -->
<div class="pdf-card">
                <div class="text-center mb-2">
                  <img src="{{ asset('images/pdf-icon.png') }}" width="150" alt="PDF">
                </div>
                <small class="text-muted">Laporan E-Katalog V5</small>
                <h6 class="fw-bold mt-1">Transaksi E-Katalog V5</h6>
                <p class="desc-text">Total nilai transaksi pengadaan menggunakan e-Katalog versi 5</p>
                <div class="d-flex gap-2 mt-2">
                  <a href="{{ route('report.ekatalog.exportpdf', ['tahun' => 2025, 'versi' => 'V5']) }}" target="_blank" class="btn btn-sm btn-pdf-outline w-100">
                    <i class="bi bi-eye"></i> Lihat
                  </a>
                  <a href="{{ route('report.ekatalog.exportpdf', ['tahun' => 2025, 'versi' => 'V5', 'mode' => 'D']) }}" class="btn btn-sm hero-btn w-100 d-flex justify-content-center align-items-center">
                    <i class="bi bi-download me-1"></i> Unduh
                  </a>
                </div>
              </div>


            </div>
          </div>

          <!-- SLIDE 3 -->
          <div class="carousel-item">
            <div class="d-flex gap-3 flex-wrap justify-content-center">
            @php
            $today = \Carbon\Carbon::now();
            @endphp

              <!-- Monitoring -->
              <div class="pdf-card">
                <div class="text-center mb-2">
                  <img src="{{ asset('images/pdf-icon.png') }}" width="150" alt="PDF">
                </div>
                <small class="text-muted">Realisasi Pengadaan</small>
                <h6 class="fw-bold mt-1"> Rekap Realisasi Selesai Pengadaan</h6>
                <p class="desc-text">Persentase realisasi pengadaan terhadap total belanja pengadaan</p>
                <div class="d-flex gap-2 mt-2">
                <a href="{{ route('monitoring.rekap.realisasi.pdf', ['tahun' => $today->year]) }}" target="_blank" class="btn btn-sm btn-pdf-outline w-100"><i class="bi bi-eye"></i> Lihat</a>
                <a href="{{ route('monitoring.rekap.realisasi.pdf', ['tahun' => $today->year, 'mode' => 'D']) }}" class="btn btn-sm hero-btn w-100 d-flex justify-content-center align-items-center"><i class="bi bi-download me-1"></i> Unduh</a>
                </div>
              </div>
 <!-- Monitoring -->
 <div class="pdf-card">
                <div class="text-center mb-2">
                <img src="{{ asset('images/pdf-icon.png') }}" width="150" alt="PDF">
                </div>
                <small class="text-muted">Realisasi Pengadaan</small>
                <h6 class="fw-bold mt-1">Rekap Realisasi Berlangsung Pengadaan</h6>
                <p class="desc-text">Persentase realisasi pengadaan terhadap total belanja pengadaan</p>
                <div class="d-flex gap-2 mt-2">
                <a href="{{ route('monitoring.rekap.realisasi-berlangsung.pdf', ['tahun' => $today->year,'mode' => 'V']) }}" target="_blank" class="btn btn-sm btn-pdf-outline w-100"><i class="bi bi-eye"></i> Lihat</a>
                <a href="{{ route('monitoring.rekap.realisasi-berlangsung.pdf', ['tahun' => $today->year,'mode' => 'D']) }}" class="btn btn-sm hero-btn w-100 d-flex justify-content-center align-items-center"><i class="bi bi-download me-1"></i> Unduh</a>
                </div>
                </div>

                <div class="pdf-card">
                <div class="text-center mb-2">
                  <img src="{{ asset('images/pdf-icon.png') }}" width="150" alt="PDF">
                </div>
                <small class="text-muted">Realisasi Pengadaan </small>
                <h6 class="fw-bold mt-1">Monitoring Pengadaan</h6>
                <p class="desc-text">Persentase realisasi pengadaan terhadap total belanja pengadaan</p>
                <div class="d-flex gap-2 mt-2">
                <a href="{{ route('monitoring.realisasi.pdf', ['year' => $today->year, 'month' => 'ALL', 'day' => 'ALL']) }}" target="_blank" class="btn btn-sm btn-pdf-outline w-100"><i class="bi bi-eye"></i> Lihat</a>
                <a href="{{ route('monitoring.realisasi.pdf', ['year' => $today->year, 'month' => 'ALL', 'day' => 'ALL', 'mode' => 'D']) }}" class="btn btn-sm hero-btn w-100 d-flex justify-content-center align-items-center"><i class="bi bi-download me-1"></i> Unduh</a>
                  </a>
                </div>
              </div>

            </div>
          </div>

        </div>

        <!-- PANAH -->
        <button class="carousel-control-prev inside-arrow" type="button" data-bs-target="#carouselPDF" data-bs-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next inside-arrow" type="button" data-bs-target="#carouselPDF" data-bs-slide="next">
          <span class="carousel-control-next-icon"></span>
        </button>

        <!-- BULLETS -->
        <div class="carousel-indicators mt-4">
          <button type="button" data-bs-target="#carouselPDF" data-bs-slide-to="0" class="active indicator-dot"></button>
          <button type="button" data-bs-target="#carouselPDF" data-bs-slide-to="1" class="indicator-dot"></button>
          <button type="button" data-bs-target="#carouselPDF" data-bs-slide-to="2" class="indicator-dot"></button>
        </div>

      </div> <!-- end carousel -->
    </div> <!-- end transparansi-card -->
  </div> <!-- end container -->
</section>
@endsection


@push('styles')
<style>
  .btn-primary-custom {
    background-color: #3366CC;
    color: white;
    border: none;
    transition: background-color 0.3s ease;
  }
  .btn-primary-custom:hover {
    background-color: #254a99;
    color: white;
  }

  /* Optional: fokus/active */
  .btn-primary-custom:focus, .btn-primary-custom:active {
    outline: none;
    box-shadow: 0 0 0 0.2rem rgba(51, 102, 204, 0.25);
  }
</style>
@endpush


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
  // CHART 1: Sumber Pengadaan
  const chart1Data = {!! json_encode($chart1Data) !!};
  const chart1Labels = Object.keys(chart1Data);
  const chart1Values = Object.values(chart1Data);

  new Chart(document.getElementById('chart1'), {
    type: 'pie',
    data: {
      labels: chart1Labels,
      datasets: [{
        data: chart1Values,
        backgroundColor: ['#569FB2', '#86D7B7']
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'right',
          align: 'center',
          labels: {
            usePointStyle: true,
            pointStyle: 'circle',
            boxWidth: 10
          }
        }
      }
    }
  });

  // CHART 2: Jenis Pengadaan Berdasarkan Kategori
  let chart2Instance = new Chart(document.getElementById('chart2'), {
    type: 'pie',
    data: {
      labels: {!! json_encode($chart2Data->keys()->toArray()) !!},
      datasets: [{
        data: {!! json_encode($chart2Data->values()->toArray()) !!},
        backgroundColor: ['#7B3F9B', '#2D6A8D', '#6CB34A', '#F0D43A', '#E88C3C', '#5C8DF6']
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'right',
          align: 'center',
          labels: {
            usePointStyle: true,
            pointStyle: 'circle',
            boxWidth: 10
          }
        }
      }
    }
  });

  // Form auto-submit handlers untuk filter
  const tahunFilter = document.getElementById('tahunFilter');
  const kategoriFilter = document.getElementById('chart2Filter');
  
  if (tahunFilter) {
    tahunFilter.addEventListener('change', function () {
      document.getElementById('tahunForm').submit();
    });
  }

  if (kategoriFilter) {
    kategoriFilter.addEventListener('change', function () {
      // Jika kategori filter berubah, kita akan ambil data baru melalui AJAX
      updateChartData();
    });
  }

  // Fungsi untuk update chart2 dengan AJAX
  function updateChartData() {
    const kategori = kategoriFilter.value;
    const tahun = {{ $tahun }};  // Mengambil nilai tahun dari Blade

    // Kirim request AJAX ke backend untuk mengambil data chart baru
    fetch(`/update-chart-data?kategori_chart2=${kategori}&tahun=${tahun}`)
      .then(response => response.json())
      .then(data => {
        // Update chart2 dengan data baru
        const chart2Data = data.chart2Data;
        const chart2Labels = Object.keys(chart2Data);
        const chart2Values = Object.values(chart2Data);

        // Menghentikan chart sebelumnya dan membuat chart baru dengan data yang diperbarui
        chart2Instance.destroy();
        chart2Instance = new Chart(document.getElementById('chart2'), {
          type: 'pie',
          data: {
            labels: chart2Labels,
            datasets: [{
              data: chart2Values,
              backgroundColor: ['#7B3F9B', '#2D6A8D', '#6CB34A', '#F0D43A', '#E88C3C', '#5C8DF6'].slice(0, chart2Labels.length)
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                position: 'right',
                align: 'center',
                labels: {
                  usePointStyle: true,
                  pointStyle: 'circle',
                  boxWidth: 10
                }
              }
            }
          }
        });
      })
      .catch(error => {
        console.error('Error updating chart:', error);
      });
  }
});
</script>




<script>
  document.addEventListener("DOMContentLoaded", function () {
    const box = document.querySelector('.tentang-box.animate-up');

    if (!box) return;

    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          box.classList.add("show");
        } else {
          box.classList.remove("show");
        }
      });
    }, { threshold: 0.4 });

    observer.observe(box);
  });
</script>
<script>
  function updateClock() {
    const now = new Date();

    const jam = now.getHours().toString().padStart(2, '0');
    const menit = now.getMinutes().toString().padStart(2, '0');
    const detik = now.getSeconds().toString().padStart(2, '0');

    document.getElementById('jam-box').textContent = jam;
    document.getElementById('menit-box').textContent = menit;
    document.getElementById('detik-box').textContent = detik;
  }

  document.addEventListener("DOMContentLoaded", function () {
    updateClock();
    setInterval(updateClock, 1000);
  });
</script>



@endpush






