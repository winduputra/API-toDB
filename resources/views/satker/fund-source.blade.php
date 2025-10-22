<style>
  td {
    border: 1px solid #000000; 
    padding: 5px; 
  }
</style>
<page>
  <div style="text-align: center; font-size: 14px">
    <p style="margin: 0;"><b>REKAPITULASI LAPORAN HASIL SUMBER DANA</b></p>
    <p style="margin: 0;"><b>(APBD, BLUD, APBN, DAN DAK)</b></p>
    <p style="margin: 0;"><b>S.D. TANGGAL {{ date("Y") }} S.D TANGGAL {{ date("d") }} {{ strtoupper(getMonthName(date("m"))) }} {{ date("Y") }}</b></p>
  </div>

  <br/>

  <div>
    <table style="width: 100%; border-collapse: collapse; max-width: 100%; display: block; border: 1px solid #000000">
      <tr style="text-align: center;">
        <td rowspan="3" style="text-align: center; vertical-align: middle;">No.</td>
        <td rowspan="3" style="text-align: center; vertical-align: middle;">OPD</td>
        <td rowspan="3" style="text-align: center; vertical-align: middle;">JUMLAH<br/>PAKET</td>
        <td colspan="8" style="text-align: center;">SUMBER DANA</td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: center;">APBD</td>
        <td colspan="2" style="text-align: center; width: 10%;">BLUD</td>
        <td colspan="2" style="text-align: center; width: 10%;">APBN</td>
        <td colspan="2" style="text-align: center; width: 10%;">DAK</td>
      </tr>
      <tr>
        <td style="text-align: center;">PAGU<br/>(Rp)</td>
        <td style="text-align: center;">HPS<br/>(Rp)</td>
        <td style="text-align: center;">PAGU<br/>(Rp)</td>
        <td style="text-align: center;">HPS<br/>(Rp)</td>
        <td style="text-align: center;">PAGU<br/>(Rp)</td>
        <td style="text-align: center;">HPS<br/>(Rp)</td>
        <td style="text-align: center;">PAGU<br/>(Rp)</td>
        <td style="text-align: center;">HPS<br/>(Rp)</td>
      </tr>
      @foreach ($data as $item)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td style="font-size: 12px;">{{ $item['name'] }}</td>
        <td style="text-align: right;">{{ $item['package_count'] }}</td>
        <td style="text-align: right;">{{ moneyFormat($item['apbd_pagu']) }}</td>
        <td style="text-align: right;">{{ moneyFormat($item['apbd_hps']) }}</td>
        <td style="text-align: right;">{{ moneyFormat($item['blud_pagu']) }}</td>
        <td style="text-align: right;">{{ moneyFormat($item['blud_hps']) }}</td>
        <td style="text-align: right;">{{ moneyFormat($item['apbn_pagu']) }}</td>
        <td style="text-align: right;">{{ moneyFormat($item['apbn_hps']) }}</td>
        <td style="text-align: right;">{{ moneyFormat($item['dak_pagu']) }}</td>
        <td style="text-align: right;">{{ moneyFormat($item['dak_hps']) }}</td>
      </tr>
      @endforeach
      <tr>
        <td colspan="2" style="text-align: right; vertical-align: middle; font-size: 12px;"><b>Total</b></td>
        <td style="text-align: right;">{{ $total['package_count'] }}</td>
        <td style="text-align: right;">{{ moneyFormat($total['apbd_pagu']) }}</td>
        <td style="text-align: right;">{{ moneyFormat($total['apbd_hps']) }}</td>
        <td style="text-align: right;">{{ moneyFormat($total['blud_pagu']) }}</td>
        <td style="text-align: right;">{{ moneyFormat($total['blud_hps']) }}</td>
        <td style="text-align: right;">{{ moneyFormat($total['apbn_pagu']) }}</td>
        <td style="text-align: right;">{{ moneyFormat($total['apbn_hps']) }}</td>
        <td style="text-align: right;">{{ moneyFormat($total['dak_pagu']) }}</td>
        <td style="text-align: right;">{{ moneyFormat($total['dak_hps']) }}</td>
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
</page>