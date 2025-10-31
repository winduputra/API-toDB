@php
  $judul = 'LAPORAN TOKO DARING (BELA PENGADAAN)';
  if (isset($satker) && $satker !== 'Semua' && $rekap->isNotEmpty()) {
      $judul .= '<br>' . strtoupper($rekap->first()['nama_satker']);
  }
@endphp

<h3 style="text-align: center;">{!! $judul !!}<br>{{ $tanggal }}</h3>

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
    text-align: center;
    vertical-align: middle;
    word-wrap: break-word;
  }

  th {
    background-color: #f0f0f0;
  }

  th:nth-child(1), td:nth-child(1) { width: 5%; }
  th:nth-child(2), td:nth-child(2) { width: 50%; text-align: left; }
  th:nth-child(3), td:nth-child(3) { width: 20%; }
  th:nth-child(4), td:nth-child(4) { width: 25%; text-align: right; }

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

  .summary-row td {
    font-weight: bold;
    background-color: #f9f9f9;
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
    @php 
      $i = 1;
      $totalPaket = 0;
      $totalNilai = 0;
    @endphp

    @foreach($rekap as $kdSatker => $data)
    <tr>
      <td>{{ $i++ }}</td>
      <td style="text-align: left;">{{ $data['nama_satker'] }}</td>
      <td>{{ number_format($data['total_transaksi'], 0, ',', '.') }}</td>
      <td style="text-align: right;">Rp{{ number_format($data['nilai_transaksi'], 0, ',', '.') }}</td>
    </tr>
    @php
      $totalPaket += $data['total_transaksi'];
      $totalNilai += $data['nilai_transaksi'];
    @endphp
    @endforeach

    <tr class="summary-row">
      <td colspan="2">TOTAL</td>
      <td>{{ number_format($totalPaket, 0, ',', '.') }}</td>
      <td style="text-align: right;">Rp{{ number_format($totalNilai, 0, ',', '.') }}</td>
    </tr>
  </tbody>
</table>

{{-- Tanda Tangan --}}
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