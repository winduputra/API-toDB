@extends('layouts.adminlte')

@push('style')
<style>
    /* Base Styles */
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        -webkit-tap-highlight-color: transparent; /* Remove tap highlight */
    }

    .container {
        padding: 16px;
        max-width: 1400px;
        margin: 0 auto;
    }

    h1 {
        color: #1d4ed8;
        font-size: 24px;
        margin-bottom: 20px;
    }

    /* Responsive Filter Form */
    .filter-form {
        display: grid;
        grid-template-columns: 1fr;
        gap: 12px;
        margin-bottom: 20px;
        padding: 16px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    @media (min-width: 600px) {
        .filter-form {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (min-width: 200px) {
        .filter-form {
            grid-template-columns: auto auto;
            align-items: center;
        }
    }

    .filter-form select {
        padding: 12px 14px; /* Larger touch target */
        font-size: 16px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        background-color: #ffffff;
        width: 100%;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 18px;
    }

    /* Table Styles */
    .table-wrapper {
        overflow-x: auto;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
        min-width: 600px;
    }

    th, td {
        border: 1px solid #e2e8f0;
        padding: 12px;
        text-align: center;
    }

    th {
        background-color: #f1f5f9;
        font-weight: bold;
        position: sticky;
        top: 0;
    }

    .bg-blue { background-color: #bfdbfe; }
    .bg-yellow { background-color: #fef9c3; }
    .bg-green { background-color: #86efac; }
    .bg-gray { background-color: #e2e8f0; }

    .text-left { text-align: left; }
    .text-right { text-align: right; }

    tbody tr:hover {
        background-color: #f8fafc;
    }

    /* Mobile Card View */
    .card-view {
        display: none;
        flex-direction: column;
        gap: 12px;
    }

    .card {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        padding: 16px;
        border-left: 4px solid #1d4ed8;
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
        border-bottom: 1px solid #e2e8f0;
    }

    .card-title {
        font-weight: bold;
        color: #1d4ed8;
        font-size: 16px;
        flex: 1;
    }

    .card-number {
        background-color: #e2e8f0;
        border-radius: 12px;
        padding: 2px 8px;
        font-size: 12px;
    }

    .card-section {
        margin-bottom: 12px;
    }

    .section-title {
        font-weight: 600;
        font-size: 14px;
        color: #64748b;
        margin-bottom: 8px;
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
        color: #64748b;
        margin-bottom: 4px;
    }

    .data-value {
        font-weight: 600;
        font-size: 14px;
    }

    .data-value.amount {
        color: #1d4ed8;
    }

    .total-card {
        background-color: #f9fafb;
        border-left-color: #64748b;
    }

    /* Responsive Behavior */
    @media (max-width: 200px) {
        .table-wrapper {
            display: none;
        }
        
        .card-view {
            display: flex;
        }
    }
        
        .card-view {
            display: flex;
        }
    }

    /* Touch Enhancements */
    a, button, select, .card {
        -webkit-tap-highlight-color: transparent;
        touch-action: manipulation;
    }

    a:active, .card:active {
        opacity: 0.9;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Generate mobile cards from table data
    function generateMobileCards() {
        const cardContainer = document.querySelector('.card-view');
        const table = document.querySelector('table tbody');
        
        if (!table || !cardContainer) return;
        
        cardContainer.innerHTML = '';
        
        const rows = table.querySelectorAll('tr:not(:last-child)');
        const totalRow = table.querySelector('tr:last-child');
        
        if (rows.length === 0) {
            cardContainer.innerHTML = `
                <div class="card">
                    <div style="text-align: center; font-style: italic; padding: 16px;">
                        Tidak ada data.
                    </div>
                </div>
            `;
            return;
        }
        
        // Create cards for each row
        rows.forEach((row, index) => {
            const cells = row.querySelectorAll('td');
            if (cells.length === 0) return;
            
            const card = document.createElement('div');
            card.className = 'card';
            
            card.innerHTML = `
                <div class="card-header">
                    <div class="card-title">${cells[1].textContent}</div>
                    <div class="card-number">${cells[0].textContent}</div>
                </div>
                
                <div class="card-section">
                    <div class="section-title">Non Tender Selesai</div>
                    <div class="section-content">
                        <div class="data-item">
                            <div class="data-value" style="color: #f59e0b;">${cells[2].textContent}</div>
                        </div>
                    </div>
                </div>
                
                <div class="card-section">
                    <div class="section-title">Nilai Pagu</div>
                    <div class="section-content">
                        <div class="data-item">
                            <div class="data-value amount">${cells[3].textContent}</div>
                        </div>
                    </div>
                </div>
                
                <div class="card-section">
                    <div class="section-title">Belum Input Kontrak</div>
                    <div class="section-content">
                        <div class="data-item">
                            <div class="data-value">${cells[4].textContent}</div>
                        </div>
                    </div>
                </div>
                
                <a href="${cells[1].querySelector('a')?.href || '#'}" 
                   style="display: block; margin-top: 12px; text-align: center; 
                          color: #1d4ed8; font-weight: 500; text-decoration: none;">
                    Lihat Detail →
                </a>
            `;
            
            cardContainer.appendChild(card);
        });
        
        // Add total card
        if (totalRow) {
            const totalCells = totalRow.querySelectorAll('td');
            const totalCard = document.createElement('div');
            totalCard.className = 'card total-card';
            
            totalCard.innerHTML = `
                <div class="card-header">
                    <div class="card-title">TOTAL KESELURUHAN</div>
                </div>
                
                <div class="card-section">
                    <div class="section-title">Non Tender Selesai</div>
                    <div class="section-content">
                        <div class="data-item">
                            <div class="data-value" style="color: #f59e0b;">${totalCells[2].textContent}</div>
                        </div>
                    </div>
                </div>
                
                <div class="card-section">
                    <div class="section-title">Nilai Pagu</div>
                    <div class="section-content">
                        <div class="data-item">
                            <div class="data-value amount">${totalCells[3].textContent}</div>
                        </div>
                    </div>
                </div>
                
                <div class="card-section">
                    <div class="section-title">Belum Input Kontrak</div>
                    <div class="section-content">
                        <div class="data-item">
                            <div class="data-value">${totalCells[4].textContent}</div>
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
    
    // Add touch feedback to interactive elements
    document.querySelectorAll('a, .card').forEach(el => {
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
    <h1>Monitoring Non Tender</h1>

    {{-- Filter Form --}}
    <form method="GET" class="filter-form">
        <div>
            <select name="tahun_anggaran" onchange="this.form.submit()">
                @foreach ($tahunList as $th)
                    <option value="{{ $th }}" {{ $th == $tahun ? 'selected' : '' }}>{{ $th }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <select name="nama_satker" onchange="this.form.submit()">
                <option value="">Semua Satker</option>
                @foreach ($satkerList as $satkerName)
                    <option value="{{ $satkerName }}" {{ request('nama_satker') == $satkerName ? 'selected' : '' }}>
                        {{ $satkerName }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    {{-- Desktop Table View --}}
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th class="bg-blue">Nama Satker</th>
                    <th class="bg-yellow">Total Non Tender Selesai</th>
                    <th class="bg-green">Total Nilai Pagu</th>
                    <th class="bg-gray">Kontrak yang Belum Input</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $i => $item)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td class="text-left">
                            <a href="{{ route('monitoring.kontrak.non_tender_detail', ['satker' => urlencode($item['nama_satker']), 'tahun_anggaran' => $tahun]) }}"
                               style="color: #1d4ed8;">
                                {{ $item['nama_satker'] }}
                            </a>
                        </td>
                        <td>{{ $item['total_non_tender_selesai'] }}</td>
                        <td class="text-right">{{ number_format($item['total_pagu'], 0, ',', '.') }}</td>
                        <td>{{ $item['kontrak_belum_input'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center" style="font-style: italic;">
                            Tidak ada data.
                        </td>
                    </tr>
                @endforelse

                {{-- Total row --}}
                <tr style="font-weight: bold; background-color: #f9fafb;">
                    <td colspan="2" class="text-right">Total</td>
                    <td>{{ $totals['total_non_tender_selesai'] }}</td>
                    <td class="text-right">{{ number_format($totals['total_pagu'], 0, ',', '.') }}</td>
                    <td>{{ $totals['kontrak_belum_input'] }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Mobile Card View --}}
    <div class="card-view"></div>
</div>
@endsection