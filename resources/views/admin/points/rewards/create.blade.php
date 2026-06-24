@extends('layouts.admin')

@section('title', 'Tambah Reward')

@section('content')
<div class="max-w-xl space-y-6">

    <h2 class="text-2xl font-semibold text-slate-900">
        Tambah Reward
    </h2>

    @if ($errors->any())
        <div class="bg-red-50 text-red-700 px-4 py-3 rounded-lg">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ route('admin.points.rewards.store') }}"
          enctype="multipart/form-data"
          class="bg-white p-6 rounded-xl shadow space-y-4">
        @csrf

        <!-- JUDUL -->
        <div>
            <label class="block text-sm font-medium mb-1">Judul Reward</label>
            <input type="text" name="title"
                   value="{{ old('title') }}"
                   class="w-full bg-slate-50 px-4 py-2 rounded-lg">
        </div>

        <!-- DESKRIPSI -->
        <div>
            <label class="block text-sm font-medium mb-1">Deskripsi</label>
            <textarea name="description"
                      rows="3"
                      class="w-full bg-slate-50 px-4 py-2 rounded-lg">{{ old('description') }}</textarea>
        </div>

        <!-- POIN -->
        <div>
            <label class="block text-sm font-medium mb-1">Poin Dibutuhkan</label>
            <input type="number" name="points_required"
                   value="{{ old('points_required') }}"
                   class="w-full bg-slate-50 px-4 py-2 rounded-lg">
        </div>

        <!-- STOK -->
        <div>
            <label class="block text-sm font-medium mb-1">Stok</label>
            <input type="number" name="stock"
                   value="{{ old('stock') }}"
                   class="w-full bg-slate-50 px-4 py-2 rounded-lg">
        </div>

        <!-- GAMBAR -->
        <div>
            <label class="block text-sm font-medium mb-1">Gambar Reward</label>
            <input type="file" name="image"
                   class="w-full bg-slate-50 px-4 py-2 rounded-lg">
            <p class="text-xs text-slate-400 mt-1">
                JPG / PNG, maksimal 2MB
            </p>
        </div>

        <!-- ACTION -->
        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.points.rewards.index') }}"
               class="px-4 py-2 bg-slate-200 rounded-lg">
                Batal
            </a>
            <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg">
                Simpan
            </button>
        </div>

    </form>
</div>
@endsection

