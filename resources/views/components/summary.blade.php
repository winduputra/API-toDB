@php
  $filters = [
    'year' => request('year'),
    'kd_satker' => request('kd_satker'),
    'code' => request('code'),
    'name' => request('name'),
    'category' => request('category'),
    'status_tender' => request('status_tender'),
    'status_nontender' => request('status_nontender'),
  ];
@endphp

<div class="row">
  {{-- Tender --}}
  <div class="col-lg-3 col-md-6">
    <div class="small-box bg-info">
      <div class="inner">
        <h3>{{ number_format(getTenderCount($filters), 0, ',', '.') }}</h3>
        <p>Tender</p>
      </div>
      <div class="icon">
        <i class="ion ion-pie-graph"></i>
      </div>
      <a href="{{ route('tender.list') }}" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>

  {{-- Non Tender --}}
  <div class="col-lg-3 col-md-6">
    <div class="small-box bg-warning">
      <div class="inner">
        <h3>{{ number_format(getNonTenderCount($filters), 0, ',', '.') }}</h3>
        <p>Non Tender</p>
      </div>
      <div class="icon">
        <i class="ion ion-pie-graph"></i>
      </div>
      <a href="{{ route('non-tender.list') }}" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>

  {{-- e-Katalog --}}
  <div class="col-lg-3 col-md-6">
    <div class="small-box bg-success">
      <div class="inner">
        <h3>{{ number_format(getEkatalogCount($filters), 0, ',', '.') }}</h3>
        <p>e-Katalog</p>
      </div>
      <div class="icon">
        <i class="ion ion-pie-graph"></i>
      </div>
      <a href="{{ route('report.ekatalog') }}" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>

  {{-- Toko Daring --}}
  <div class="col-lg-3 col-md-6">
    <div class="small-box bg-danger">
      <div class="inner">
        <h3>{{ number_format(getBelaCount($filters), 0, ',', '.') }}</h3>
        <p>Toko Daring</p>
      </div>
      <div class="icon">
        <i class="ion ion-pie-graph"></i>
      </div>
      <a href="{{ route('report.tokodaring') }}" class="small-box-footer">
        Lihat <i class="fas fa-arrow-circle-right"></i>
      </a>
      @if (Auth::user()->role_id == 1)
        <a href="{{ route('bela.update') }}" class="small-box-footer text-warning">
          Update Data
        </a>
      @endif
    </div>
  </div>
</div>
