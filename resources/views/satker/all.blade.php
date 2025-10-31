<style>
    td {
      border: 1px solid #000000; 
      padding: 5px; 
    }
  </style>
  <page>
    <div style="text-align: center; font-size: 14px">
      <p style="margin: 0;"><b>REKAPITULASI LAPORAN HASIL METODE PENGADAAN, JUMLAH PAKET, PAGU DAN HPS</b></p>
      <p style="margin: 0;"><b>(PER OPD) PADA KEGIATAN PENGADAAN BARANG DAN JASA</b></p>
      <p style="margin: 0;"><b>S.D. TANGGAL {{ date("d") }} {{ strtoupper(getMonthName(date("m"))) }} {{ date("Y") }}</b></p>
    </div>
  
    <br/>
  
    <div>
      <table style="width: 100%; border-collapse: collapse; max-width: 100%; display: block; border: 1px solid #000000">
        <tr style="text-align: center;">
          <td style="text-align: center;">No.</td>
          <td style="text-align: center;">METODE PENGADAAN</td>
          <td style="text-align: center;">PAKET</td>
          <td style="text-align: center;">PAGU</td>
          <td style="text-align: center;">HPS</td>
        </tr>
        @foreach ($method as $item)
        <tr>
          <td style="text-align: center;">{{ $loop->iteration }}</td>
          <td>{{ $item['name'] }}</td>
          <td style="text-align: center;">{{ $item['package_count'] }}</td>
          <td style="text-align: right;">{{ moneyFormat($item['pagu']) }}</td>
          <td style="text-align: right;">{{ moneyFormat($item['hps']) }}</td>    
        </tr>
        @endforeach
        <tr>
          <td colspan="2" style="text-align: right;"><b>JUMLAH</b></td>
          <td style="text-align: center;">{{ $totalMethod['package_count'] }}</td>
          <td style="text-align: right;">{{ moneyFormat($totalMethod['pagu']) }}</td>
          <td style="text-align: right;">{{ moneyFormat($totalMethod['hps']) }}</td>
        </tr>
      </table>
      <br/>
      <table style="width: 100%; border-collapse: collapse; max-width: 100%; display: block; border: 1px solid #000000">
        <tr style="text-align: center;">
          <td style="text-align: center;">No.</td>
          <td style="text-align: center;">OPD</td>
          <td style="text-align: center;">PAKET</td>
          <td style="text-align: center;">PAGU</td>
          <td style="text-align: center;">HPS</td>
        </tr>
        
        @foreach ($data as $item)
        <tr>
          <td style="text-align: center;">{{ $loop->iteration }}</td>
          <td>{{ $item['name'] }}</td>
          <td style="text-align: center;">{{ $item['package_count'] }}</td>
          <td style="text-align: right;">{{ moneyFormat($item['pagu']) }}</td>
          <td style="text-align: right;">{{ moneyFormat($item['hps']) }}</td>    
        </tr>
        @endforeach
        
        <tr>
          <td colspan="2" style="text-align: center;">JUMLAH</td>
          <td style="text-align: center;">{{ $total['package_count'] }}</td>
          <td style="text-align: right;">{{ moneyFormat($total['pagu']) }}</td>
          <td style="text-align: right;">{{ moneyFormat($total['hps']) }}</td>
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