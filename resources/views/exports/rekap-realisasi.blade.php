<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rekapitulasi Realisasi Pengadaan</title>
    <style>
        @page { margin: 20px; size: A4 landscape; }
        body { font-family: Arial, sans-serif; font-size: 10px; margin: 0; }

        h3 {
            text-align: center;
            margin-bottom: 16px;
            font-size: 14px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
            word-wrap: break-word;
        }

        th, td {
            border: 1px solid #000;
            padding: 5px 4px;
            font-size: 9px;
        }

        th { background-color: #e2e8f0; }

        .text-left { text-align: left; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }

        /* Kolom Lebar */
        th:nth-child(1), td:nth-child(1) { width: 3%; text-align: center; }
        th:nth-child(2), td:nth-child(2) { width: 17%; text-align: left; }

        th:nth-child(3), td:nth-child(3),
        th:nth-child(5), td:nth-child(5),
        th:nth-child(7), td:nth-child(7),
        th:nth-child(9), td:nth-child(9),
        th:nth-child(11), td:nth-child(11) {
            width: 6%;
            text-align: center;
        }

        th:nth-child(4), td:nth-child(4),
        th:nth-child(6), td:nth-child(6),
        th:nth-child(8), td:nth-child(8),
        th:nth-child(10), td:nth-child(10),
        th:nth-child(12), td:nth-child(12) {
            width: 10%;
            text-align: right;
        }

        .total-row {
            font-weight: bold;
            background-color: #fef9c3;
        }
    </style>
</head>
<body>

<h3>Rekapitulasi Realisasi Pengadaan Tahun {{ $tahun }}</h3>

<table>
    <thead>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Nama Satker</th>
            <th colspan="2">Tender</th>
            <th colspan="2">Non-Tender</th>
            <th colspan="2">E-Katalog</th>
            <th colspan="2">Swakelola</th>
            <th colspan="2">Toko Daring</th>
        </tr>
        <tr>
            <th>Total Paket</th><th>Total Nilai</th>
            <th>Total Paket</th><th>Total Nilai</th>
            <th>Total Paket</th><th>Total Nilai</th>
            <th>Total Paket</th><th>Total Nilai</th>
            <th>Total Paket</th><th>Total Nilai</th>
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

        @forelse($data as $i => $row)
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
                <td class="text-center">{{ $i + 1 }}</td>
                <td class="text-left">{{ $row['nama_satker'] }}</td>
                <td class="text-center">{{ $row['total_paket_tender'] }}</td>
                <td class="text-right">{{ number_format($row['total_nilai_tender'], 0, ',', '.') }}</td>
                <td class="text-center">{{ $row['total_paket_nontender'] }}</td>
                <td class="text-right">{{ number_format($row['total_nilai_nontender'], 0, ',', '.') }}</td>
                <td class="text-center">{{ $row['total_paket_ekatalog'] }}</td>
                <td class="text-right">{{ number_format($row['total_nilai_ekatalog'], 0, ',', '.') }}</td>
                <td class="text-center">{{ $row['total_paket_swakelola'] }}</td>
                <td class="text-right">{{ number_format($row['total_nilai_swakelola'], 0, ',', '.') }}</td>
                <td class="text-center">{{ $row['total_paket_tokodaring'] }}</td>
                <td class="text-right">{{ number_format($row['total_nilai_tokodaring'], 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="12" class="text-left">Tidak ada data tersedia.</td>
            </tr>
        @endforelse

        <tr class="total-row">
            <td colspan="2" class="text-center">TOTAL</td>
            <td class="text-center">{{ $total['tender_paket'] }}</td>
            <td class="text-right">{{ number_format($total['tender_nilai'], 0, ',', '.') }}</td>
            <td class="text-center">{{ $total['nontender_paket'] }}</td>
            <td class="text-right">{{ number_format($total['nontender_nilai'], 0, ',', '.') }}</td>
            <td class="text-center">{{ $total['ekatalog_paket'] }}</td>
            <td class="text-right">{{ number_format($total['ekatalog_nilai'], 0, ',', '.') }}</td>
            <td class="text-center">{{ $total['swakelola_paket'] }}</td>
            <td class="text-right">{{ number_format($total['swakelola_nilai'], 0, ',', '.') }}</td>
            <td class="text-center">{{ $total['tokodaring_paket'] }}</td>
            <td class="text-right">{{ number_format($total['tokodaring_nilai'], 0, ',', '.') }}</td>
        </tr>
    </tbody>
</table>

</body>
</html>
