<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Realisasi Pengadaan</title>
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
        }

        th, td {
            border: 1px solid #000;
            padding: 5px 4px;
            text-align: center; /* Default rata tengah */
            font-size: 9px;
            vertical-align: middle;
        }

        th {
            background-color: #e2e8f0;
        }

        td.text-left {
            text-align: left !important; /* Khusus kolom Nama Satker */
        }

        .total-row {
            font-weight: bold;
            background-color: #fef9c3;
        }
    </style>
</head>
<body>

    <h3>Realisasi Pengadaan Tahun {{ $tahun }}</h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Satker</th>
                <th>Anggaran Belanja Pengadaan</th>
                <th>Total Realisasi Pengadaan <br><span style="font-size: 10px;">(Tender, Non-Tender, E-Katalog, Toko Daring)</span></th>
                <th>Persentase Realisasi <br><span style="font-size: 10px;">(D / C × 100%)</span></th>
            </tr>
            <tr>
                <th>A</th>
                <th>B</th>
                <th>C</th>
                <th>D</th>
                <th>E</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalBelanja = 0;
                $totalTransaksi = 0;
                $totalPersen = 0;
            @endphp

            @foreach($data as $index => $item)
                @php
                    $totalBelanja += $item->belanja_pengadaan;
                    $totalTransaksi += $item->total_transaksi;
                    $totalPersen += $item->presentase_realisasi;
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="text-left">{{ $item->nama_satker }}</td>
                    <td>{{ number_format($item->belanja_pengadaan, 0, ',', '.') }}</td>
                    <td>{{ number_format($item->total_transaksi, 0, ',', '.') }}</td>
                    <td>{{ number_format($item->presentase_realisasi, 2, ',', '.') }}%</td>
                </tr>
            @endforeach

            @php
                $jumlahData = $data->count();
                $rataPersen = $jumlahData > 0 ? $totalPersen / $jumlahData : 0;
            @endphp

            @if($jumlahData > 0)
                <tr class="total-row">
                    <td colspan="2">TOTAL</td>
                    <td>{{ number_format($totalBelanja, 0, ',', '.') }}</td>
                    <td>{{ number_format($totalTransaksi, 0, ',', '.') }}</td>
                    <td>{{ number_format($rataPersen, 2, ',', '.') }}%</td>
                </tr>
            @endif
        </tbody>
    </table>

</body>
</html>
