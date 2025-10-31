@extends('layouts.adminlte')

@push('style')
<style>
  /* === Layout & Typography === */
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f9fafb;
  }

  .container {
    max-width: 100%;
    padding: 20px;
    margin: auto;
  }

  h1 {
    color: #1d4ed8;
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
  }

  /* === Filter Form === */
  form {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    align-items: center;
    margin-bottom: 20px;
  }

  label {
    font-weight: 600;
    font-size: 14px;
    margin-right: 8px;
  }

  select {
    width: 180px;
    padding: 8px 12px;
    font-size: 14px;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    background-color: #ffffff;
    cursor: pointer;
  }

  .export-btn {
    margin-left: auto;
    padding: 8px 16px;
    font-size: 14px;
    background-color: #1d4ed8;
    color: white;
    border-radius: 6px;
    text-decoration: none;
    transition: background 0.2s;
    white-space: nowrap;
  }

  .export-btn:hover {
    background-color: #1e3a8a;
  }

  /* === Table Section === */
  .table-responsive {
    width: 100%;
    overflow-x: auto;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
  }

  table {
    width: 100%;
    min-width: 1100px;
    border-collapse: collapse;
    font-size: 13px;
    color: #334155;
  }

  thead th {
    position: sticky;
    top: 0;
    z-index: 2;
    padding: 10px 8px;
    background-color: #e2e8f0;
    border: 1px solid #cbd5e1;
    font-weight: bold;
    text-align: center;
    font-size: 13px;
  }

  thead tr:first-child th {
    background-color: #f1f5f9;
  }

  thead .bg-green { background-color: #bbf7d0; }
  thead .bg-yellow { background-color: #fef9c3; }
  thead .bg-blue { background-color: #bfdbfe; }
  thead .bg-red { background-color: #fecaca; color: #991b1b; }
  thead .bg-orange { background-color: #fed7aa; }

  tbody td {
    padding: 8px;
    border: 1px solid #e2e8f0;
    text-align: center;
    vertical-align: middle;
    font-size: 13px;
  }

  tbody td.text-left {
    text-align: left;
    max-width: 250px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  tbody td.text-right {
    text-align: right;
    min-width: 100px;
  }

  tbody tr:hover {
    background-color: #f8fafc;
  }

  .total-row {
    background-color: #fef9c3;
    font-weight: bold;
  }

  .no-data {
    text-align: center;
    font-style: italic;
    color: #64748b;
    padding: 20px;
  }

  /* === Responsive === */
  @media (max-width: 768px) {
    .container {
      padding: 15px;
    }

    h1 {
      font-size: 20px;
    }

    form {
      flex-direction: column;
      align-items: flex-start;
      gap: 10px;
    }

    select, .export-btn {
      width: 100%;
    }

    .export-btn {
      margin-left: 0;
      text-align: center;
    }
  }

  @media (max-width: 576px) {
    .container {
      padding: 10px;
    }

    h1 {
      font-size: 18px;
      margin-bottom: 15px;
    }

    label, select, .export-btn {
      font-size: 13px;
      padding: 6px 10px;
    }
  }
  .filter-grid {
  display: flex;
  flex-wrap: wrap;
  align-items: flex-end;
  gap: 12px;
}

.filter-group {
  display: flex;
  flex-direction: column;
}

@media (max-width: 768px) {
  .filter-grid {
    flex-direction: column;
    align-items: stretch;
  }

  .action-buttons {
    width: 100%;
  }

  .export-btn {
    width: 100%;
    text-align: center;
  }
}
.filter-grid {
  display: flex;
  flex-wrap: wrap;
  align-items: flex-end; /* pastikan semua elemen sejajar di bawah */
  gap: 12px;
}

.filter-group,
.action-buttons {
  flex: 1 1 0;
  min-width: 200px;
}

.action-buttons {
  display: flex;
  justify-content: flex-end;
  height: 40px; /* samakan tinggi dengan form-control */
}

.export-btn {
  height: 40px;
  line-height: 40px;
  padding: 0 16px;
  display: inline-block;
  text-align: center;
  white-space: nowrap;
}

@media (max-width: 768px) {
  .filter-grid {
    flex-direction: column;
    align-items: stretch;
  }

  .action-buttons {
    width: 100%;
    justify-content: stretch;
  }

  .export-btn {
    width: 100%;
  }
}

</style>
@endpush

@section('content')
<div class="container">
  <h1>Rekapitulasi Realisasi Pengadaan</h1>

  <!-- Filter Tahun & Satker -->
  <div class="filter-container">
    <form method="GET" id="filter-form">
      <div class="filter-grid">
        <div class="filter-group">
          <label for="tahun">Tahun</label>
          <select name="tahun" id="tahun" class="form-control" onchange="document.getElementById('filter-form').submit()">
            @foreach([2024, 2025] as $th)
              <option value="{{ $th }}" {{ $tahun == $th ? 'selected' : '' }}>{{ $th }}</option>
            @endforeach
          </select>
        </div>

        <div class="filter-group">
          <label for="satker">Nama Satker</label>
          <select name="satker" id="satker" class="form-control" onchange="document.getElementById('filter-form').submit()">
            <option value="">-- Semua Satker --</option>
            @foreach($listSatker as $satker)
              <option value="{{ $satker }}" {{ request('satker') == $satker ? 'selected' : '' }}>{{ $satker }}</option>
            @endforeach
          </select>
        </div>

        <div class="action-buttons" style="align-self: end;">
          <a class="export-btn"
             href="{{ route('monitoring.rekap.realisasi.pdf', ['tahun' => $tahun]) }}"
             target="_blank">
            📄 Export PDF
          </a>
        </div>
      </div>
    </form>
  </div>

  <!-- Tabel -->
  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th rowspan="2" style="width: 40px;">No</th>
          <th rowspan="2" style="min-width: 200px;">Nama Satker</th>
          <th colspan="2" class="bg-green">Tender</th>
          <th colspan="2" class="bg-yellow">Non-Tender</th>
          <th colspan="2" class="bg-blue">E-Katalog</th>
          <th colspan="2" class="bg-red">Swakelola</th>
          <th colspan="2" class="bg-orange">Toko Daring</th>
        </tr>
        <tr>
          <th>Paket</th>
          <th>Nilai</th>
          <th>Paket</th>
          <th>Nilai</th>
          <th>Paket</th>
          <th>Nilai</th>
          <th>Paket</th>
          <th>Nilai</th>
          <th>Paket</th>
          <th>Nilai</th>
        </tr>
      </thead>
      <tbody>
        @php
          $total = [
            'tender_paket' => 0, 'tender_nilai' => 0,
            'nontender_paket' => 0, 'nontender_nilai' => 0,
            'ekatalog_paket' => 0, 'ekatalog_nilai' => 0,
            'swakelola_paket' => 0, 'swakelola_nilai' => 0,
            'tokodaring_paket' => 0, 'tokodaring_nilai' => 0,
          ];
        @endphp

        @forelse ($data as $i => $row)
          @php
            $total['tender_paket'] += $row['total_paket_tender'];
            $total['tender_nilai'] += $row['total_nilai_tender'];
            $total['nontender_paket'] += $row['total_paket_nontender'];
            $total['nontender_nilai'] += $row['total_nilai_nontender'];
            $total['ekatalog_paket'] += $row['total_paket_ekatalog'];
            $total['ekatalog_nilai'] += $row['total_nilai_ekatalog'];
            $total['swakelola_paket'] += $row['total_paket_swakelola'];
            $total['swakelola_nilai'] += $row['total_nilai_swakelola'];
            $total['tokodaring_paket'] += $row['total_paket_tokodaring'];
            $total['tokodaring_nilai'] += $row['total_nilai_tokodaring'];
          @endphp
          <tr>
            <td>{{ $i + 1 }}</td>
            <td class="text-left">{{ $row['nama_satker'] }}</td>
            <td>{{ $row['total_paket_tender'] }}</td>
            <td class="text-right">{{ number_format($row['total_nilai_tender'], 0, ',', '.') }}</td>
            <td>{{ $row['total_paket_nontender'] }}</td>
            <td class="text-right">{{ number_format($row['total_nilai_nontender'], 0, ',', '.') }}</td>
            <td>{{ $row['total_paket_ekatalog'] }}</td>
            <td class="text-right">{{ number_format($row['total_nilai_ekatalog'], 0, ',', '.') }}</td>
            <td>{{ $row['total_paket_swakelola'] }}</td>
            <td class="text-right">{{ number_format($row['total_nilai_swakelola'], 0, ',', '.') }}</td>
            <td>{{ $row['total_paket_tokodaring'] }}</td>
            <td class="text-right">{{ number_format($row['total_nilai_tokodaring'], 0, ',', '.') }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="13" class="no-data">Tidak ada data tersedia untuk tahun {{ request('tahun') }}.</td>
          </tr>
        @endforelse

        @if(count($data) > 0)
          <tr class="total-row">
            <td colspan="2">TOTAL</td>
            <td>{{ $total['tender_paket'] }}</td>
            <td class="text-right">{{ number_format($total['tender_nilai'], 0, ',', '.') }}</td>
            <td>{{ $total['nontender_paket'] }}</td>
            <td class="text-right">{{ number_format($total['nontender_nilai'], 0, ',', '.') }}</td>
            <td>{{ $total['ekatalog_paket'] }}</td>
            <td class="text-right">{{ number_format($total['ekatalog_nilai'], 0, ',', '.') }}</td>
            <td>{{ $total['swakelola_paket'] }}</td>
            <td class="text-right">{{ number_format($total['swakelola_nilai'], 0, ',', '.') }}</td>
            <td>{{ $total['tokodaring_paket'] }}</td>
            <td class="text-right">{{ number_format($total['tokodaring_nilai'], 0, ',', '.') }}</td>
          </tr>
        @endif
      </tbody>
    </table>
  </div>
</div>
@endsection
