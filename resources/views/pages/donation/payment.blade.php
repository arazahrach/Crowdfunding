@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#F6F2E8]">
  <div class="max-w-md mx-auto px-4 py-10">
    <div class="rounded-2xl bg-white border border-slate-200 p-6 text-center">
      <h1 class="text-lg font-bold text-slate-800">Lanjut Pembayaran</h1>
      <p class="mt-2 text-sm text-slate-600">
        Kamu akan diarahkan ke pembayaran Midtrans untuk donasi:
        <span class="font-semibold">{{ $campaign->title }}</span>
      </p>

      <div class="mt-4 text-slate-800 font-semibold">
        Rp {{ number_format($donation->amount, 0, ',', '.') }}
      </div>

      <button id="pay-button"
              class="mt-6 w-full rounded-xl bg-teal-700 px-4 py-3 text-sm font-semibold text-white hover:bg-teal-800">
        Bayar Sekarang
      </button>

      <a href="{{ route('donation.show', $campaign->slug) }}"
         class="mt-3 inline-block text-sm font-semibold text-slate-600 hover:underline">
        Kembali ke Detail
      </a>
    </div>
  </div>
</div>

{{-- Midtrans Snap --}}
<script
  src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
  data-client-key="{{ config('midtrans.client_key') }}">
</script>

<script>
document.getElementById('pay-button').addEventListener('click', function () {
  window.snap.pay("{{ $donation->snap_token }}", {
    onSuccess: function(result){
      window.location.href = "{{ route('donation.show', $campaign->slug) }}";
    },
    onPending: function(result){
      window.location.href = "{{ route('donation.show', $campaign->slug) }}";
    },
    onError: function(result){
      alert("Pembayaran gagal. Coba lagi.");
    },
    onClose: function(){
      // user menutup popup
    }
  });
});
</script>

@endsection
