@extends('layouts.admin')

@section('title', 'Edit Reward')

@section('content')
<div class="max-w-xl space-y-6">

    <h2 class="text-2xl font-semibold text-slate-900">
        Edit Reward
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
          action="{{ route('admin.points.rewards.update', $reward->id) }}"
          enctype="multipart/form-data"
          class="bg-white p-6 rounded-xl shadow space-y-4">
        @csrf
        @method('PUT')

        <!-- JUDUL -->
        <div>
            <label class="block text-sm font-medium mb-1">Judul Reward</label>
            <input type="text" name="title"
                   value="{{ old('title', $reward->title) }}"
                   class="w-full bg-slate-50 px-4 py-2 rounded-lg">
        </div>

        <!-- DESKRIPSI -->
        <div>
            <label class="block text-sm font-medium mb-1">Deskripsi</label>
            <textarea name="description"
                      rows="3"
                      class="w-full bg-slate-50 px-4 py-2 rounded-lg">{{ old('description', $reward->description) }}</textarea>
        </div>

        <!-- POIN -->
        <div>
            <label class="block text-sm font-medium mb-1">Poin Dibutuhkan</label>
            <input type="number" name="points_required"
                   value="{{ old('points_required', $reward->points_required) }}"
                   class="w-full bg-slate-50 px-4 py-2 rounded-lg">
        </div>

        <!-- STOK -->
        <div>
            <label class="block text-sm font-medium mb-1">Stok</label>
            <input type="number" name="stock"
                   value="{{ old('stock', $reward->stock) }}"
                   class="w-full bg-slate-50 px-4 py-2 rounded-lg">
        </div>

        <!-- PREVIEW GAMBAR -->
        @if($reward->image)
            <div>
                <label class="block text-sm font-medium mb-1">
                    Gambar Saat Ini
                </label>
                <img src="{{ asset('storage/' . $reward->image) }}"
                     alt="{{ $reward->title }}"
                     class="w-32 h-32 object-cover rounded-lg border">
            </div>
        @endif

        <!-- GAMBAR BARU -->
        <div>
            <label class="block text-sm font-medium mb-1">Ganti Gambar (Opsional)</label>
            <input type="file" name="image"
                   class="w-full bg-slate-50 px-4 py-2 rounded-lg">
            <p class="text-xs text-slate-400 mt-1">
                Kosongkan jika tidak ingin mengganti gambar
            </p>
        </div>

        <!-- ACTION -->
        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.points.rewards.index') }}"
               class="px-4 py-2 bg-slate-200 rounded-lg">
                Batal
            </a>
            <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg">
                Update
            </button>
        </div>

    </form>
</div>
@endsection

