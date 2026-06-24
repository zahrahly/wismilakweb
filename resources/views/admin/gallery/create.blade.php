@extends('layouts.admin')

@section('title', 'Tambah Galeri')

@section('content')

<div class="max-w-2xl bg-white rounded-xl shadow p-6">

    <h2 class="text-xl font-semibold text-gray-800 mb-6">
        Tambah Data Galeri
    </h2>

    <form action="{{ route('admin.gallery.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-5">
        @csrf

        <!-- GAMBAR -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Gambar
            </label>
            <input type="file"
                   name="image"
                   required
                   class="block w-full text-sm text-gray-700
                          border border-gray-300 rounded-lg
                          file:bg-gray-100 file:border-0
                          file:px-4 file:py-2
                          file:text-gray-700
                          hover:file:bg-gray-200">
        </div>

        <!-- CAPTION -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Caption
            </label>
            <input type="text"
                   name="caption"
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
                <option value="">Pilih Kategori</option>
                <option value="event">Event</option>
                <option value="promo">Promo</option>
            </select>
        </div>

        <!-- STATUS -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Status
            </label>
            <select name="status"
                    required
                    class="w-full border border-gray-300 rounded-lg
                           px-4 py-2 focus:ring-indigo-500
                           focus:border-indigo-500">
                <option value="tampil">Tampil</option>
                <option value="sembunyi">Sembunyi</option>
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
                Simpan
            </button>
        </div>
    </form>
</div>

@endsection

