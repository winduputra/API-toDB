@extends('layouts.adminlte')

@section('title', 'SiBAJA ' . $tender->nama_paket)

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Tender</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">Tender</li>
          <li class="breadcrumb-item active">{{ $tender->nama_paket }}</li>
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
            <h3 class="card-title">Paket #{{ $tender->kd_tender }}</h3>
          </div>
          <div class="card-body">
            @if ( Auth::user()->role_id == 1 )
              <form id="update" action="{{ route('tender.update', ['code' => $tender->kd_tender]) }}" method="post">
                @csrf
              </form>
            @endif
            <table class="table align-items-center">
              <tr>
                <td>Nama Paket</td>
                <td>: {{ $tender->nama_paket }}</td>
              </tr>
              <tr>
                <td>Unit</td>
                <td>: {{ $tender->nama_klpd }}</td>
              </tr>
              <tr>
                <td>Pagu</td>
                <td>: Rp{{ moneyFormat($tender->pagu) }}</td>
              </tr>
              <tr>
                <td>Metode</td>
                <td>: {{ $tender->jenis_pengadaan }}</td>
              </tr>
              <tr>
                <td>Lokasi</td>
                <td>: {{ $tender->lokasi_pekerjaan }}</td>
              </tr>
              <tr>
                <td>Tanggal</td>
                <td>: </td>
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
                            @foreach ($tender->schedules as $key => $item)
                            <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td class="w-50">{{ $item->tahapan }}</td>
                            <td class="text-center">{{ $item->tanggal_awal }}</td>
                            <td class="text-center">{{ $item->tanggal_akhir }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
              </tr>
              <tr>
                <td>Peserta</td>
                <td>
                    <table class="table">
                    <thead>
                        <tr>
                        <th style="width: 15px;">No.</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">NPWP</th>
                        <th class="text-center">Nilai Penawaran</th>
                        <th class="text-center">Nilai Terkoreksi</th>
                        <th class="text-center">Pemenang</th>
                        <th class="text-center">Pemenang Terverifikasi</th>
                        <th class="text-center">Alasan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tender->participants as $key => $item)
                        <tr @if ($item->pemenang) class="bg-success" @endif >
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
              <tr>
                <td>Pelaksanaan</td>
                <td>: 
                @if ( Auth::user()->role_id == 1 )
                  <input class="form-control d-inline w-50" form="update" name="implementation" value="{{ $tender->implementation }}" />
                @else
                  <span>{{ $tender->implementation }}</span>
                @endif
                </td>
              </tr>
              <tr>
                <td>No. Surat/Tanggal (RPP)</td>
                <td>: 
                @if ( Auth::user()->role_id == 1 )
                  <input class="form-control d-inline w-50" form="update" name="letter_number" value="{{ $tender->letter_number }}" />
                @else
                  <span>{{ $tender->letter_number }}</span>
                @endif
                </td>
              </tr>
              <tr>
                <td>No. Berita Acara</td>
                <td>: 
                @if ( Auth::user()->role_id == 1 )
                  <input class="form-control d-inline w-50" form="update" name="news_number" value="{{ $tender->news_number }}" />
                @else
                  <span>{{ $tender->news_number }}</span>
                @endif
                </td>
              </tr>
              <tr>
                <td>Keterangan</td>
                <td>: 
                @if ( Auth::user()->role_id == 1 )
                  <input class="form-control d-inline w-50" form="update" name="note" value="{{ $tender->note }}" />
                @else
                  <span>{{ $tender->note }}</span>
                @endif
                </td>
              </tr>
            </table>
          </div>
          @if ( Auth::user()->role_id == 1 )
          <div class="card-footer">
            <div class="d-flex justify-content-end">
              <button class="btn btn-sm bg-success" type="submit" form="update">Simpan</button>
            </div>
          </div>    
          @endif
        </div>

      </div>
    </div>
  </div>
</section>
@endsection
