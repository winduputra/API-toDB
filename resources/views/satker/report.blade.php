<style>
    td {
      border: 1px solid #000000; 
      padding: 5px; 
    }
    .center {
        text-align: center;
        vertical-align: middle;
    }
    .left {
        text-align: left !important;
    }
    .font-small {
        font-size: 10px;
    }
  </style>
  <page>
    <div style="text-align: center; font-size: 14px">
      <p style="margin: 0;"><b>LAPORAN HASIL REVIEW PERENCANAAN KEGIATAN PENGADAAN BARANG DAN JASA TA. {{ date("Y") }}</b></p>
    </div>
  
    <br/>
  
    <div>
      @foreach ($data as $item)
      @php
      $pagu = 0;
      $hps  = 0;
      @endphp
      <p style="margin: 0">NAMA OPD: {{ $item['name'] }}</p>
      <table style="width: 100%; border-collapse: collapse; max-width: 100%; display: block; border: 1px solid #000000">
        <tr style="text-align: center;">
          <td style="text-align: center;">No.</td>
          <td class="center" style="width: 12%">NAMA<br/>PAKET<br/>PEKERJAAN</td>
          <td class="center font-small" style="width: 8%;">Kategori<br/>Pengadaan</td>
          <td class="center" style="font-size: 12px;">NILAI PAGU (RP)</td>
          <td class="center" style="font-size: 12px;">HPS</td>
          <td class="center">NO. <br/>SURAT/TANGGAL<br/>(RPP)</td>
          <td class="center">KODE RUP<br/>DAN<br/>TENDER</td>
          <td class="center">NOMOR<br/>BERITA<br/>ACARA</td>
          <td class="center">METODE<br/>PEMILIHAN</td>
          <td class="center font-small" style="width: 8%;">PROSES<br/>TENDER</td>
          <td class="center font-small">SUMBER<br/>DANA</td>
          <td class="center font-small" style="width: 8%;">PERUSAHAAN<br/>PEMENANG</td>
          <td class="center">KETERANGAN</td>
        </tr>
        @foreach ($item['packages'] as $value)
        @php
        $pagu += $value->pagu;
        $hps  += $value->hps;
        @endphp
        <tr>
          <td class="center">{{ $loop->iteration }}</td>
          <td class="center left font-small" style="width: 12%">{{ $value->nama_paket }}</td>
          <td class="center font-small" style="width: 8%;">{{ $value->jenis_pengadaan }}</td>
          <td class="center font-small">{{ moneyFormat($value->pagu) }}</td>
          <td class="center font-small">{{ moneyFormat($value->hps) }}</td>
          <td class="center"></td>
          <td class="center font-small">{{ $value->kd_rup_paket }}</td>
          <td class="center"></td>
          <td class="center">{{ $value->metode_pemilihan }}</td>
          <td class="center font-small left" style="width: 8%;">
            @if ( count($value->schedules) )
            @foreach ($value->schedules as $item)
            @if ( $loop->last )
            {{ $item->tahapan }}    
            @endif
            @endforeach
            @endif
          </td>
          <td class="center">{{ $value->ang }}</td>
          <td class="center font-small" style="width: 8%;">{{ $value->nama_penyedia }}</td>
          <td class="center"></td>
        </tr>
        @endforeach
        <tr>
          <td style="text-align: right" colspan="3">TOTAL</td>
          <td class="center font-small"><b>{{ moneyFormat($pagu) }}</b></td>
          <td class="center font-small"><b>{{ moneyFormat($hps) }}</b></td>
          <td colspan="8"></td>
        </tr>
      </table>
      <br/><br/><br/>    
      @endforeach
      
    </div>
  </page>