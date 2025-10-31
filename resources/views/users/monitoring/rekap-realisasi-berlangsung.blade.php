@extends('layouts.user-adminlte')

@push('style')
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f9fafb;
    }

    .container {
        padding: 24px;
        max-width: 1400px;
        margin: auto;
    }

    h1 {
        color: #1d4ed8;
        font-size: 30px;
        font-weight: bold;
        margin-bottom: 24px;
    }

    form {
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }

    label {
        font-weight: 600;
    }

    select {
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
        background-color: #1d4ed8;
        color: white;
        border-radius: 6px;
        text-decoration: none;
        transition: background 0.2s;
    }

    .export-btn:hover {
        background-color: #1e3a8a;
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }

    table {
        min-width: 1100px;
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        color: #334155;
        table-layout: auto;
    }

    thead th {
        position: sticky;
        top: 0;
        z-index: 2;
        background-color: #e2e8f0;
        padding: 10px;
        border: 1px solid #cbd5e1;
        font-weight: bold;
        text-align: center;
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
        padding: 8px 10px;
        border: 1px solid #e2e8f0;
        text-align: center;
        vertical-align: middle;
    }

    tbody td.text-left {
        text-align: left;
    }

    tbody td.text-right {
        text-align: right;
    }

    tbody tr:hover {
        background-color: #f8fafc;
    }

    .no-data {
        text-align: center;
        font-style: italic;
        color: #64748b;
        padding: 20px;
    }

    @media (max-width: 768px) {
        form {
            flex-direction: column;
            align-items: flex-start;
        }

        select, .export-btn {
            width: 100%;
        }

        .export-btn {
            margin-left: 0;
        }

        h1 {
            font-size: 24px;
        }

        table {
            font-size: 12px;
            min-width: unset;
        }
    }
</style>
@endpush

@section('content')
<div class="container">
    <h1>Rekapitulasi Realisasi Pengadaan Berlangsung</h1>

    <!-- Filter Tahun & Satker -->
    <form method="GET" id="filter-form">
        <label for="tahun">Tahun:</label>
        <select name="tahun" id="tahun" onchange="document.getElementById('filter-form').submit()">
            @foreach([2024, 2025] as $th)
                <option value="{{ $th }}" {{ $tahun == $th ? 'selected' : '' }}>{{ $th }}</option>
            @endforeach
        </select>

        <label for="satker">Nama Satker:</label>
        <select name="satker" id="satker" onchange="document.getElementById('filter-form').submit()">
            <option value="">-- Semua Satker --</option>
            @foreach($listSatker as $satker)
                <option value="{{ $satker }}" {{ request('satker') == $satker ? 'selected' : '' }}>{{ $satker }}</option>
            @endforeach
        </select>

        <a href="{{ route('monitoring.rekap.realisasi-berlangsung.pdf', ['tahun' => $tahun]) }}"
           target="_blank"
           class="export-btn">
            📄 Export PDF
        </a>
    </form>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Nama Satker</th>
                    <th colspan="2" class="bg-green">Tender</th>
                    <th colspan="2" class="bg-yellow">Non-Tender</th>
                    <th colspan="2" class="bg-blue">E-Katalog</th>
                    <th colspan="2" class="bg-orange">Toko Daring</th>
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
                        <td colspan="12" class="no-data">Tidak ada data tersedia untuk tahun {{ $tahun }}.</td>
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
                        <td>{{ $total['tokodaring_paket'] }}</td>
                        <td class="text-right">{{ number_format($total['tokodaring_nilai'], 0, ',', '.') }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
