@extends('layouts.adminlte')

@section('title', 'SiBAJA ' . $nonTender->nama_paket)

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Non Tender</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">Non Tender</li>
          <li class="breadcrumb-item active">{{ $nonTender->nama_paket }}</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    @include('components.summary')

    <div class="row mt-3">
      <div class="col-12">

        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Paket #{{ $nonTender->kd_nontender }}</h3>
          </div>
          <div class="card-body">
            <table class="table">
              <tr>
                <td>Nama Paket</td>
                <td>: {{ $nonTender->nama_paket }}</td>
              </tr>
              <tr>
                <td>Unit</td>
                <td>: {{ $nonTender->nama_klpd }}</td>
              </tr>
              <tr>
                <td>Pagu</td>
              <td>: Rp{{ moneyFormat( $nonTender->pagu ) }}</td>
              </tr>
              <tr>
                <td>Metode</td>
                <td>: {{ $nonTender->metode_pengadaan }}</td>
              </tr>
              <tr>
                <td>Lokasi</td>
                <td>: {{ $nonTender->lokasi_pekerjaan }}</td>
              </tr>
              <tr>
                <td>Tanggal</td>
                <td>: {{ $data->tanggal_buat_paket }} s/d {{ substr($data->tanggal_selesai_nontender, 0, 10) }}</td>
              </tr>
              <tr>
                <td>Tahap</td>
                <td>
                    <table class="w-full divide-y border">
                        <thead>
                            <tr>
                            <th style="width: 15px;">No.</th>
                            <th class="w-50">Nama Tahapan</th>
                            <th class="text-center">Tanggal Awal</th>
                            <th class="text-center">Tanggal Akhir</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach ($nonTender->schedules as $key => $item)
                            <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td class="w-50">{{ $item->nama_tahapan }}</td>
                            <td class="text-center">{{ $item->tanggal_awal }}</td>
                            <td class="text-center">{{ $item->tanggal_akhir }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
              </tr>
            </table>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
@endsection
