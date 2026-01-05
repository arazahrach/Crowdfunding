<footer class="mt-16 bg-[#228A85] text-white">
  {{-- CONTENT --}}
  <div class="max-w-7xl mx-auto px-6 py-10">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">

      {{-- Brand + desc + icons --}}
      <div>
        <h3 class="text-lg font-semibold">GandengTangan</h3>
        <p class="mt-3 text-sm leading-relaxed text-white/90 max-w-md">
          Platform Donasi Pendidikan Indonesia.
          Menyambungkan para penggalang dana pendidikan dengan donatur
          untuk membantu fasilitas sekolah, beasiswa siswa, dan kebutuhan belajar lainnya.
        </p>

        <div class="mt-5 flex items-center gap-4 text-white/90">
          {{-- icons simple (tanpa library) --}}
          <a href="#" class="hover:text-white" aria-label="Instagram">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
              <path d="M7 2C4.2 2 2 4.2 2 7v10c0 2.8 2.2 5 5 5h10c2.8 0 5-2.2 5-5V7c0-2.8-2.2-5-5-5H7zm10 2c1.7 0 3 1.3 3 3v10c0 1.7-1.3 3-3 3H7c-1.7 0-3-1.3-3-3V7c0-1.7 1.3-3 3-3h10zm-5 3.5A4.5 4.5 0 1 0 16.5 12 4.5 4.5 0 0 0 12 7.5zm0 7.4A2.9 2.9 0 1 1 14.9 12 2.9 2.9 0 0 1 12 14.9zM17.8 6.2a1 1 0 1 0 1 1 1 1 0 0 0-1-1z"/>
            </svg>
          </a>

          <a href="#" class="hover:text-white" aria-label="Email">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
              <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4-8 5-8-5V6l8 5 8-5v2z"/>
            </svg>
          </a>

          <a href="#" class="hover:text-white" aria-label="WhatsApp">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
              <path d="M12 2a10 10 0 0 0-8.7 14.9L2 22l5.2-1.3A10 10 0 1 0 12 2zm0 18a8 8 0 0 1-4.1-1.1l-.3-.2-3.1.8.8-3-.2-.3A8 8 0 1 1 12 20zm4.4-5.8c-.2-.1-1.3-.6-1.5-.7s-.3-.1-.5.1-.6.7-.7.8-.2.2-.4.1a6.6 6.6 0 0 1-1.9-1.2 7.2 7.2 0 0 1-1.3-1.6c-.1-.2 0-.3.1-.4l.3-.3.2-.3c.1-.1.1-.2.2-.3s0-.2 0-.3-.5-1.2-.7-1.6c-.2-.4-.3-.3-.5-.3h-.4c-.1 0-.3.1-.4.2s-.6.6-.6 1.5.6 1.8.7 2 .1.3.2.5a8.2 8.2 0 0 0 3.2 3.1c.4.2.8.4 1 .5.4.1.7.1 1 .1.3 0 .9-.4 1-.7s.1-.6.1-.7-.1-.1-.2-.2z"/>
            </svg>
          </a>
        </div>
      </div>

      {{-- Tentang --}}
      <div class="md:justify-self-center">
        <h3 class="text-lg font-semibold">Tentang</h3>
        <ul class="mt-3 text-sm space-y-2 text-white/90">
          <li>
            <a class="hover:text-white" href="{{ route('about') }}">Tentang Kami</a>
          </li>
          <li>
            <a class="hover:text-white" href="#">Cara Kerja</a>
          </li>
          <li>
            <a class="hover:text-white" href="#">Syarat &amp; Ketentuan</a>
          </li>
          <li>
            <a class="hover:text-white" href="#">Kebijakan Privasi</a>
          </li>
        </ul>
      </div>

      {{-- Ikuti kami --}}
      <div class="md:justify-self-end">
        <h3 class="text-lg font-semibold">Ikuti Kami</h3>
        <ul class="mt-3 text-sm space-y-2 text-white/90">
          <li><a class="hover:text-white" href="#">Instagram</a></li>
          <li><a class="hover:text-white" href="#">LinkedIn</a></li>
          <li><a class="hover:text-white" href="#">Website</a></li>
        </ul>
      </div>

    </div>
  </div>

  {{-- COPYRIGHT BAR --}}
  <div class="bg-[#1c6f6a]">
    <div class="max-w-7xl mx-auto px-6 py-3 text-xs text-white/90 text-center">
      © 2026 GandengTangan. Semua Hak Dilindungi.
    </div>
  </div>

  </div>
</footer>
