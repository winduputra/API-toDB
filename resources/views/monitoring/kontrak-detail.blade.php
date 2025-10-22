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
        font-weight: bold;
        margin-bottom: 16px;
    }

    /* Responsive Filter Info */
    .satker-info {
        background-color: #ffffff;
        padding: 16px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        margin-bottom: 16px;
        font-size: 15px;
    }

    /* Export Button */
    .export-btn {
        display: inline-flex;
        align-items: center;
        padding: 12px 16px;
        background-color: #047857;
        color: white;
        border-radius: 8px;
        text-decoration: none;
        font-size: 15px;
        font-weight: 500;
        margin-bottom: 16px;
        transition: transform 0.1s ease;
    }

    .export-btn:active {
        transform: scale(0.98);
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
    }

    th {
        background-color: #f1f5f9;
        font-weight: bold;
        text-align: center;
        position: sticky;
        top: 0;
    }

    tbody tr:hover {
        background-color: #f9fafb;
    }

    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .text-left { text-align: left; }

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

    .card-number {
        background-color: #e2e8f0;
        border-radius: 12px;
        padding: 2px 8px;
        font-size: 12px;
        font-weight: 500;
    }

    .card-title {
        font-weight: 600;
        font-size: 16px;
        color: #1d4ed8;
    }

    .card-content {
        display: grid;
        grid-template-columns: 1fr;
        gap: 10px;
    }

    .data-item {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
    }

    .data-label {
        font-weight: 500;
        color: #64748b;
        font-size: 14px;
    }

    .data-value {
        font-weight: 600;
        font-size: 14px;
    }

    .data-value.amount {
        color: #16a34a;
    }

    .no-data-card {
        text-align: center;
        padding: 20px;
        font-style: italic;
        color: #64748b;
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

    /* Touch Enhancements */
    a, .card {
        -webkit-tap-highlight-color: transparent;
        touch-action: manipulation;
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
        const totalRow = document.querySelector('tfoot tr');
        
        if (!table || !cardContainer) return;
        
        cardContainer.innerHTML = '';
        
        const rows = table.querySelectorAll('tr');
        
        if (rows.length === 0 || (rows.length === 1 && rows[0].querySelector('td[colspan]'))) {
            cardContainer.innerHTML = `
                <div class="card no-data-card">
                    Tidak ada data tender yang belum input kontrak.
                </div>
            `;
            return;
        }
        
        // Create cards for each row
        rows.forEach((row, index) => {
            const cells = row.querySelectorAll('td');
            if (cells.length === 0 || cells[0].hasAttribute('colspan')) return;
            
            const card = document.createElement('div');
            card.className = 'card';
            
            card.innerHTML = `
                <div class="card-header">
                    <div class="card-number">${cells[0].textContent}</div>
                </div>
                
                <div class="card-content">
                    <div class="data-item">
                        <span class="data-label">Kode Tender</span>
                        <span class="data-value">${cells[1].textContent}</span>
                    </div>
                    
                    <div class="data-item">
                        <span class="data-label">Nama Paket</span>
                        <span class="data-value">${cells[2].textContent}</span>
                    </div>
                    
                    <div class="data-item">
                        <span class="data-label">Pagu</span>
                        <span class="data-value amount">${cells[3].textContent}</span>
                    </div>
                </div>
            `;
            
            cardContainer.appendChild(card);
        });
        
        // Add total card
        if (totalRow) {
            const totalCells = totalRow.querySelectorAll('td');
            const totalCard = document.createElement('div');
            totalCard.className = 'card';
            totalCard.style.borderLeftColor = '#16a34a';
            
            totalCard.innerHTML = `
                <div class="card-header">
                    <div class="card-title">Total Pagu</div>
                </div>
                
                <div class="card-content">
                    <div class="data-item" style="justify-content: center;">
                        <span class="data-value amount" style="font-size: 16px;">${totalCells[3].textContent}</span>
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
    document.querySelectorAll('.card').forEach(el => {
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
    <h1>Daftar Tender Selesai Tanpa Kontrak</h1>

    <div class="satker-info">
        <strong>Satker:</strong> {{ $satker }}
    </div>

    <a href="{{ route('monitoring.kontrak.detail.pdf', ['tahun' => request('tahun'), 'satker' => request('satker')]) }}"
       target="_blank"
       class="export-btn">
        📄 Export PDF
    </a>

    {{-- Desktop Table View --}}
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Tender</th>
                    <th>Nama Paket</th>
                    <th>Pagu</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $i => $item)
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td>{{ $item->kd_tender }}</td>
                        <td>{{ $item->nama_paket }}</td>
                        <td class="text-right">{{ number_format($item->pagu, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-gray-500 italic">
                            Tidak ada data tender yang belum input kontrak.
                        </td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-left font-bold">Total Pagu</td>
                    <td class="text-right font-bold text-green-600">
                        {{ number_format($totalPagu, 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- Mobile Card View --}}
    <div class="card-view"></div>
</div>
@endsection