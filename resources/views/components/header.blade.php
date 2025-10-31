<div class="w-full bg-base text-white">
  <div class="w-full md:w-4/5 px-3 md:px-0 flex justify-between items-center mx-auto">
    <div>
      <a href="#" class="text-2xl font-black">VMS</a>
    </div>
    <div class="md:block">
      <ul class="header-menu">
        <li><a href="#">BERANDA</a></li>
        <li><a href="{{ route('tender.list') }}">TENDER</a></li>
        <li><a href="{{ route('non-tender.list') }}" class="active">NON-TENDER</a></li>
        <li><a href="#">E-KATALOG</a></li>
        <li class="relative"><a href="#" class="have-sub-menu" data-target="sub-menu-1">SUMMARY REPORT</a>
            <ul id="sub-menu-1" class="bg-white mt-1 sub-menu hidden text-black md:w-96 absolute right-0 w-full overflow-auto z-10">
                <li class="relative" style="padding-left: 1rem">Reviu Perencanaan Kegiatan PBJ
                    <ul class="left-0 w-full mt-0 pl-4 no-separator">
                        <li><a target="_blank" href="{{ route('report.categorize') }}">Pengelompokan Jenis Pengadaan</a></li>
                        <li><a target="_blank" href="{{ route('tender.fund.source') }}">Hasil Sumber Dana</a></li>
                        <li><a target="_blank" href="{{ route('report.all') }}">Laporan Keseluruhan</a></li>
                    </ul>
                </li>
                <li><a target="_blank" href="{{ route('non-tender.realization') }}">Realisasi Non Tender</a></li>
                <li><a target="_blank" href="{{ route('tender.realization') }}">Realisasi Tender</a></li>
                <li><a target="_blank" href="{{ route('report.rup') }}">Data RUP</a></li>
                <li><a href="#">Data Vendor</a></li>
                <li><a href="#">Summary Report</a></li>
            </ul>
        </li>
        <li><a href="{{ route('report') }}" class="active">GRAFIK REPORT</a></li>
      </ul>
    </div>
  </div>
</div>

<div class="w-full md:w-4/5 px-3 md:px-0 flex justify-end items-center mx-auto mt-2">
 <p class="text-sm">{{ Auth::user()->name }} (<a href="{{ route('logout') }}" class="color-primary underline italic">Logout</a>)</p>
</div>

<div class="w-full md:w-4/5 px-3 md:px-0 mx-auto block md:flex justify-center mt-3">
  <a href="{{ route('tender.list') }}" class="block mb-1 md:mb-0 bg-blue-600 text-white py-2 px-3 rounded mr-2">Tender <span class="bg-white rounded-full text-blue-600 text-sm px-1 py-2">{{ getTenderCount() }}</span></a>
  <a href="{{ route('non-tender.list') }}" class="block mb-1 md:mb-0 bg-blue-600 text-white py-2 px-3 rounded mr-2">Non Tender <span class="bg-white rounded-full text-blue-600 text-sm px-1 py-2">{{ getNonTenderCount() }}</span></a>
  <a href="#" class="block mb-1 md:mb-0 bg-yellow-300 text-black py-2 px-3 rounded mr-2">Total BeLa <span class="bg-black rounded-full text-yellow-300 text-sm px-1 py-2">0</span></a>
  <a href="https://sirup.lkpp.go.id/sirup/ro/rekap/klpd/D264" class="block mb-1 md:mb-0 bg-yellow-300 text-black py-2 px-3 rounded mr-2">Satker <span class="bg-black rounded-full text-yellow-300 text-sm px-1 py-2">48</span></a>
</div>