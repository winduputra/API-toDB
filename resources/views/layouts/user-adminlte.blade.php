@extends('layouts.adminlte')

@section('hideSidebar', 'true')

@section('navbar')
  @include('layouts.partials.user-navbar')
  @yield('navbar-extra')
@endsection

@section('footer')
  @include('layouts.partials.user-footer')
@endsection

@section('content')
  <div class="container">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">Buka Filter</button>
  </div>
@endsection

@section('modals')
{{-- Modal Filter Non Tender --}}
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Download Realisasi Non Tender</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

      </div>
      <div class="modal-body">
        <label for="nonYear">Tahun:</label>
        <select name="nonYear" id="nonYear" class="form-control">
          @foreach ($nonTenderYears as $year)
            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
          @endforeach
        </select>

        <label for="month">Bulan:</label>
        <select id="month" class="form-control">
          <option value="ALL">KESELURUHAN</option>
          @foreach (range(1, 12) as $month)
            <option value="{{ $month }}">{{ strtoupper(getMonthName($month)) }}</option>
          @endforeach
        </select>

        <label for="day" id="dayLabel" style="display: none;">Tanggal:</label>
        <select id="day" class="form-control" style="display: none;">
          <option value="ALL">KESELURUHAN</option>
        </select>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" id="viewButton">Lihat</button>
        <button class="btn btn-success" id="downloadButton">Download</button>
      </div>
    </div>
  </div>
</div>

{{-- Modal Filter Tender --}}
<div class="modal fade" id="filterTenderModal" tabindex="-1" aria-labelledby="filterTenderModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Download Realisasi Tender</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

      </div>
      <div class="modal-body">
        <label for="tenderYear">Tahun:</label>
        <select name="tenderYear" id="tenderYear" class="form-control">
          @foreach ($tenderYears as $year)
            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
          @endforeach
        </select>

        <label for="tenderMonth">Bulan:</label>
        <select id="tenderMonth" class="form-control">
          <option value="ALL">KESELURUHAN</option>
          @foreach (range(1, 12) as $month)
            <option value="{{ $month }}">{{ strtoupper(getMonthName($month)) }}</option>
          @endforeach
        </select>

        <label for="tenderDay" id="tenderDayLabel" style="display: none;">Tanggal:</label>
        <select id="tenderDay" class="form-control" style="display: none;">
          <option value="ALL">KESELURUHAN</option>
        </select>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" id="viewTenderButton">Lihat</button>
        <button class="btn btn-success" id="downloadTenderButton">Download</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<!-- JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>AOS.init();</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  // === NON-TENDER ===
  const nonYear = document.getElementById('nonYear');
  const nonMonth = document.getElementById('month');
  const nonDay = document.getElementById('day');
  const nonDayLabel = document.getElementById('dayLabel');

  nonMonth.value = 'ALL';
  nonDayLabel.style.display = 'none';
  nonDay.style.display = 'none';

  function updateNonTenderDays() {
    const year = parseInt(nonYear.value);
    const month = parseInt(nonMonth.value);

    if (!isNaN(year) && !isNaN(month)) {
      const daysInMonth = new Date(year, month, 0).getDate();
      nonDay.innerHTML = '<option value="ALL">KESELURUHAN</option>';
      for (let i = 1; i <= daysInMonth; i++) {
        const opt = document.createElement('option');
        opt.value = i;
        opt.textContent = i;
        nonDay.appendChild(opt);
      }
      nonDayLabel.style.display = 'block';
      nonDay.style.display = 'block';
    }
  }

  nonMonth.addEventListener('change', function () {
    if (this.value !== 'ALL') {
      updateNonTenderDays();
    } else {
      nonDay.innerHTML = '<option value="ALL">KESELURUHAN</option>';
      nonDayLabel.style.display = 'none';
      nonDay.style.display = 'none';
    }
  });

  nonYear.addEventListener('change', function () {
    if (nonMonth.value !== 'ALL') {
      updateNonTenderDays();
    }
  });

  document.getElementById('viewButton').addEventListener('click', function () {
    const query = `?year=${nonYear.value}&month=${nonMonth.value}&day=${nonDay.value}`;
    window.open(`/non-tender/view-pdf${query}`, '_blank');
  });

  document.getElementById('downloadButton').addEventListener('click', function () {
    const query = `?year=${nonYear.value}&month=${nonMonth.value}&day=${nonDay.value}`;
    window.location.href = `/non-tender/download-pdf${query}`;
  });

  // === TENDER ===
  const tenderYear = document.getElementById('tenderYear');
  const tenderMonth = document.getElementById('tenderMonth');
  const tenderDay = document.getElementById('tenderDay');
  const tenderDayLabel = document.getElementById('tenderDayLabel');

  tenderMonth.value = 'ALL';
  tenderDayLabel.style.display = 'none';
  tenderDay.style.display = 'none';

  function updateTenderDays() {
    const year = parseInt(tenderYear.value);
    const month = parseInt(tenderMonth.value);

    if (!isNaN(year) && !isNaN(month)) {
      const daysInMonth = new Date(year, month, 0).getDate();
      tenderDay.innerHTML = '<option value="ALL">KESELURUHAN</option>';
      for (let i = 1; i <= daysInMonth; i++) {
        const opt = document.createElement('option');
        opt.value = i;
        opt.textContent = i;
        tenderDay.appendChild(opt);
      }
      tenderDayLabel.style.display = 'block';
      tenderDay.style.display = 'block';
    }
  }

  tenderMonth.addEventListener('change', function () {
    if (this.value !== 'ALL') {
      updateTenderDays();
    } else {
      tenderDay.innerHTML = '<option value="ALL">KESELURUHAN</option>';
      tenderDayLabel.style.display = 'none';
      tenderDay.style.display = 'none';
    }
  });

  tenderYear.addEventListener('change', function () {
    if (tenderMonth.value !== 'ALL') {
      updateTenderDays();
    }
  });

  document.getElementById('viewTenderButton').addEventListener('click', function () {
    const query = `?year=${tenderYear.value}&month=${tenderMonth.value}&day=${tenderDay.value}`;
    window.open(`/tender/view-pdf${query}`, '_blank');
  });

  document.getElementById('downloadTenderButton').addEventListener('click', function () {
    const query = `?year=${tenderYear.value}&month=${tenderMonth.value}&day=${tenderDay.value}`;
    window.location.href = `/tender/download-pdf${query}`;
  });
});
</script>
@endsection
