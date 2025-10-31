@php
  $judulVersi = $versi === 'V5' ? 'LAPORAN E-KATALOG VERSI 5 (V5)' : 'LAPORAN E-KATALOG VERSI 6 (V6)';
  $judulStatus = strtoupper($status) === 'SELESAI' 
                  ? ' - PAKET SELESAI'
                  : (strtoupper($status) === 'PROSES' 
                      ? ' - PAKET PROSES'
                      : ' - SEMUA STATUS');

  $totalTransaksi = 0;
  $totalNilai = 0;
@endphp

<h3 style="text-align: center;">
  {{ $judulVersi }}{!! $judulStatus !!}<br>
  {{ $tanggal }}
</h3>

<style>
  body {
    font-family: sans-serif;
    font-size: 16px;
  }

  table {
    width: 90%;
    margin: 0 auto 20px auto;
    border-collapse: collapse;
    font-size: 11px;
  }

  th, td {
    border: 1px solid #000;
    padding: 5px;
    vertical-align: middle;
    word-wrap: break-word;
  }

  th {
    background-color: #f0f0f0;
    text-align: center;
  }

  td:nth-child(1) {
    width: 5%;
    text-align: center;
  }

  td:nth-child(2) {
    width: 50%;
    text-align: left;
  }

  td:nth-child(3) {
    width: 20%;
    text-align: center;
  }

  td:nth-child(4) {
    width: 25%;
    text-align: right;
  }

  .ttd-table {
    width: 100%;
    margin-top: 40px;
    border: none;
  }

  .ttd-table td {
    border: none;
    font-weight: bold;
  }

  .ttd-table p {
    margin: 0;
  }
</style>

<table>
  <thead>
    <tr>
      <th>No.</th>
      <th>SATUAN KERJA</th>
      <th>TOTAL TRANSAKSI</th>
      <th>NILAI TRANSAKSI</th>
    </tr>
  </thead>
  <tbody>
    @php $i = 1; @endphp
    @foreach($data as $nama_satker => $rekap)
      <tr>
        <td>{{ $i++ }}</td>
        <td>{{ $nama_satker }}</td>
        <td>{{ $rekap['total_transaksi'] }}</td>
        <td>Rp{{ number_format($rekap['nilai_transaksi'], 0, ',', '.') }}</td>
      </tr>
      @php
        $totalTransaksi += $rekap['total_transaksi'];
        $totalNilai += $rekap['nilai_transaksi'];
      @endphp
    @endforeach

    <tr>
      <td colspan="2" style="text-align: center; font-weight: bold;">TOTAL</td>
      <td style="font-weight: bold;">{{ $totalTransaksi }}</td>
      <td style="text-align: right; font-weight: bold;">
        Rp{{ number_format($totalNilai, 0, ',', '.') }}
      </td>
    </tr>
  </tbody>
</table>

<table class="ttd-table">
  <tr>
    <td style="width: 60%;"></td>
    <td style="width: 40%; text-align: center;">
      <p>KEPALA BIRO PENGADAAN</p>
      <p>BARANG DAN JASA,</p>
      <br><br><br><br><br>
      <p>PUADI JAILANI,SH.,MH</p>
      <p>PEMBINA UTAMA MUDA</p>
      <p>NIP. 19650905 199103 1 004</p>
    </td>
  </tr>
</table>
