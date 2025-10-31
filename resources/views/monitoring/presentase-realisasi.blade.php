@extends('layouts.adminlte')

@push('style')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        --primary: #1d4ed8;
        --primary-dark: #1e3a8a;
        --secondary: #f1f5f9;
        --accent: #fef9c3;
        --text: #334155;
        --light-text: #64748b;
        --border: #e2e8f0;
        --white: #ffffff;
        --shadow: rgba(0, 0, 0, 0.06);
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f9fafb;
        color: var(--text);
        line-height: 1.6;
        -webkit-tap-highlight-color: transparent;
    }

    .container {
        padding: 16px;
        max-width: 1400px;
        margin: 0 auto;
    }

    h1 {
        color: var(--primary);
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    /* Filter Grid */
    .filter-grid {
        display: grid;
        grid-template-columns: 1fr 2fr auto; /* Tahun | Satker | Tombol */
        gap: 16px;
        align-items: end;
        margin-bottom: 16px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        font-weight: 600;
        margin-bottom: 6px;
        font-size: 14px;
    }

    .form-group .form-control,
    .form-group select {
        width: 100%;
        min-width: 180px;
        padding: 10px 12px;
        font-size: 15px;
        border: 1px solid var(--border);
        border-radius: 6px;
        background-color: var(--white);
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 18px;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        height: 100%;
    }

    .export-btn {
        padding: 10px 16px;
        background-color: var(--primary);
        color: var(--white);
        border-radius: 6px;
        text-decoration: none;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: transform 0.1s ease;
        white-space: nowrap;
    }

    .export-btn:active {
        transform: scale(0.98);
    }

    /* Table */
    .table-wrapper {
        overflow-x: auto;
        background-color: var(--white);
        border-radius: 10px;
        box-shadow: 0 4px 12px var(--shadow);
        margin-bottom: 20px;
        width: 100%;
        -webkit-overflow-scrolling: touch;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
        min-width: 280px;
    }

    thead th {
        background-color: var(--secondary);
        padding: 12px;
        border: 1px solid var(--border);
        font-weight: bold;
        text-align: center;
        position: sticky;
        top: 0;
    }

    tbody td {
        padding: 10px;
        border: 1px solid var(--border);
        white-space: nowrap;
    }

    .text-left { text-align: left; }
    .text-right { text-align: right; }
    .text-center { text-align: center; }

    tbody tr:hover {
        background-color: #f8fafc;
    }

    .total-row {
        background-color: var(--accent);
        font-weight: bold;
    }

    .no-data {
        text-align: center;
        font-style: italic;
        color: var(--light-text);
        padding: 20px;
    }

    /* Mobile Card View */
    .card-view {
        display: none;
        flex-direction: column;
        gap: 12px;
    }

    @media (max-width: 320px) {
        .table-wrapper {
            display: none;
        }

        .card-view {
            display: flex;
        }

        .table-wrapper.active {
            display: block;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1000;
            background: white;
            overflow: scroll;
            padding: 16px;
        }
    }

    .card {
        background-color: var(--white);
        border-radius: 8px;
        box-shadow: 0 2px 8px var(--shadow);
        padding: 16px;
        border-left: 4px solid var(--primary);
        transition: transform 0.1s ease;
    }

    .card:active {
        transform: scale(0.98);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
        padding-bottom: 8px;
        border-bottom: 1px solid var(--border);
    }

    .card-number {
        background-color: var(--secondary);
        border-radius: 12px;
        padding: 4px 10px;
        font-size: 12px;
        font-weight: 500;
    }

    .card-title {
        font-weight: 600;
        font-size: 16px;
        color: var(--primary);
    }

    .card-section {
        margin-bottom: 12px;
    }

    .section-title {
        font-weight: 500;
        font-size: 14px;
        color: var(--light-text);
        margin-bottom: 6px;
    }

    .section-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
    }

    .data-item {
        background-color: #f8fafc;
        border-radius: 6px;
        padding: 10px;
    }

    .data-label {
        font-size: 12px;
        color: var(--light-text);
    }

    .data-value {
        font-weight: 600;
        font-size: 14px;
    }

    .total-card {
        background-color: var(--accent);
        border-left-color: #f59e0b;
    }
    /* Atur layout form filter grid */
.filter-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 1rem;
  align-items: end;
}

/* Atur tampilan untuk form-actions agar tidak lepas dari grid */
.form-actions {
  display: flex;
  align-items: center;
  justify-content: flex-start;
}

/* Responsive untuk layar kecil */
@media (max-width: 768px) {
  .filter-grid {
    grid-template-columns: 1fr;
  }

  .form-actions {
    justify-content: center;
  }

  .export-btn {
    width: 100%;
    text-align: center;
  }
}

</style>

@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Generate mobile cards from table data
    function generateMobileCards() {
        // Only generate cards if we're in mobile view
        if (window.innerWidth > 320) {
            document.querySelector('.card-view').style.display = 'none';
            document.querySelector('.table-wrapper').style.display = 'block';
            return;
        }
        
        const cardContainer = document.querySelector('.card-view');
        const table = document.querySelector('table tbody');
        
        if (!table || !cardContainer) return;
        
        cardContainer.innerHTML = '';
        
        const rows = table.querySelectorAll('tr:not(.total-row)');
        const totalRow = table.querySelector('tr.total-row');
        
        if (rows.length === 0) {
            cardContainer.innerHTML = `
                <div class="card no-data">
                    Tidak ada data yang tersedia untuk tahun atau satker yang dipilih.
                </div>
            `;
            return;
        }
        
        // Create cards for each row
        rows.forEach((row, index) => {
            const cells = row.querySelectorAll('td');
            const card = document.createElement('div');
            card.className = 'card';
            
            card.innerHTML = `
                <div class="card-header">
                    <div class="card-title">${cells[1].textContent}</div>
                    <div class="card-number">${cells[0].textContent}</div>
                </div>
                
                <div class="card-section">
                    <div class="section-title">Pengadaan</div>
                    <div class="section-content">
                        <div class="data-item">
                            <div class="data-label">Anggaran</div>
                            <div class="data-value">${cells[2].textContent}</div>
                        </div>
                        <div class="data-item">
                            <div class="data-label">Realisasi</div>
                            <div class="data-value">${cells[3].textContent}</div>
                        </div>
                    </div>
                </div>
                
                <div class="card-section">
                    <div class="data-item" style="grid-column: span 2;">
                        <div class="data-label">Presentase Realisasi</div>
                        <div class="data-value"><strong>${cells[4].innerText}</strong></div>
                    </div>
                </div>
            `;
            
            cardContainer.appendChild(card);
        });
        
        // Add total card if exists
        if (totalRow) {
            const totalCells = totalRow.querySelectorAll('td');
            const totalCard = document.createElement('div');
            totalCard.className = 'card total-card';
            
            totalCard.innerHTML = `
                <div class="card-header">
                    <div class="card-title">TOTAL KESELURUHAN</div>
                </div>
                
                <div class="card-section">
                    <div class="section-content">
                        <div class="data-item">
                            <div class="data-label">Total Anggaran</div>
                            <div class="data-value">${totalCells[2].textContent}</div>
                        </div>
                        <div class="data-item">
                            <div class="data-label">Total Realisasi</div>
                            <div class="data-value">${totalCells[3].textContent}</div>
                        </div>
                    </div>
                </div>
                
                <div class="card-section">
                    <div class="data-item" style="grid-column: span 2;">
                        <div class="data-label">Rata-rata Presentase</div>
                        <div class="data-value"><strong>${totalCells[4].innerText}</strong></div>
                    </div>
                </div>
            `;
            
            cardContainer.appendChild(totalCard);
        }
    }
    
    // Generate cards on load and window resize
    generateMobileCards();
    window.addEventListener('resize', generateMobileCards);
    
    // Toggle table view on mobile
    const tableWrapper = document.querySelector('.table-wrapper');
    if (tableWrapper) {
        tableWrapper.addEventListener('click', function() {
            if (window.innerWidth <= 320) {
                this.classList.toggle('active');
            }
        });
    }
});
</script>
@endpush

@section('content')
<div class="container">
    <h1>Presentase Realisasi Pengadaan terhadap RUP</h1>

    <form method="GET" id="filter-form">
  <div class="filter-grid">
    <div class="form-group">
      <label for="tahun">Pilih Tahun:</label>
      <select name="tahun" id="tahun" class="form-control" onchange="document.getElementById('filter-form').submit()">
        <option value="">-- Pilih Tahun --</option>
        @foreach([2024, 2025] as $th)
          <option value="{{ $th }}" {{ request('tahun') == $th ? 'selected' : '' }}>{{ $th }}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="satker">Nama Satker:</label>
      <select name="satker" id="satker" class="form-control" onchange="document.getElementById('filter-form').submit()">
        <option value="">-- Semua Satker --</option>
        @foreach($listSatker as $satker)
          <option value="{{ $satker }}" {{ request('satker') == $satker ? 'selected' : '' }}>{{ $satker }}</option>
        @endforeach
      </select>
    </div>

    <div class="form-actions">
      <a href="{{ route('monitoring.realisasi.pdf', ['tahun' => request('tahun'), 'satker' => request('satker')]) }}"
         target="_blank"
         class="export-btn">
        📄 Export PDF
      </a>
    </div>
  </div>
</form>



    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th rowspan="2">No</th>
                    <th colspan="4" style="background-color: #fef08a;">PENGADAAN</th>
                </tr>
                <tr>
                    <th>Nama Satker</th>
                    <th>Anggaran Belanja Pengadaan</th>
                    <th>Total Realisasi Pengadaan <br><span style="font-size: 11px;">(Tender, Non-Tender, E-Katalog, Toko Daring)</span></th>
                    <th>Presentase Realisasi Pengadaan <br><span style="font-size: 11px;">(D / C × 100%)</span></th>
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
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-left">{{ $item->nama_satker }}</td>
                        <td class="text-right">{{ number_format($item->belanja_pengadaan, 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($item->total_transaksi, 0, ',', '.') }}</td>
                        <td class="text-right"><strong>{{ number_format($item->presentase_realisasi, 2, ',', '.') }}%</strong></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="no-data">Tidak ada data yang tersedia untuk tahun atau satker yang dipilih.</td>
                    </tr>
                @endforelse

                @if($jumlahData > 0)
                    <tr class="total-row">
                        <td colspan="2" class="text-left">TOTAL</td>
                        <td class="text-right">{{ number_format($totalBelanja, 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($totalTransaksi, 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($totalPersen / $jumlahData, 2, ',', '.') }}%</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="card-view"></div>
</div>
@endsection