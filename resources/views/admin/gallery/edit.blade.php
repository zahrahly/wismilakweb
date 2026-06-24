@extends('layouts.admin')

@section('title', 'Edit Galeri')

@section('content')

<div class="max-w-2xl bg-white rounded-xl shadow p-6">

    <h2 class="text-xl font-semibold text-gray-800 mb-6">
        Edit Data Galeri
    </h2>

    <form action="{{ route('admin.gallery.update', $gallery->id) }}"
          method="POST"
          class="space-y-5">
        @csrf
        @method('PUT')

        <!-- PREVIEW GAMBAR -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Gambar Saat Ini
            </label>
            <img src="{{ asset('storage/'.$gallery->image) }}"
                 class="w-48 h-32 object-cover rounded-lg border">
        </div>

        <!-- CAPTION -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Caption
            </label>
            <input type="text"
                   name="caption"
                   value="{{ $gallery->caption }}"
                   class="w-full border border-gray-300 rounded-lg
                          px-4 py-2 focus:ring-indigo-500
                          focus:border-indigo-500">
        </div>

        <!-- KATEGORI -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Kategori
            </label>
            <select name="category"
                    class="w-full border border-gray-300 rounded-lg
                           px-4 py-2 focus:ring-indigo-500
                           focus:border-indigo-500">
                <option value="event" {{ $gallery->category === 'event' ? 'selected' : '' }}>
                    Event
                </option>
                <option value="promo" {{ $gallery->category === 'promo' ? 'selected' : '' }}>
                    Promo
                </option>
            </select>
        </div>

        <!-- STATUS -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Status
            </label>
            <select name="status"
                    class="w-full border border-gray-300 rounded-lg
                           px-4 py-2 focus:ring-indigo-500
                           focus:border-indigo-500">
                <option value="tampil" {{ $gallery->status === 'tampil' ? 'selected' : '' }}>
                    Tampil
                </option>
                <option value="sembunyi" {{ $gallery->status === 'sembunyi' ? 'selected' : '' }}>
                    Sembunyi
                </option>
            </select>
        </div>

        <!-- ACTION -->
        <div class="flex justify-end space-x-3 pt-4">
            <a href="{{ route('admin.gallery.index') }}"
               class="px-4 py-2 rounded-lg border
                      border-gray-300 text-gray-700
                      hover:bg-gray-100 transition">
                Kembali
            </a>

            <button type="submit"
                    class="px-5 py-2 rounded-lg
                           bg-indigo-600 text-white
                           hover:bg-indigo-700 transition">
                Update
            </button>
        </div>
    </form>
</div>

@endsection

