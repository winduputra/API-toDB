@forelse ($data as $item)
  <tr>
    <td><p class="text-sm">{{ $item->kd_tender }}</p></td>
    <td><p class="text-sm" style="color: #3B82F6;">{{ $item->nama_paket }}</p></td>
    <td><p class="text-sm">{{ $item->status_tender ?? '-' }}</p></td>
    <td><p class="text-sm">
      {{ isset($item->hps) ? format_hps_pagu($item->hps) : '-' }}
    </p></td>
    <td><p class="text-sm">
      {{ isset($item->nilai_pdn_kontrak) ? \App\Services\HelperService::moneyFormat($item->nilai_pdn_kontrak) : '-' }}
    </p></td>
    <td><p class="text-sm">
      {{ isset($item->nilai_umk_kontrak) ? \App\Services\HelperService::moneyFormat($item->nilai_umk_kontrak) : '-' }}
    </p></td>
  </tr>
@empty
  <tr>
    <td colspan="7" class="text-center">Tidak ada data ditemukan</td>
  </tr>
@endforelse
