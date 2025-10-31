@extends('layouts.user-adminlte')

@push('style')
<style>
    /* Main Container Styles */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 1rem;
    }
    
    /* Header Styles */
    .header-section {
        margin-bottom: 1.5rem;
    }
    
    .header-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.5rem;
    }
    
    .header-icon {
        background: #e0e7ff;
        padding: 0.75rem;
        border-radius: 0.5rem;
        color: #4f46e5;
    }
    
    .header-subtitle {
        color: #64748b;
        font-size: 0.875rem;
    }
    
    /* Filter Card Styles */
    .filter-card {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 1.25rem;
        margin-bottom: 1.5rem;
    }
    
    .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        align-items: end;
    }
    
    .filter-group {
        margin-bottom: 0;
    }
    
    .filter-label {
        display: block;
        font-size: 0.875rem;
        color: #64748b;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }
    
    .filter-select, .filter-input {
        width: 100%;
        padding: 0.5rem 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        transition: all 0.2s;
    }
    
    .filter-select:focus, .filter-input:focus {
        outline: none;
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }
    
    /* Table Styles */
    .table-container {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.875rem;
    }
    
    thead {
        background: #4f46e5;
        color: white;
    }
    
    th {
        padding: 0.75rem 1rem;
        text-align: left;
        font-weight: 500;
        position: relative;
    }
    
    th.text-center {
        text-align: center;
    }
    
    th.text-right {
        text-align: right;
    }
    
    td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #f1f5f9;
    }
    
    tbody tr:last-child td {
        border-bottom: none;
    }
    
    tbody tr:hover {
        background-color: #f8fafc;
    }
    
    .text-right {
        text-align: right;
    }
    
    .text-center {
        text-align: center;
    }
    
    /* Link Styles */
    .link-primary {
        color: #4f46e5;
        font-weight: 500;
        text-decoration: none;
        transition: color 0.2s;
    }
    
    .link-primary:hover {
        color: #4338ca;
        text-decoration: underline;
    }
    
    /* Amount Cell Styles */
    .amount-cell {
        font-family: 'Roboto Mono', monospace;
        font-weight: 500;
    }
    
    /* Total Row Styles */
    .total-row {
        font-weight: 600;
        background-color: #f8fafc;
    }
    
    /* Empty State Styles */
    .empty-state {
        padding: 2rem;
        text-align: center;
    }
    
    .empty-icon {
        color: #cbd5e1;
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }
    
    .empty-text {
        color: #64748b;
        font-size: 0.875rem;
    }
    
    /* Pagination Styles */
    .pagination-container {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        align-items: center;
        padding: 1rem;
        border-top: 1px solid #f1f5f9;
    }
    
    @media (min-width: 768px) {
        .pagination-container {
            flex-direction: row;
            justify-content: space-between;
        }
    }
    
    .pagination-info {
        color: #64748b;
        font-size: 0.875rem;
    }
    
    /* Summary Card Styles */
    .summary-card {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 1.25rem;
    }
    
    .summary-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    @media (min-width: 640px) {
        .summary-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (min-width: 1024px) {
        .summary-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    
    .summary-item {
        background-color: #f8fafc;
        padding: 1rem;
        border-radius: 0.375rem;
        border-left: 4px solid #4f46e5;
    }
    
    .summary-label {
        font-size: 0.875rem;
        color: #64748b;
        margin-bottom: 0.5rem;
    }
    
    .summary-value {
        font-size: 1.125rem;
        font-weight: 600;
        color: #1e293b;
    }
    
    /* Combobox Styles */
    .combobox-container {
        position: relative;
    }
    
    .combobox-input-container {
        position: relative;
        display: flex;
        align-items: center;
    }
    
    .combobox-input {
        padding-right: 2.5rem;
        width: 100%;
    }
    
    .combobox-buttons {
        position: absolute;
        right: 0.5rem;
        display: flex;
        gap: 0.25rem;
    }
    
    .combobox-button {
        width: 1.5rem;
        height: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: none;
        border: none;
        color: #64748b;
        cursor: pointer;
        border-radius: 0.25rem;
        transition: all 0.2s;
    }
    
    .combobox-button:hover {
        background-color: #e2e8f0;
        color: #475569;
    }
    
    .combobox-button svg {
        width: 1rem;
        height: 1rem;
    }
    
    .combobox-options {
        position: absolute;
        width: 100%;
        max-height: 15rem;
        overflow-y: auto;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 0.375rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        z-index: 10;
        margin-top: 0.25rem;
        display: none;
    }
    
    .combobox-option {
        padding: 0.5rem 1rem;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    
    .combobox-option:hover {
        background-color: #f1f5f9;
    }
    
    .show-options {
        display: block;
    }
    
    /* Loading Overlay Styles */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(255, 255, 255, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        display: none;
    }
    
    .loading-spinner {
        border: 4px solid #f3f3f3;
        border-top: 4px solid #4f46e5;
        border-radius: 50%;
        width: 3rem;
        height: 3rem;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    /* Mobile-specific styles */
    @media (max-width: 767px) {
        .header-title {
            font-size: 1.25rem;
        }
        
        .filter-card {
            padding: 1rem;
        }
        
        .filter-grid {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }
        
        th, td {
            padding: 0.5rem;
            font-size: 0.8125rem;
        }
        
        .summary-item {
            padding: 0.75rem;
        }
        
        .summary-value {
            font-size: 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container">
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Header Section -->
    <div class="header-section">
        <h1 class="header-title">
            <span class="header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </span>
            Monitoring Kontrak Tender
        </h1>
        <p class="header-subtitle">Data tender yang telah selesai dan status kontraknya</p>
    </div>

    <!-- Filter Section -->
    <div class="filter-card">
        <form method="GET" id="filterForm">
            <div class="filter-grid">
                <!-- Tahun Anggaran Filter -->
                <div class="filter-group">
                    <label for="tahun_anggaran" class="filter-label">Tahun</label>
                    <select name="tahun_anggaran" id="tahun_anggaran" class="filter-select" onchange="submitForm()">
                        @foreach ($tahunList as $t)
                            <option value="{{ $t }}" {{ $t == request('tahun_anggaran', $tahun) ? 'selected' : '' }}>
                                {{ $t }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Satker Combobox Filter -->
                <div class="filter-group combobox-container">
                    <label for="satker_search" class="filter-label">Satuan Kerja</label>
                    <div class="combobox-input-container">
                        <input type="text" id="satker_search" class="filter-input combobox-input" 
                               placeholder="Cari atau pilih satker..." value="{{ request('nama_satker') }}"
                               oninput="filterSatkerOptions()">
                        <input type="hidden" name="nama_satker" id="nama_satker" value="{{ request('nama_satker') }}">
                        <div class="combobox-buttons">
                            @if(request('nama_satker'))
                            <button type="button" class="combobox-button" onclick="clearSatkerSelection()" title="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                            @endif
                            <button type="button" class="combobox-button" onclick="resetSatkerFilter()" title="Reset">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div id="satker_options" class="combobox-options">
                        @foreach ($satkerList as $satkerName)
                            <div class="combobox-option" data-value="{{ $satkerName }}" onclick="selectSatker('{{ $satkerName }}')">
                                {{ $satkerName }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div class="table-container">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th style="min-width: 250px;">Nama Satker</th>
                        <th style="width: 150px;" class="text-center">Total Tender Selesai</th>
                        <th style="width: 180px;" class="text-right">Total Nilai Pagu</th>
                        <th style="width: 150px;" class="text-right">Belum Kontrak</th>
                    </tr>
                </thead>

                <tbody id="tableBody">
                    @if(count($data) > 0)
                        @foreach ($data as $i => $item)
                            <tr>
                                <td class="text-center">
                                    @if(is_object($data) && method_exists($data, 'currentPage'))
                                        {{ ($data->currentPage() - 1) * $data->perPage() + $i + 1 }}
                                    @else
                                        {{ $i + 1 }}
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('monitoring.kontrak.detail', ['satker' => urlencode($item['nama_satker'])]) }}?tahun={{ request('tahun_anggaran', $tahun) }}" 
                                       class="link-primary">
                                        {{ $item['nama_satker'] }}
                                    </a>
                                </td>
                                <td class="text-center">{{ $item['total_paket'] }}</td>
                                <td class="text-right amount-cell">{{ number_format($item['total_pagu'], 0, ',', '.') }}</td>
                                <td class="text-right">{{ $item['total_kontrak'] }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <p class="empty-text">Tidak ada data yang ditemukan</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(count($data) > 0 && is_object($data) && method_exists($data, 'links'))
        <div class="pagination-container">
            <div class="pagination-info">
                Menampilkan {{ ($data->currentPage() - 1) * $data->perPage() + 1 }} - 
                {{ min($data->currentPage() * $data->perPage(), $data->total()) }} dari {{ $data->total() }} entri
            </div>
            <div>
                {{ $data->appends(request()->query())->links() }}
            </div>
        </div>
        @endif
    </div>

    <!-- Summary Section -->
    <div class="summary-card">
        <div class="summary-grid">
            <div class="summary-item">
                <div class="summary-label">Total Tender Selesai Tahun {{ request('tahun_anggaran', $tahun) }}</div>
                <div class="summary-value amount-cell">{{ number_format($totalTenderSelesai, 0, ',', '.') }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Total Kontrak Tercatat</div>
                <div class="summary-value amount-cell">{{ number_format($totalKontrak, 0, ',', '.') }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Selisih (Belum Kontrak)</div>
                <div class="summary-value amount-cell">{{ number_format($selisih, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
</div>

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
        document.getElementById('nama_satker').value = value;
        document.getElementById('satker_options').classList.remove('show-options');
        submitForm();
    }

    function clearSatkerSelection() {
        document.getElementById('satker_search').value = '';
        document.getElementById('nama_satker').value = '';
        submitForm();
    }

    function resetSatkerFilter() {
        document.getElementById('satker_search').value = '';
        document.getElementById('nama_satker').value = '';
        document.getElementById('tahun_anggaran').value = '{{ $tahun }}';
        submitForm();
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const options = document.getElementById('satker_options');
        const input = document.getElementById('satker_search');
        if (!input.contains(event.target) && !options.contains(event.target)) {
            options.classList.remove('show-options');
        }
    });

    // Form submission with loading indicator
    function submitForm() {
        document.getElementById('loadingOverlay').style.display = 'flex';
        document.getElementById('filterForm').submit();
    }

    // Show loading indicator when page is loading
    document.addEventListener('DOMContentLoaded', function() {
        // Hide loading overlay when page is fully loaded
        document.getElementById('loadingOverlay').style.display = 'none';
        
        // Initialize combobox if there's a selected value
        if(document.getElementById('nama_satker').value) {
            document.getElementById('satker_search').value = document.getElementById('nama_satker').value;
        }
    });
</script>
@endpush
@endsection