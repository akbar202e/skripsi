@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <div class="mb-6">
        <a href="{{ route('dokumen.index') }}" class="text-blue-600 hover:text-blue-800">← Kembali ke Dokumen</a>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Header dengan Info -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white p-8">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-4xl font-bold mb-2">{{ $dokumen->judul }}</h1>
                    <span class="inline-block px-4 py-2 rounded-full 
                        {{ $dokumen->kategori === 'peraturan' ? 'bg-blue-200 text-blue-900' : 'bg-green-200 text-green-900' }}">
                        {{ ucfirst($dokumen->kategori) }}
                    </span>
                </div>
                <div class="text-right">
                    <p class="text-blue-100">Oleh: <strong>{{ $dokumen->creator->name }}</strong></p>
                    <p class="text-blue-100">{{ $dokumen->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Deskripsi -->
        @if ($dokumen->deskripsi)
            <div class="px-8 py-6 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-900 mb-2">Deskripsi</h2>
                <p class="text-gray-700 leading-relaxed">{{ $dokumen->deskripsi }}</p>
            </div>
        @endif

        <!-- Gambar dengan Pan & Zoom -->
        <div class="p-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Gambar Dokumen</h2>
            <div class="bg-gray-100 rounded-lg overflow-hidden" id="panzoom-container">
                <img id="panzoom-image" 
                     src="{{ asset('storage/' . $dokumen->image_path) }}" 
                     alt="{{ $dokumen->judul }}"
                     class="w-full h-auto cursor-grab active:cursor-grabbing"
                     style="max-height: 600px; object-fit: contain;">
            </div>
            <p class="text-sm text-gray-500 mt-3">
                💡 <strong>Tips:</strong> Gunakan roda mouse untuk zoom, drag untuk pan, atau klik ganda untuk zoom otomatis
            </p>
        </div>

        <!-- Tombol Download -->
        <div class="px-8 py-6 bg-gray-50 border-t border-gray-200 flex gap-4">
            <a href="{{ asset('storage/' . $dokumen->image_path) }}" 
               download="{{ $dokumen->judul }}"
               class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Download Gambar
            </a>
            @can('update', $dokumen)
                <a href="{{ route('dokumen.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                    Lihat Dokumen Lain
                </a>
            @endcan
        </div>
    </div>

    <!-- Related Dokumen -->
    @php
        $related = \App\Models\Dokumen::where('kategori', $dokumen->kategori)
            ->where('id', '!=', $dokumen->id)
            ->limit(3)
            ->get();
    @endphp

    @if ($related->count() > 0)
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Dokumen Terkait</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($related as $item)
                    <a href="{{ route('dokumen.show', $item) }}" 
                       class="bg-white rounded-lg shadow-md hover:shadow-lg transition overflow-hidden">
                        <div class="aspect-video overflow-hidden bg-gray-100">
                            <img src="{{ asset('storage/' . $item->image_path) }}" 
                                 alt="{{ $item->judul }}"
                                 class="w-full h-full object-cover hover:scale-105 transition">
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">{{ $item->judul }}</h3>
                            <p class="text-gray-600 text-sm line-clamp-2">{{ $item->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>

<!-- Include Pan & Zoom Library -->
<script src="https://cdn.jsdelivr.net/npm/panzoom@9.4.0/dist/panzoom.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('panzoom-container');
        const image = document.getElementById('panzoom-image');
        
        // Initialize Pan & Zoom
        const panzoom = Panzoom(image, {
            maxZoom: 5,
            minZoom: 0.5,
            contain: 'outside'
        });

        // Mouse wheel zoom
        container.parentElement.addEventListener('wheel', (e) => {
            e.preventDefault();
            panzoom.zoomWithWheel(e);
        });

        // Double click zoom
        image.addEventListener('dblclick', (e) => {
            e.preventDefault();
            const rect = image.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            if (panzoom.getScale() > 1.5) {
                panzoom.reset();
            } else {
                panzoom.zoom(3, { x, y });
            }
        });
    });
</script>

@endsection
