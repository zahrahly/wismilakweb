<!DOCTYPE html>
<html>
<head>
    <title>Homepage</title>
</head>
<body>

<h1>Galeri Kegiatan</h1>

<div style="display:flex; gap:20px; flex-wrap:wrap">
    @foreach($galleries as $gallery)
        <div>
            <img src="{{ asset('storage/'.$gallery->image) }}" width="200">
            <p>{{ $gallery->caption }}</p>
        </div>
    @endforeach
</div>
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl font-semibold text-slate-900 mb-10">
            Produk
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($products as $product)
                <a href="{{ route('product.show', $product->id) }}"
                   class="group block">
                    <div class="bg-slate-50 rounded-xl p-6
                                hover:shadow-lg transition">
                        <img src="{{ asset('storage/'.$product->image) }}"
                             class="w-full h-56 object-cover rounded-lg">

                        <h3 class="mt-4 text-lg font-medium text-slate-900">
                            {{ $product->name }}
                        </h3>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

</body>
</html>

