<style>
    td, th {
      border: 1px solid #000000; 
      padding: 7px 5px; 
      font-size: 12px;
    }
    table {
      border-collapse: collapse;
      width: 100%;
      margin-bottom: 10px;
    }
</style>
<page>
    <div style="text-align: center; font-size: 15px; font-weight: bold;">
        <p style="margin: 0;"><b>DATA RENCANA UMUM PENGADAAN (RUP)</b></p>
        <p style="margin: 0;"><b>PEMERINTAH PROVINSI LAMPUNG</b></p>
        @if ($tahun == '2024')
        <p style="margin: 0;"><b>DESEMBER 2024</b></p>
        @else
        <p style="margin: 0;"><b>TANGGAL {{ date("d") }} {{ strtoupper(getMonthName(date("m"))) }} {{ $tahun }}</b></p>
        @endif
    </div>
    <br/>

    <div>
        <table>
            <tr style="text-align: center; font-weight: bold;">
                <td rowspan="2" style="vertical-align: middle;">No.</td>
                <td rowspan="2" style="vertical-align: middle;">SATUAN KERJA</td>
                <td colspan="2">PENYEDIA</td>
                <td colspan="2">SWAKELOLA</td>
                <td colspan="2">PENYEDIA<br>DALAM SWAKELOLA</td>
                <td colspan="2">TOTAL</td>
            </tr>
            <tr style="text-align: center; font-weight: bold;">
                <td>PAKET</td>
                <td>PAGU</td>
                <td>PAKET</td>
                <td>PAGU</td>
                <td>PAKET</td>
                <td>PAGU</td>
                <td>PAKET</td>
                <td>PAGU</td>
            </tr>
            @php $rowNum = 1; @endphp
            @foreach ($rekap as $item)
            <tr>
                <td style="text-align: center;">{{ $rowNum++ }}</td>
                <td>{{ $item['nama_satker'] }}</td>
                <td style="text-align: right;">{{ moneyFormat($item['paket_penyedia']) }}</td>
                <td style="text-align: right;">{{ moneyFormat($item['pagu_penyedia']) }}</td>
                <td style="text-align: right;">{{ moneyFormat($item['paket_swakelola']) }}</td>
                <td style="text-align: right;">{{ moneyFormat($item['pagu_swakelola']) }}</td>
                <td style="text-align: right;">{{ moneyFormat($item['paket_dalam']) }}</td>
                <td style="text-align: right;">{{ moneyFormat($item['pagu_dalam']) }}</td>
                <td style="text-align: right;">{{ moneyFormat($item['paket_total']) }}</td>
                <td style="text-align: right;">{{ moneyFormat($item['pagu_total']) }}</td>
            </tr>
            @endforeach
            <tr style="font-weight: bold; background: #f5f5f5;">
                <td colspan="2" style="text-align: center;">TOTAL</td>
                <td style="text-align: right;">{{ moneyFormat($grandTotal['paket_penyedia']) }}</td>
                <td style="text-align: right;">{{ moneyFormat($grandTotal['pagu_penyedia']) }}</td>
                <td style="text-align: right;">{{ moneyFormat($grandTotal['paket_swakelola']) }}</td>
                <td style="text-align: right;">{{ moneyFormat($grandTotal['pagu_swakelola']) }}</td>
                <td style="text-align: right;">{{ moneyFormat($grandTotal['paket_dalam']) }}</td>
                <td style="text-align: right;">{{ moneyFormat($grandTotal['pagu_dalam']) }}</td>
                <td style="text-align: right;">{{ moneyFormat($grandTotal['paket_total']) }}</td>
                <td style="text-align: right;">{{ moneyFormat($grandTotal['pagu_total']) }}</td>
            </tr>
        </table>
        
        <br/><br/><br/><br/>
        <table style="width: 90%;">
            <tr>
                <td style="width: 75%; border: 0;"></td>
                <td style="width: 25%; text-align: center; font-weight: bold; border: 0;">
                <p style="margin: 0;">KEPALA BIRO PENGADAAN</p>
                    <p style="margin: 0;">BARANG DAN JASA,</p>
                    <br/><br/><br/><br/><br/><br/><br/><br/>
                    <p style="margin: 0;">PUADI JAILANI,SH.,MH</p>
                    <p style="margin: 0;">PEMBINA UTAMA MUDA</p>
                    <p style="margin: 0;">NIP. 19650905 199103 1 004</p>
                </td>
            </tr>
        </table>
    </div>
</page>
