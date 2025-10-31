@extends('layouts.adminlte')

@section('title', 'SiBAJA ' . $vendor->nama_penyedia)

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Vendor</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">Vendor</li>
          <li class="breadcrumb-item active">{{ $vendor->nama_penyedia }}</li>
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
            <h3 class="card-title">#{{ $vendor->kd_penyedia }}</h3>
          </div>
          <div class="card-body">
            @if ( Auth::user()->role_id == 1 )
              <form id="update" action="{{ route('vendor.update', ['code' => $vendor->kd_penyedia]) }}" method="post">
                @csrf
              </form>
            @endif
            <table class="table align-items-center">
              <tr>
                <td style="width: 100px;">Nama</td>
                <td>: {{ $vendor->nama_penyedia }}</td>
              </tr>
              <tr>
                <td style="width: 100px;">Nama Pimpinan</td>
                <td>: 
                    @if ( Auth::user()->role_id == 1 )
                    <input class="form-control d-inline w-50" form="update" name="director" value="{{ $vendor->director }}" />
                    @else
                    <span>{{ $vendor->director }}</span>
                    @endif
                </td>
              </tr>
              <tr>
                <td style="width: 100px;">Kemampuan Keuangan</td>
                <td>:
                    @if ( Auth::user()->role_id == 1 )
                    <input class="form-control d-inline w-50" form="update" name="financial_ability" value="{{ $vendor->financial_ability }}" /> Rp{{ moneyFormat($vendor->financial_ability) }}
                    @else
                    <span>Rp{{ moneyFormat($vendor->financial_ability) }}</span>
                    @endif 
                </td>
              </tr>
              <tr>
                <td style="width: 100px;">Evaluasi Hasil Kerja</td>
                <td> <span style="visibility: hidden;">:</span>
                    @if ( Auth::user()->role_id == 1 )
                    <textarea name="evaluation" form="update" id="evaluation" class="form-control d-inline w-50">{{ $vendor->evaluation }}</textarea>
                    @else
                    <span>{{ $vendor->evaluation }}</span>
                    @endif 
                </td>
              </tr>
              <tr>
                <td style="width: 100px;">Alamat</td>
                <td><span style="visibility: hidden;">:</span>
                    @if ( Auth::user()->role_id == 1 )
                    <textarea name="address" form="update" id="address" class="form-control d-inline w-50">{{ $vendor->address }}</textarea>
                    @else
                    <span>{{ $vendor->address }}</span>
                    @endif
                </td>
              </tr>
              <tr>
                <td style="width: 100px;">Kapasitas/Kemampuan SDM</td>
                <td>
                  <table class="table">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>Pendidikan</th>
                        <th>Jumlah</th>
                        @if ( Auth::user()->role_id == 1 )
                        <th>Aksi</th>    
                        @endif
                      </tr>
                      <tr>
                        @if ( $vendor->educations()->count() )
                        @foreach ($vendor->educations as $item)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->amount }}</td>
                            @if ( Auth::user()->role_id == 1 )
                            <th></th>    
                            @endif
                          </tr>
                        @endforeach
                        @else
                        <td @if( Auth::user()->role_id == 1 ) colspan="4" @else colspan="3" @endif class="text-center" >
                        Belum Ada Data
                        </td>
                        @endif
                      </tr>
                    </thead>
                  </table>
                  @if ( Auth::user()->role_id == 1 )
                  <button class="btn btn-sm bg-success">Tambah Kemampuan/Kapasitas SDM</button>
                  @endif
                </td>
              </tr>
              <tr>
                <td style="width: 100px;">Kapasitas Teknis Sarana Prasarana</td>
                <td>
                  <table class="table">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        @if ( Auth::user()->role_id == 1 )
                        <th>Aksi</th>    
                        @endif
                      </tr>
                      <tr>
                        @if ( $vendor->skills()->count() )
                        @foreach ($vendor->skills as $item)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            @if ( Auth::user()->role_id == 1 )
                            <th></th>    
                            @endif
                          </tr>
                        @endforeach
                        @else
                        <td @if( Auth::user()->role_id == 1 ) colspan="3" @else colspan="2" @endif class="text-center" >
                        Belum Ada Data
                        </td>
                        @endif
                      </tr>
                    </thead>
                  </table>
                  @if ( Auth::user()->role_id == 1 )
                  <button class="btn btn-sm bg-success">Tambah Kemampuan Teknis Sarana Prasarana</button>
                  @endif
                </td>
              </tr>
              <tr>
                <td style="width: 100px;">Pekerjaan</td>
                <td>
                  <table class="table">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>Tipe Paket</th>
                        <th>Kode Paket</th>
                        <th>Nama Paket</th>
                      </tr>
                      <tr>
                        @if ( $vendor->tenders()->count() + $vendor->nonTenders()->count() )
                        @php
                        $num = 1;                        
                        @endphp
                        @foreach ($vendor->tenders as $item)
                          <tr>
                            <td>{{ $num }}</td>
                            <td>Tender</td>
                            <td>{{ $item->kd_tender }}</td>
                            <td><a href="{{ route('tender.show', ['code' => $item->kd_tender]) }}" target="_blank">{{ $item->nama_paket }}</a></td>
                          </tr>
                        @php
                        $num++;
                        @endphp
                        @endforeach
                        @foreach ($vendor->nonTenders as $item)
                          <tr>
                            <td>{{ $num }}</td>
                            <td>Non Tender</td>
                            <td>{{ $item->kd_nontender }}</td>
                            <td><a href="{{ route('non-tender.show', ['code' => $item->kd_nontender]) }}" target="_blank">{{ $item->nama_paket }}</a></td>
                          </tr>
                        @php
                        $num++;
                        @endphp
                        @endforeach
                        @else
                        <td colspan="4" class="text-center" >
                        Belum Ada Data
                        </td>
                        @endif
                      </tr>
                    </thead>
                  </table>
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
