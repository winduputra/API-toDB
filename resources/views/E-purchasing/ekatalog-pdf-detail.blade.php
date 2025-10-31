<h3 style="text-align: center;">
    LAPORAN E-KATALOG {{ $versi === 'V6' ? 'VERSI 6' : 'VERSI 5' }}<br>
    {{ $tanggal }}
</h3>

<table border="1" cellspacing="0" cellpadding="5" width="100%" style="font-size: 11px;">
    <thead>
        <tr>
            <th>ID RUP</th>
            <th>Satuan Kerja</th>
            <th>Nama Paket</th>
            <th>Status Paket</th>
            <th>Nilai Kontrak</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $item)
            <tr>
                <td>{{ $item['id_rup'] }}</td>
                <td>{{ $item['nama_satker'] }}</td>
                <td>{{ $item['nama_paket'] }}</td>
                <td>{{ $item['status'] }}</td>
                <td style="text-align: right;">Rp{{ number_format($item['nilai_kontrak'], 0, ',', '.') }}</td>
            </tr>
        @endforeach
        <tr>
            <th colspan="4" style="text-align: center;">TOTAL</th>
            <th style="text-align: right;">Rp{{ number_format($totalNilai, 0, ',', '.') }}</th>
        </tr>
    </tbody>
</table>
