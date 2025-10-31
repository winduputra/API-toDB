@extends('layouts.user-adminlte')

@push('style')
<link rel="stylesheet" href="{{ url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ url('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
  body {
    background-color: #F5F8FD;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .content-wrapper, section.content {
    background-color: #F5F8FD;
    padding-bottom: 2rem;
  }

  .container {
    max-width: 1400px;
  }

  h1 {
    color: #1e3a8a;
    font-weight: 700;
    margin-bottom: 1.5rem;
    font-size: 1.8rem;
  }

  /* Filter Section */
  .filter-container {
    background-color: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    margin-bottom: 1.5rem;
  }

  .filter-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1rem;
    align-items: end;
  }

  .filter-group {
    margin-bottom: 0;
  }

  .filter-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #475569;
    font-size: 0.9rem;
  }

  .form-control {
    width: 100%;
    padding: 0.5rem 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 0.9rem;
    transition: all 0.2s;
    height: 40px;
  }

  .form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    outline: none;
  }

  /* Action Buttons */
  .action-buttons {
    display: flex;
    gap: 0.75rem;
    margin-top: 1rem;
  }

  .btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.5rem 1.25rem;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.2s;
    height: 40px;
  }

  .btn-primary {
    background-color: #2563eb;
    color: white;
    border: 1px solid #2563eb;
  }

  .btn-primary:hover {
    background-color: #1d4ed8;
    transform: translateY(-1px);
  }

  .btn i {
    font-size: 0.9rem;
  }

  /* Table Section */
  .table-wrapper {
    overflow-x: auto;
    background-color: white;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    padding: 1rem;
  }

  .table {
    width: 100%;
    font-size: 0.875rem;
    border-collapse: separate;
    border-spacing: 0;
  }

  .table th {
    background-color: #1e40af;
    color: white;
    text-align: center;
    padding: 12px 16px;
    font-weight: 600;
    position: sticky;
    top: 0;
  }

  .table td {
    padding: 12px 16px;
    vertical-align: middle;
    border-bottom: 1px solid #f1f5f9;
  }

  .table td.text-left {
    text-align: left;
  }

  .table td.text-right {
    text-align: right;
  }

  .table tbody tr:hover {
    background-color: #f8fafc;
  }

  .total-row {
    background-color: #166534;
    color: white;
    font-weight: 600;
  }

  .total-row td {
    border-bottom: none;
  }

  .no-data {
    text-align: center;
    font-style: italic;
    color: #64748b;
    padding: 2rem;
    background-color: #f8fafc;
  }

  /* Satker Search Combobox */
  .combobox-container {
    position: relative;
  }

  .combobox-input {
    padding-right: 2.5rem;
  }

  .combobox-clear {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #64748b;
    cursor: pointer;
    font-size: 1rem;
  }

  .combobox-options {
    position: absolute;
    width: 100%;
    max-height: 300px;
    overflow-y: auto;
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    z-index: 10;
    margin-top: 4px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    display: none;
  }

  .combobox-option {
    padding: 0.75rem 1rem;
    cursor: pointer;
    transition: background-color 0.1s;
  }

  .combobox-option:hover {
    background-color: #f1f5f9;
  }

  .show-options {
    display: block;
  }

  /* Responsive */
  @media (max-width: 768px) {
    .filter-grid {
      grid-template-columns: 1fr;
    }
    
    .action-buttons {
      flex-direction: column;
    }
    
    .btn {
      width: 100%;
    }
  }
</style>
@endpush

@section('content')
<div class="container my-4">
  <h1 class="mb-4">Presentase Realisasi Pengadaan terhadap RUP</h1>

  {{-- Filter Section --}}
  <div class="filter-container">
    <form method="GET" id="filter-form">
      <div class="row g-3 align-items-end">

        {{-- Pilih Tahun --}}
        <div class="col-md-3">
          <label for="tahun" class="form-label">Pilih Tahun</label>
          <select name="tahun" id="tahun" class="form-control" onchange="submitForm()">
            <option value="">-- Semua Tahun --</option>
            @foreach([2024, 2025] as $th)
              <option value="{{ $th }}" {{ request('tahun') == $th ? 'selected' : '' }}>{{ $th }}</option>
            @endforeach
          </select>
        </div>

        {{-- Nama Satker --}}
        <div class="col-md-5">
          <label for="satker_search" class="form-label">Nama Satker</label>
          <div class="position-relative">
            <input type="text" id="satker_search" class="form-control pe-5 combobox-input"
                   placeholder="Cari satker..." value="{{ request('satker') }}"
                   oninput="filterSatkerOptions()">

            <input type="hidden" name="satker" id="satker" value="{{ request('satker') }}">

            @if(request('satker'))
            <button type="button" class="btn btn-sm position-absolute top-50 end-0 translate-middle-y me-2"
                    onclick="clearSatkerSelection()" title="Kembali ke Semua"
                    style="z-index: 2;">
              <i class="fas fa-undo-alt"></i>
            </button>
            @endif
          </div>

          <div id="satker_options" class="combobox-options mt-1">
            @foreach($listSatker as $satker)
              <div class="combobox-option" data-value="{{ $satker }}" onclick="selectSatker('{{ $satker }}')">
                {{ $satker }}
              </div>
            @endforeach
          </div>
        </div>

        {{-- Tombol Export --}}
        <div class="col-md-4">
          <label class="form-label d-block invisible">Export</label>
          <a href="{{ route('monitoring.realisasi.pdf', ['tahun' => request('tahun'), 'satker' => request('satker')]) }}"
             target="_blank"
             class="btn btn-primary w-100">
            <i class="fas fa-file-pdf"></i> Export PDF
          </a>
        </div>

      </div>
    </form>
  </div>


  {{-- Table Section --}}
  <div class="table-wrapper">
    <table class="table">
      <thead>
        <tr>
          <th rowspan="2" style="width: 50px;">No</th>
          <th rowspan="2" class="text-left" style="min-width: 250px;">Nama Satker</th>
          <th colspan="3">Pengadaan</th>
        </tr>
        <tr>
          <th>Belanja Pengadaan (RUP)</th>
          <th>Total Realisasi Pengadaan <br><small>(Tender, Non-Tender, E-Katalog, Toko Daring)</small></th>
          <th>Presentase Realisasi <br><small>(D / C × 100%)</small></th>
        </tr>
      </thead>
      <tbody>
        @php
        $totalBelanja = 0;
        $totalTransaksi = 0;
        $totalPersen = 0;
        $jumlahData = $data->count();
        @endphp

        @forelse($data as $index => $item)
        @php
          $totalBelanja += $item->belanja_pengadaan;
          $totalTransaksi += $item->total_transaksi;
          $totalPersen += $item->presentase_realisasi;
        @endphp
        <tr>
          <td>{{ $index + 1 }}</td>
          <td class="text-left">{{ $item->nama_satker }}</td>
          <td class="text-right">{{ number_format($item->belanja_pengadaan, 0, ',', '.') }}</td>
          <td class="text-right">{{ number_format($item->total_transaksi, 0, ',', '.') }}</td>
          <td class="text-right"><strong>{{ number_format($item->presentase_realisasi, 2, ',', '.') }}%</strong></td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="no-data">Tidak ada data untuk tahun/satker yang dipilih.</td>
        </tr>
        @endforelse

        @if($jumlahData > 0)
        <tr class="total-row">
          <td colspan="2">TOTAL / RATA-RATA</td>
          <td class="text-right">{{ number_format($totalBelanja, 0, ',', '.') }}</td>
          <td class="text-right">{{ number_format($totalTransaksi, 0, ',', '.') }}</td>
          <td class="text-right">{{ number_format($totalPersen / $jumlahData, 2, ',', '.') }}%</td>
        </tr>
        @endif
      </tbody>
    </table>
  </div>
</div>
@endsection

@push('scripts')
<script>
  // Combined search and select functionality for Satker
  function filterSatkerOptions() {
    const input = document.getElementById('satker_search');
    const filter = input.value.toUpperCase();
    const options = document.getElementById('satker_options');
    const items = options.getElementsByClassName('combobox-option');
    
    options.classList.add('show-options');
    
    for (let i = 0; i < items.length; i++) {
      const txtValue = items[i].textContent || items[i].innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        items[i].style.display = "";
      } else {
        items[i].style.display = "none";
      }
    }
  }

  function selectSatker(value) {
    document.getElementById('satker_search').value = value;
    document.getElementById('satker').value = value;
    document.getElementById('satker_options').classList.remove('show-options');
    // Auto submit form when selecting a Satker
    submitForm();
  }

  function clearSatkerSelection() {
    document.getElementById('satker_search').value = '';
    document.getElementById('satker').value = '';
    // Auto submit form when clearing Satker selection
    submitForm();
  }

  function submitForm() {
    document.getElementById('filter-form').submit();
  }

  // Close dropdown when clicking outside
  document.addEventListener('click', function(event) {
    const options = document.getElementById('satker_options');
    const input = document.getElementById('satker_search');
    if (!input.contains(event.target)) {
      options.classList.remove('show-options');
    }
  });

  // Show options when clicking on the input
  document.getElementById('satker_search').addEventListener('click', function() {
    document.getElementById('satker_options').classList.add('show-options');
  });
</script>
@endpush