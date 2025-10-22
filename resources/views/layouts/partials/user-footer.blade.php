
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIBaJA Provinsi Lampung</title>

    <!-- Fonts & CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Font Awesome CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <link href="{{ asset('css/sibaja.css') }}" rel="stylesheet">
    
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Public Sans', sans-serif;
            background-color: #ffffff;
        }
    </style>
    @stack('head')


<!-- FOOTER -->

<!-- INFORMASI KANTOR + JAM -->
<div style="background-color: #1b2141; color: white; padding: 50px 0 30px 0;">
  <div class="container d-flex flex-column flex-md-row justify-content-between align-items-start">
    <!-- Info Kontak -->
    <div class="mb-4 mb-md-0">
      <h5 class="fw-bold text-white mb-3">Kantor Kami</h5>
      <p class="mb-1"><i class="bi bi-geo-alt-fill me-2"></i> Alamat: Jl. Wolter Monginsidi No.69, Talang, Kec. Telukbetung Selatan, Kota Bandar Lampung, Lampung 35221</p>
      <p class="mb-1"><i class="bi bi-telephone-fill me-2"></i> Telepon: (0721) 481107</p>
      <p class="mb-1"><i class="bi bi-envelope-fill me-2"></i> Email: biropbj@lampungprov.go.id</p>
      <div class="d-flex gap-3 mt-3">
        <a href="#" class="text-white fs-4"><i class="bi bi-facebook"></i></a>
        <a href="#" class="text-white fs-4"><i class="bi bi-youtube"></i></a>
        <a href="https://www.instagram.com/biropbj?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" class="text-white fs-4"><i class="bi bi-instagram"></i></a>

      </div>
    </div>

    <!-- Jam Realtime -->
    <div class="d-flex gap-3">
      <div class="bg-primary text-center rounded p-3 shadow" style="min-width: 100px; background-color: #0F2C74 !important;">
        <div id="jam-box" class="fw-bold fs-3">00</div>
        <div class="text-uppercase mt-1" style="font-size: 14px;">JAM</div>
      </div>
      <div class="bg-primary text-center rounded p-3 shadow" style="min-width: 100px; background-color: #0F2C74 !important;">
        <div id="menit-box" class="fw-bold fs-3">00</div>
        <div class="text-uppercase mt-1" style="font-size: 14px;">MENIT</div>
      </div>
      <div class="bg-primary text-center rounded p-3 shadow" style="min-width: 100px; background-color: #0F2C74 !important;">
        <div id="detik-box" class="fw-bold fs-3">00</div>
        <div class="text-uppercase mt-1" style="font-size: 14px;">DETIK</div>
      </div>
    </div>
  </div>
</div>


<footer class="text-center p-2 mt-0" style="background-color: #2b3e64; color: white;">
    <p class="mb-0">© {{ date('Y') }} Biro Pengadaan Barang dan Jasa Provinsi Lampung</p>
</footer>



<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

<script>
  function updateClock() {
    const now = new Date();
    const jam = now.getHours().toString().padStart(2, '0');
    const menit = now.getMinutes().toString().padStart(2, '0');
    const detik = now.getSeconds().toString().padStart(2, '0');

    document.getElementById('jam-box').innerText = jam;
    document.getElementById('menit-box').innerText = menit;
    document.getElementById('detik-box').innerText = detik;
  }

  setInterval(updateClock, 1000);
  updateClock(); // panggil langsung saat halaman load
</script>

@stack('scripts')