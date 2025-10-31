<style>
  td {
    border: 1px solid #000000; 
    padding: 5px; 
  }
</style>
<page>
  <div style="text-align: center; font-size: 16px">
    <p style="margin: 0;"><b>REKAPITULASI HASIL PENGELOMPOKKAN JENIS PENGADAAN BARANG/JASA PER OPD</b></p>
    <p style="margin: 0;"><b>S.D TANGGAL {{ date("d") }} {{ strtoupper(getMonthName(date("m"))) }} {{ date("Y") }}</b></p>
  </div>

  <br/>

  <div>
    <table style="width: 100%; border-collapse: collapse; max-width: 100%; display: block; border: 1px solid #000000">
      <tr style="text-align: center;">
        <td rowspan="3" style="vertical-align: middle; text-align: center;">No.</td>
        <td rowspan="3" style="vertical-align: middle; text-align: center;">OPD</td>
        <td colspan="8">PENGELOMPOKKAN JENIS PENGADAAN BARANG DAN JASA</td>
        <td rowspan="3" style="vertical-align: middle; text-align: center;">JUMLAH</td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: center; vertical-align:middle;">PEKERJAAN KONSTRUKSI</td>
        <td colspan="2" style="text-align: center; vertical-align:middle;">JASA KONSULTANSI</td>
        <td colspan="2" style="text-align: center; vertical-align:middle;">PENGADAAN BARANG</td>
        <td colspan="2" style="text-align: center; vertical-align:middle;">JASA LAINNYA</td>
      </tr>
      <tr>
        <td style="text-align: center; vertical-align:middle;">SELESAI</td>
        <td style="text-align: center; vertical-align:middle;">PROSES</td>
        <td style="text-align: center; vertical-align:middle;">SELESAI</td>
        <td style="text-align: center; vertical-align:middle;">PROSES</td>
        <td style="text-align: center; vertical-align:middle;">SELESAI</td>
        <td style="text-align: center; vertical-align:middle;">PROSES</td>
        <td style="text-align: center; vertical-align:middle;">SELESAI</td>
        <td style="text-align: center; vertical-align:middle;">PROSES</td>
      </tr>
      @foreach ($data as $item)
      <tr>
        <td style="text-align: center; vertical-align:middle;">{{ $loop->iteration }}</td>
        <td>{{ $item['name'] }}</td>
        <td style="text-align: center;">{{ $item['constructions_process'] }}</td>
        <td style="text-align: center;">{{ $item['constructions_done'] }}</td>
        <td style="text-align: center;">{{ $item['consultations_process'] }}</td>
        <td style="text-align: center;">{{ $item['consultations_done'] }}</td>
        <td style="text-align: center;">{{ $item['goods_process'] }}</td>
        <td style="text-align: center;">{{ $item['goods_done'] }}</td>
        <td style="text-align: center;">{{ $item['services_process'] }}</td>
        <td style="text-align: center;">{{ $item['services_done'] }}</td>
        <td style="text-align: center;"><b>{{ intval($item['constructions_process'] + $item['constructions_done'] + $item['consultations_process'] + $item['consultations_done'] + $item['goods_process'] + $item['goods_done'] + $item['services_process'] + $item['services_done']) }}</b></td>
      </tr>
      @endforeach
      <tr>
        <td colspan="2" style="text-align: right; vertical-align:middle;"><b>Total Paket</b></td>
        <td style="text-align: center;"><b>{{ $total['constructions_process'] }}</b></td>
        <td style="text-align: center;"><b>{{ $total['constructions_done'] }}</b></td>
        <td style="text-align: center;"><b>{{ $total['consultations_process'] }}</b></td>
        <td style="text-align: center;"><b>{{ $total['consultations_done'] }}</b></td>
        <td style="text-align: center;"><b>{{ $total['goods_process'] }}</b></td>
        <td style="text-align: center;"><b>{{ $total['goods_done'] }}</b></td>
        <td style="text-align: center;"><b>{{ $total['services_process'] }}</b></td>
        <td style="text-align: center;"><b>{{ $total['services_done'] }}</b></td>
        <td style="text-align: center;"><b>{{ intval($total['constructions_process'] + $total['constructions_done'] + $total['consultations_process'] + $total['consultations_done'] + $total['goods_process'] + $total['goods_done'] + $total['services_process'] + $total['services_done']) }}</b></td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: right; vertical-align:middle;"><b>Total Keseluruhan Paket</b></td>
        <td colspan="2" style="text-align: center;"><b>{{ intval($total['constructions_process'] + $total['constructions_done']) }}</b></td>
        <td colspan="2" style="text-align: center;"><b>{{ intval($total['consultations_process'] + $total['consultations_done']) }}</b></td>
        <td colspan="2" style="text-align: center;"><b>{{ intval($total['goods_process'] + $total['goods_done']) }}</b></td>
        <td colspan="2" style="text-align: center;"><b>{{ intval($total['services_process'] + $total['services_done']) }}</b></td>
        <td style="text-align: center;"><b>{{ intval($total['constructions_process'] + $total['constructions_done'] + $total['consultations_process'] + $total['consultations_done'] + $total['goods_process'] + $total['goods_done'] + $total['services_process'] + $total['services_done']) }}</b></td>
      </tr>
    </table>
    <br/><br/><br/><br/>
    <table style="width: 90%;">
      <tr>
        <td style="width: 80%; border: 0;"></td>
        <td style="width: 29.5%; text-align: center; font-weight: bold; border: 0;">
          <p style="margin: 0;">KEPALA BIRO PENGADAAN</p>
          <p style="margin: 0;">BARANG DAN JASA,</p>
          <br/><br/><br/><br/><br/><br/><br/><br/>
          <p style="margin: 0;">SLAMET RIADI, S.Sos</p>
          <p style="margin: 0;">PEMBINA UTAMA MUDA</p>
          <p style="margin: 0;">NIP. 19670828 199903 1 005</p>
        </td>
      </tr>
    </table>
  </div>
  <div>
    
  </div>
</page>