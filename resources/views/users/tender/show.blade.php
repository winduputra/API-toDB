@extends('layouts.tailwind')

@section('content')
  @include('components.header')

  <div class="w-full md:w-4/5 px-3 md:px-0 mx-auto mt-3">
    <ul class="breadcrumbs">
      <li><a href="{{ $url }}">Daftar Non Tender</a></li>
      <li class="active">{{ $data->nama_paket }}</li>
    </ul>
  </div>
  
  <div class="w-full md:w-4/5 px-0 mx-auto block md:flex justify-between items-end mt-2 border rounded-md ">
    <div class="w-full">

      <p class="text-lg bg-gray-100 rounded-t-md px-3 py-2">{{ $data->nama_paket }}</p>

      <div class="my-3"></div>

      <table class="max-w-100">
        <tbody class="">
          <tr>
            <td class="px-3 py-2 "><p>Nama Paket</p></td>
            <td class="px-3 py-2 "><p>: {{ $data->nama_paket }} </p></td>
          </tr>
          <tr>
            <td class="px-3 py-2 "><p>Unit</p></td>
            <td class="px-3 py-2 "><p>: {{ $data->nama_klpd }} </p></td>
          </tr>
          <tr>
            <td class="px-3 py-2 "><p>Pagu</p></td>
            <td class="px-3 py-2 "><p>: Rp{{ $data->pagu }}</p></td>
          </tr>
          <tr>
            <td class="px-3 py-2 "><p>Tahap</p></td>
            <td class="px-3 py-2 ">
              <div class="overflow-hidden">
                <table class="w-full divide-y border">
                  <thead>
                    <tr class="divide-x">
                      <th style="width: 15px;">No.</th>
                      <th class="w-1/3">Nama Tahapan</th>
                      <th>Tanggal Awal</th>
                      <th>Tanggal Akhir</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y">
                    @foreach ($data->schedules as $key => $item)
                    <tr class="divide-x">
                      <td class="text-center">{{ $key + 1 }}</td>
                      <td class="w-1/3">{{ $item->tahapan }}</td>
                      <td class="text-center">{{ $item->tanggal_awal }}</td>
                      <td class="text-center">{{ $item->tanggal_akhir }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </td>
          </tr> 
          <tr>
            <td class="px-3 py-2 "><p>Tanggal</p></td>
            <td class="px-3 py-2 "><p>: {{ $data->tanggal_buat_paket }} s/d {{ substr($data->tanggal_selesai_nontender, 0, 10) }} </p></td>
          </tr>
          <tr>
            <td class="px-3 py-2 "><p>Metode</p></td>
            <td class="px-3 py-2 "><p>: {{ $data->jenis_pengadaan }} </p></td>
          </tr>
          <tr>
            <td class="px-3 py-2 "><p>Lokasi</p></td>
            <td class="px-3 py-2 "><p>: {{ $data->lokasi_pekerjaan }} </p></td>
          </tr>
          <tr>
            <td class="px-3 py-2 "><p>Peserta</p></td>
            <td class="px-3 py-2 max-w-10 overflow-auto">
              <table class="min-w-full divide-y border">
                <thead>
                  <tr class="divide-x">
                    <th style="width: 15px;">No.</th>
                    <th>Nama</th>
                    <th>NPWP</th>
                    <th>Nilai Penawaran</th>
                    <th>Nilai Terkoreksi</th>
                    <th>Pemenang</th>
                    <th>Pemenang Terverifikasi</th>
                    <th>Alasan</th>
                  </tr>
                </thead>
                <tbody class="divide-y">
                  @foreach ($data->participants as $key => $item)
                  <tr class="divide-x">
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td class="text-center">{{ $item->nama_penyedia }}</td>
                    <td class="text-center">{{ $item->npwp_penyedia }}</td>
                    <td class="text-center">{{ moneyFormat($item->nilai_penawaran) }}</td>
                    <td class="text-center">{{ moneyFormat($item->nilai_terkoreksi) }}</td>
                    <td class="text-center">{{ $item->pemenang }}</td>
                    <td class="text-center">{{ $item->pemenang_terverifikasi }}</td>
                    <td class="text-center">{{ $item->alasan }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </td>
          </tr>
        </tbody>
      </table>

      <div class="mb-5"></div>
    </div>
  </div>

  @include('components.footer')
  
@endsection