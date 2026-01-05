@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#F6F2E8]">
  <div class="max-w-5xl mx-auto px-4 py-8">

    <div class="flex items-center justify-between gap-3">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">Kategori</h1>
        <p class="mt-1 text-sm text-slate-500">Master data kategori untuk campaign.</p>
      </div>

      <a href="{{ route('admin.categories.create') }}"
         class="rounded-xl bg-teal-700 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-800">
        + Tambah Kategori
      </a>
    </div>

    @if(session('success'))
      <div class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
        {{ session('success') }}
      </div>
    @endif

    @if($errors->has('delete'))
      <div class="mt-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
        {{ $errors->first('delete') }}
      </div>
    @endif

    <form method="GET" class="mt-4">
      <input name="q" value="{{ $q ?? '' }}" placeholder="Cari kategori (nama/slug/icon)..."
             class="w-full md:w-96 rounded-xl border border-slate-200 px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-200">
    </form>

    <div class="mt-4 overflow-hidden rounded-2xl border border-slate-200 bg-white">
      <table class="w-full text-sm">
        <thead class="bg-slate-50">
          <tr class="text-left text-slate-600">
            <th class="px-4 py-3">Icon</th>
            <th class="px-4 py-3">Nama</th>
            <th class="px-4 py-3">Slug</th>
            <th class="px-4 py-3 w-48">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($categories as $cat)
            <tr class="border-t border-slate-100">
              <td class="px-4 py-3 text-lg">{{ $cat->icon ?? '—' }}</td>
              <td class="px-4 py-3 font-semibold text-slate-800">{{ $cat->name }}</td>
              <td class="px-4 py-3 text-slate-600">{{ $cat->slug }}</td>
              <td class="px-4 py-3">
                <div class="flex items-center gap-2">
                  <a href="{{ route('admin.categories.edit', $cat) }}"
                     class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                    Edit
                  </a>

                  <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}"
                        onsubmit="return confirm('Hapus kategori ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-100">
                      Hapus
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="px-4 py-6 text-slate-500">Belum ada kategori.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-4">
      {{ $categories->links() }}
    </div>

    <div class="mt-6">
      <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold text-teal-700 hover:underline">
        ← Kembali ke Dashboard
      </a>
    </div>

  </div>
</div>
@endsection
