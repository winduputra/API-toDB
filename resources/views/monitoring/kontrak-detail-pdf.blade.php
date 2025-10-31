<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail Kontrak - PDF</title>
    <style>
        @page {
            margin: 20mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            text-align: center;
        }

        h2 {
            font-size: 16px;
            text-transform: uppercase;
            margin-top: 10px;
            margin-bottom: 5px;
        }

        .info {
            margin-bottom: 15px;
            font-size: 13px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11.5px;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px 8px;
        }

        th {
            background-color: #f0f0f0;
        }

        td.center {
            text-align: center;
        }

        td.right {
            text-align: right;
        }

        tfoot td {
            font-weight: bold;
            background-color: #f9fafb;
        }

        tr {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Detail Tender Selesai Tanpa Kontrak</h2>
        <div class="info">
            <strong>Satker:</strong> {{ $satker }}
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 20%;">Kode Tender</th>
                    <th>Nama Paket</th>
                    <th style="width: 20%;">Pagu (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $i => $item)
                <tr>
                    <td class="center">{{ $i + 1 }}</td>
                    <td>{{ $item->kd_tender }}</td>
                    <td>{{ $item->nama_paket }}</td>
                    <td class="right">{{ number_format($item->pagu, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="center" style="font-style: italic;">Tidak ada data tender yang belum input kontrak.</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="center">Total Pagu</td>
                    <td class="right">{{ number_format($totalPagu, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>
