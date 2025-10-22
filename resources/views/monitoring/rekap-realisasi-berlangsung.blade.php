@extends('layouts.adminlte')

@push('style')
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f9fafb;
        -webkit-tap-highlight-color: transparent;
    }

    .container {
        padding: 12px;
        max-width: 1400px;
        margin: auto;
    }

    h1 {
        color: #1d4ed8;
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 16px;
        padding: 0 8px;
    }

    /* Enhanced Touch Form */
    .filter-form {
        display: grid;
        grid-template-columns: 1fr;
        gap: 12px;
        margin-bottom: 16px;
        background-color: #ffffff;
        padding: 16px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }

    .filter-group {
        display: flex;
        flex-direction: column;
    }

    label {
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 15px;
    }

    select {
        padding: 12px 14px;
        font-size: 16px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        background-color: #ffffff;
        cursor: pointer;
        width: 100%;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 18px;
    }

    /* Enhanced Touch Button */
    .export-btn {
        padding: 14px 16px;
        background-color: #1d4ed8;
        color: white;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.2s;
        text-align: center;
        font-size: 16px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: none;
        cursor: pointer;
        touch-action: manipulation;
    }

    .export-btn:active {
        transform: scale(0.98);
        background-color: #1e3a8a;
    }

    /* Table Styles */
    .table-wrapper {
        display: block;
        margin-bottom: 16px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: #ffffff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }

    th, td {
        padding: 12px 15px;
        text-align: center;
        border-bottom: 1px solid #e2e8f0;
    }

    th {
        background-color: #f1f5f9;
        font-weight: 600;
        color: #1e3a8a;
    }

    tr:last-child td {
        border-bottom: none;
    }

    .text-left {
        text-align: left;
    }

    .text-right {
        text-align: right;
    }

    /* Mobile Card View */
    .card-view {
        display: none;
        flex-direction: column;
        gap: 12px;
        padding: 8px;
    }

    .card {
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        padding: 16px;
        border-left: 5px solid #1d4ed8;
        transition: transform 0.1s ease;
        touch-action: manipulation;
        min-width: 280px;
        overflow: hidden;
    }

    .card:active {
        transform: scale(0.99);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e2e8f0;
    }

    .card-title {
        font-weight: bold;
        color: #1d4ed8;
        font-size: 17px;
        flex: 1;
        padding-right: 10px;
    }

    .card-number {
        background-color: #e2e8f0;
        border-radius: 14px;
        padding: 4px 10px;
        font-size: 14px;
        font-weight: 600;
        min-width: 28px;
        text-align: center;
    }

    .card-section {
        margin-bottom: 14px;
    }

    .section-title {
        font-weight: 600;
        font-size: 15px;
        color: #64748b;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 6px 0;
    }

    .section-title i {
        font-size: 18px;
    }

    .section-content {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 10px;
    }

    .data-item {
        background-color: #f8fafc;
        border-radius: 8px;
        padding: 12px;
        transition: transform 0.1s ease;
    }

    .data-item:active {
        transform: scale(0.98);
    }

    .data-label {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 6px;
    }

    .data-value {
        font-weight: 600;
        font-size: 15px;
    }

    .data-value.amount {
        color: #1d4ed8;
    }

    /* Scroll indicator for tables on mobile */
    .table-wrapper {
        position: relative;
    }

    .table-wrapper::after {
        content: '↔ Scroll untuk melihat lebih banyak';
        position: absolute;
        bottom: 5px;
        right: 5px;
        font-size: 12px;
        color: #64748b;
        background: rgba(255,255,255,0.9);
        padding: 2px 5px;
        border-radius: 4px;
        pointer-events: none;
        display: none;
    }

    /* Responsive Adjustments */
    @media (min-width: 200px) {
        .filter-form {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .container {
            padding: 16px;
        }
    }

    @media (min-width: 200px) {
        .filter-form {
            grid-template-columns: auto auto 1fr;
            align-items: center;
        }
        
        .card-view {
            display: none !important;
        }
        
        .table-wrapper {
            display: block !important;
        }
    }

    @media (max-width: 899px) {
        .table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        table {
            min-width: 600px;
        }
        
        .card-view {
            display: flex;
            margin-top: 16px;
        }
        
        .table-wrapper::after {
            display: block;
        }
    }

    @media (max-width: 599px) {
        .table-wrapper {
            display: none;
        }
        
        .card-view {
            display: flex;
        }
    }

    /* Very small screens (200px and below) */
    @media (max-width: 200px) {
        .container {
            padding: 6px;
        }
        
        h1 {
            font-size: 18px;
            margin-bottom: 12px;
            padding: 0 4px;
        }
        
        .filter-form {
            grid-template-columns: 1fr;
            padding: 8px;
            gap: 8px;
        }
        
        label {
            font-size: 13px;
            margin-bottom: 6px;
        }
        
        select, .export-btn {
            padding: 8px 10px;
            font-size: 13px;
        }
        
        .export-btn {
            padding: 10px 12px;
            font-size: 14px;
        }
        
        /* Card adjustments */
        .card {
            min-width: 180px;
            padding: 12px;
        }
        
        .card-title {
            font-size: 15px;
        }
        
        .card-number {
            font-size: 12px;
            padding: 2px 6px;
            min-width: 20px;
        }
        
        .section-title {
            font-size: 13px;
        }
        
        .section-title i {
            font-size: 15px;
        }
        
        .section-content {
            grid-template-columns: 1fr;
        }
        
        .data-item {
            padding: 8px;
        }
        
        .data-label {
            font-size: 11px;
        }
        
        .data-value {
            font-size: 13px;
        }
        
        /* Hide some decorative elements */
        select {
            background-image: none;
            padding-right: 8px;
        }
        
        .table-wrapper::after {
            font-size: 10px;
            padding: 1px 3px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Generate mobile cards with touch enhancements
    function generateMobileCards() {
        const cardContainer = document.querySelector('.card-view');
        const table = document.querySelector('table tbody');
        
        if (!table || !cardContainer) return;
        
        cardContainer.innerHTML = '';
        
        const rows = table.querySelectorAll('tr:not(.total-row)');
        const totalRow = table.querySelector('tr.total-row');
        
        if (rows.length === 0) {
            cardContainer.innerHTML = `
                <div class="card">
                    <div class="no-data">Tidak ada data tersedia untuk tahun {{ $tahun }}.</div>
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
                    <div class="section-title">
                        <i class="fas fa-gavel" style="color: #10b981;"></i>
                        Tender
                    </div>
                    <div class="section-content">
                        <div class="data-item">
                            <div class="data-label">Total Paket</div>
                            <div class="data-value">${cells[2].textContent}</div>
                        </div>
                        <div class="data-item">
                            <div class="data-label">Total Pagu</div>
                            <div class="data-value amount">${cells[3].textContent}</div>
                        </div>
                    </div>
                </div>
                
                <div class="card-section">
                    <div class="section-title">
                        <i class="fas fa-handshake" style="color: #f59e0b;"></i>
                        Non-Tender
                    </div>
                    <div class="section-content">
                        <div class="data-item">
                            <div class="data-label">Total Paket</div>
                            <div class="data-value">${cells[4].textContent}</div>
                        </div>
                        <div class="data-item">
                            <div class="data-label">Total Pagu</div>
                            <div class="data-value amount">${cells[5].textContent}</div>
                        </div>
                    </div>
                </div>
                
                <div class="card-section">
                    <div class="section-title">
                        <i class="fas fa-shopping-cart" style="color: #3b82f6;"></i>
                        E-Katalog
                    </div>
                    <div class="section-content">
                        <div class="data-item">
                            <div class="data-label">Total Paket</div>
                            <div class="data-value">${cells[6].textContent}</div>
                        </div>
                        <div class="data-item">
                            <div class="data-label">Total Nilai</div>
                            <div class="data-value amount">${cells[7].textContent}</div>
                        </div>
                    </div>
                </div>
                
                <div class="card-section">
                    <div class="section-title">
                        <i class="fas fa-store" style="color: #f97316;"></i>
                        Toko Daring
                    </div>
                    <div class="section-content">
                        <div class="data-item">
                            <div class="data-label">Total Paket</div>
                            <div class="data-value">${cells[8].textContent}</div>
                        </div>
                        <div class="data-item">
                            <div class="data-label">Total Nilai</div>
                            <div class="data-value amount">${cells[9].textContent}</div>
                        </div>
                    </div>
                </div>
            `;
            cardContainer.appendChild(card);
        });
        
        // Add total card if exists
        if (totalRow) {
            const totalCells = totalRow.querySelectorAll('td');
            const totalCard = document.createElement('div');
            totalCard.className = 'card';
            totalCard.style.borderLeftColor = '#f59e0b';
            totalCard.style.backgroundColor = '#fef9c3';
            totalCard.innerHTML = `
                <div class="card-header">
                    <div class="card-title">TOTAL KESELURUHAN</div>
                </div>
                
                <div class="card-section">
                    <div class="section-title">
                        <i class="fas fa-gavel" style="color: #10b981;"></i>
                        Tender
                    </div>
                    <div class="section-content">
                        <div class="data-item">
                            <div class="data-label">Total Paket</div>
                            <div class="data-value">${totalCells[2].textContent}</div>
                        </div>
                        <div class="data-item">
                            <div class="data-label">Total Pagu</div>
                            <div class="data-value amount">${totalCells[3].textContent}</div>
                        </div>
                    </div>
                </div>
                
                <div class="card-section">
                    <div class="section-title">
                        <i class="fas fa-handshake" style="color: #f59e0b;"></i>
                        Non-Tender
                    </div>
                    <div class="section-content">
                        <div class="data-item">
                            <div class="data-label">Total Paket</div>
                            <div class="data-value">${totalCells[4].textContent}</div>
                        </div>
                        <div class="data-item">
                            <div class="data-label">Total Pagu</div>
                            <div class="data-value amount">${totalCells[5].textContent}</div>
                        </div>
                    </div>
                </div>
                
                <div class="card-section">
                    <div class="section-title">
                        <i class="fas fa-shopping-cart" style="color: #3b82f6;"></i>
                        E-Katalog
                    </div>
                    <div class="section-content">
                        <div class="data-item">
                            <div class="data-label">Total Paket</div>
                            <div class="data-value">${totalCells[6].textContent}</div>
                        </div>
                        <div class="data-item">
                            <div class="data-label">Total Nilai</div>
                            <div class="data-value amount">${totalCells[7].textContent}</div>
                        </div>
                    </div>
                </div>
                
                <div class="card-section">
                    <div class="section-title">
                        <i class="fas fa-store" style="color: #f97316;"></i>
                        Toko Daring
                    </div>
                    <div class="section-content">
                        <div class="data-item">
                            <div class="data-label">Total Paket</div>
                            <div class="data-value">${totalCells[8].textContent}</div>
                        </div>
                        <div class="data-item">
                            <div class="data-label">Total Nilai</div>
                            <div class="data-value amount">${totalCells[9].textContent}</div>
                        </div>
                    </div>
                </div>
            `;
            cardContainer.appendChild(totalCard);
        }
    }
    
    // Generate cards on load and window resize
    generateMobileCards();
    window.addEventListener('resize', generateMobileCards);
    
    // Add touch feedback to all interactive elements
    document.querySelectorAll('select, .export-btn, .card, .data-item').forEach(el => {
        el.style.transition = 'transform 0.1s ease';
        el.addEventListener('touchstart', function() {
            this.style.transform = 'scale(0.98)';
        });
        el.addEventListener('touchend', function() {
            this.style.transform = '';
        });
    });
});
</script>
@endpush

@section('content')
<div class="container">
    <h1>Rekapitulasi Realisasi Pengadaan Berlangsung</h1>

    <!-- Enhanced Touch Form -->
    <form method="GET" id="filter-form" class="filter-form">
        <div class="filter-group">
            <label for="tahun">Tahun:</label>
            <select name="tahun" id="tahun" onchange="document.getElementById('filter-form').submit()">
                @foreach([2024, 2025] as $th)
                    <option value="{{ $th }}" {{ $tahun == $th ? 'selected' : '' }}>{{ $th }}</option>
                @endforeach
            </select>
        </div>

        <div class="filter-group">
            <label for="satker">Nama Satker:</label>
            <select name="satker" id="satker" onchange="document.getElementById('filter-form').submit()">
                <option value="">-- Semua Satker --</option>
                @foreach($listSatker as $satker)
                    <option value="{{ $satker }}" {{ request('satker') == $satker ? 'selected' : '' }}>{{ $satker }}</option>
                @endforeach
            </select>
        </div>

        <a href="{{ route('monitoring.rekap.realisasi-berlangsung.pdf', ['tahun' => $tahun]) }}"
           target="_blank"
           class="export-btn">
            <i class="fas fa-file-pdf"></i> Export PDF
        </a>
    </form>

    <!-- Desktop Table View -->
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Nama Satker</th>
                    <th colspan="2" style="background-color: #bbf7d0;">Tender</th>
                    <th colspan="2" style="background-color: #fef9c3;">Non-Tender</th>
                    <th colspan="2" style="background-color: #bfdbfe;">E-Katalog</th>
                    <th colspan="2" style="background-color: #fed7aa;">Toko Daring</th>
                </tr>
                <tr>
                    <th>Total Paket</th>
                    <th>Total Pagu</th>
                    <th>Total Paket</th>
                    <th>Total Pagu</th>
                    <th>Total Paket</th>
                    <th>Total Nilai</th>
                    <th>Total Paket</th>
                    <th>Total Nilai</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = [
                        'tender_paket' => 0, 'tender_nilai' => 0,
                        'nontender_paket' => 0, 'nontender_nilai' => 0,
                        'ekatalog_paket' => 0, 'ekatalog_nilai' => 0,
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
                        <td>{{ $row['total_paket_tokodaring'] }}</td>
                        <td class="text-right">{{ number_format($row['total_nilai_tokodaring'], 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" style="text-align: center; font-style: italic; color: #64748b; padding: 20px;">
                            Tidak ada data tersedia untuk tahun {{ $tahun }}.
                        </td>
                    </tr>
                @endforelse

                @if(count($data) > 0)
                    <tr class="total-row" style="background-color: #fef9c3; font-weight: bold;">
                        <td colspan="2" class="text-left">TOTAL</td>
                        <td>{{ $total['tender_paket'] }}</td>
                        <td class="text-right">{{ number_format($total['tender_nilai'], 0, ',', '.') }}</td>
                        <td>{{ $total['nontender_paket'] }}</td>
                        <td class="text-right">{{ number_format($total['nontender_nilai'], 0, ',', '.') }}</td>
                        <td>{{ $total['ekatalog_paket'] }}</td>
                        <td class="text-right">{{ number_format($total['ekatalog_nilai'], 0, ',', '.') }}</td>
                        <td>{{ $total['tokodaring_paket'] }}</td>
                        <td class="text-right">{{ number_format($total['tokodaring_nilai'], 0, ',', '.') }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Mobile Card View -->
    <div class="card-view"></div>
</div>
@endsection