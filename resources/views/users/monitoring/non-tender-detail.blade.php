@extends('layouts.user-adminlte')

@push('style')
<style>
    .table-container {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        margin-top: 1rem;
    }

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 13px;
    }

    thead {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: white;
    }

    th {
        padding: 10px 12px;
        text-align: left;
        font-weight: 500;
        position: relative;
    }

    th:not(:last-child)::after {
        content: "";
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        height: 60%;
        width: 1px;
        background: rgba(255, 255, 255, 0.2);
    }

    td {
        padding: 8px 12px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
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

    .empty-state {
        text-align: center;
        padding: 2rem 1rem;
    }

    .empty-icon {
        font-size: 2rem;
        color: #cbd5e1;
        margin-bottom: 0.5rem;
    }

    .empty-text {
        color: #64748b;
        font-size: 0.875rem;
    }

    .amount-cell {
        font-family: 'Roboto Mono', monospace;
        font-weight: 500;
    }

    .action-buttons {
        display: flex;
        gap: 0.4rem;
        margin-bottom: 0.8rem;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.3rem 0.6rem;
        border-radius: 3px;
        font-weight: 500;
        font-size: 0.7rem;
        transition: all 0.2s;
    }

    .btn-primary {
        background-color: #2563eb;
        color: white;
        border: 1px solid #2563eb;
    }

    .btn-primary:hover {
        background-color: #1d4ed8;
    }

    .btn-secondary {
        background-color: white;
        color: #2563eb;
        border: 1px solid #d1d5db;
    }

    .btn-secondary:hover {
        background-color: #f9fafb;

    
    }
    .btn svg {
        width: 14px; /* Ukuran ikon */
        height: 14px;
    }

    .header-section {
        margin-bottom: 1rem;
    }

    .header-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .header-subtitle {
        color: #64748b;
        font-size: 0.8125rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 0.75rem;
        margin-bottom: 1rem;
        font-size: 0.8125rem;
    }

    .info-item {
        background-color: #f8fafc;
        padding: 0.5rem 0.75rem;
        border-radius: 4px;
        border-left: 3px solid #2563eb;
    }

    .info-label {
        color: #64748b;
        font-weight: 500;
    }

    .info-value {
        color: #1e293b;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="container mx-auto px-4 py-4">
    <div class="header-section">
        <h1 class="header-title">
            <span class="bg-blue-100 p-1.5 rounded-md text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </span>
            Daftar Non Tender Selesai Tanpa Kontrak
        </h1>
        <p class="header-subtitle">Berikut adalah daftar non tender yang telah selesai namun belum memiliki data kontrak</p>
    </div>

    <div class="info-grid">
        <div class="info-item">
            <div class="info-label">Satuan Kerja</div>
            <div class="info-value">{{ $satker }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Tahun Anggaran</div>
            <div class="info-value">{{ $tahun }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Total Paket</div>
            <div class="info-value">{{ $data->count() }}</div>
        </div>
    </div>

    <div class="action-buttons">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
        <a href="{{ route('monitoring.non_tender.detail.pdf', ['satker' => urlencode($satker), 'tahun' => $tahun]) }}" 
           target="_blank"
           class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
            </svg>
            Export PDF
        </a>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Non Tender</th>
                    <th>Nama Paket</th>
                    <th class="text-right">Pagu (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $i => $item)
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td class="font-mono">{{ $item->kd_nontender }}</td>
                        <td>{{ $item->nama_paket }}</td>
                        <td class="text-right amount-cell">{{ number_format($item->pagu, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <p class="empty-text">Tidak ada data Non Tender yang belum input kontrak</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
            @if($data->isNotEmpty())
            <tfoot>
                <tr class="bg-gray-50">
                    <td colspan="3" class="font-semibold">Total Pagu</td>
                    <td class="font-semibold text-right text-blue-600 amount-cell">
                        {{ number_format($totalPagu, 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
@endsection