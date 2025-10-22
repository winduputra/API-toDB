<div class="w-full bg-black text-white">
  <div class="md:w-4/5 px-3 md:px-0 mx-auto flex justify-between flex-col md:flex-row py-3">
    <div class="w-full">
      <a href="#" class="underline" class="text-sm">Tentang SiBAJA</a>
      <p class="text-sm">{{ getIndonesianDate(date('Y-m-d')) }} <span id="time">00:00:00</span> WIB</p>
      <p class="text-sm"><a href="#" class="underline">SiBAJA v0.1.1</a></p>
    </div>
    <div class="w-full mt-5 md:mt-0">
      <p class="text-sm text-left md:text-right"> <span>&copy; {{ date('Y') }} </span> | <a href="https://bpbjprovlampung.id/" class="underline" target="_blank">Biro Pengadaan Barang dan Jasa Provinsi Lampung</a></p>
    </div>
  </div>
  
</div>
<div class="w-full bg-black border-t border-blue-500">
  <div class="md:w-4/5 px-3 md:px-0 mx-auto flex justify-between flex-col md:flex-row py-3">
    <p class="text-white text-center md:text-left text-sm">Server Status: <span class="text-green-500">Good</span> </p>
  </div>
</div>

<script>
const today = new Date("{{ getCurrentDateTime() }}");

function startTime() {
  today.setSeconds(today.getSeconds() + 1)
  let h = today.getHours()
  let m = today.getMinutes()
  let s = today.getSeconds()
  h = checkTime(h)
  m = checkTime(m)
  s = checkTime(s)
  document.getElementById('time').innerHTML =  h + ":" + m + ":" + s
  setTimeout(startTime, 1000)
}

function checkTime(i) {
  if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
  return i;
}

startTime()
</script>