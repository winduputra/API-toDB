<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rekapitulasi Realisasi Pengadaan Berlangsung - Tahun {{ $tahun }}</title>
    <style>
        @page {
            size: A3 landscape;
            margin: 25mm 15mm 20mm 15mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 0;
        }

        .container {
            margin-left: 0;
            padding: 0 15px;
        }

        .header {
            text-align: center;
            margin-top: 30px;
            margin-bottom: 20px;
        }

        .header h3 {
            margin: 0;
            font-size: 16px;
            text-transform: uppercase;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
            margin-left: 200;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px 8px;
            font-size: 10px;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }

        td {
            text-align: center;
        }

        td.text-left {
            text-align: left;
        }

        td.text-right {
            text-align: right;
        }

        .total-row td {
            background-color: #e0e0e0;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h3>REKAPITULASI REALISASI PENGADAAN BERLANGSUNG {{ $tahun }}</h3>
        </div>

        <table>
            <thead>
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Nama Satker</th>
                    <th colspan="2">Tender</th>
                    <th colspan="2">Non-Tender</th>
                    <th colspan="2">E-Katalog</th>
                    <th colspan="2">Toko Daring</th>
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

                @foreach ($data as $i => $row)
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
                @endforeach

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
            </tbody>
        </table>
    </div>
</body>
</html>
