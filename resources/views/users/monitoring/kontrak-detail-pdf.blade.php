<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Tender Belum Kontrak</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            margin: 30px;
        }

        h4, p.summary {
            text-align: center;
            margin: 5px 0;
        }

        p {
            text-align: center;
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px 8px;
            vertical-align: top;
            word-break: break-word;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
        }

        td.text-center {
            text-align: center;
        }

        td.text-right {
            text-align: right;
        }

    </style>
</head>
<body>
<h2>DAFTAR TENDER BELUM INPUT KONTRAK</h2>
    <div class="info">
        <strong>Satker:</strong> {{ $satker }}<br>
        <strong>Tahun:</strong> {{ $tahun }}
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 20%;">Kode Tender</th>
                <th style="width: 55%;">Nama Paket</th>
                <th style="width: 20%;">Pagu (Rp)</th>
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
                    <td colspan="4" class="text-center"><em>Tidak ada data tender yang belum input kontrak.</em></td>
                </tr>
            @endforelse
        </tbody>
    </table>

   
</body>
</html>
