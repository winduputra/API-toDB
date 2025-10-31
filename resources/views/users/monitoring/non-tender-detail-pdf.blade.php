<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: sans-serif;
            font-size: 13px;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            margin: 0 auto;
        }
        h2 {
            text-align: center;
            margin-bottom: 10px;
        }
        .info {
            margin-bottom: 20px;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin: 0 auto;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #eee;
        }
        tfoot td {
            font-weight: bold;
            background-color: #f1f5f9;
        }
        tr { page-break-inside: avoid; }
    </style>
    <div style="text-align: center; font-size: 14px">
    <title>PDF Non Tender Tanpa Kontrak</title>
    
</head>
<body>
    <div class="container">
        <h2>DAFTAR NON TENDER TANPA KONTRAK</h2>
        <div class="info">
            <strong>Satker:</strong> {{ $satker }}<br>
            <strong>Tahun:</strong> {{ request('tahun_anggaran') }}
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Non-Tender</th>
                    <th>Nama Paket</th>
                    <th>Metode</th>
                    <th>Jenis Pengadaan</th>
                    <th>Nilai Pagu</th>
                    <th>Pemenang</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($nonTender as $i => $item)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $item->kd_nontender }}</td>
                        <td>{{ $item->nama_paket }}</td>
                        <td>{{ $item->metode }}</td>
                        <td>{{ $item->jenis_pengadaan }}</td>
                        <td>{{ moneyFormat($item->pagu) }}</td>
                        <td>{{ $item->pemenang }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center;">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" style="text-align: right;">Total</td>
                    <td colspan="2">{{ moneyFormat($totalPagu) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
    </div>
</body>
</html>
