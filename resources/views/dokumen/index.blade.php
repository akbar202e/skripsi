@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Dokumen Laboratorium</h1>
        <p class="text-gray-600">Lihat dan pelajari dokumen SOP, peraturan, dan informasi pengujian di laboratorium</p>
    </div>

    <!-- Filter Kategori -->
    <div class="mb-6 flex gap-2">
        <a href="{{ route('dokumen.index') }}" 
           class="px-4 py-2 rounded-lg transition {{ !request('kategori') ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
            Semua
        </a>
        <a href="{{ route('dokumen.index', ['kategori' => 'peraturan']) }}" 
           class="px-4 py-2 rounded-lg transition {{ request('kategori') === 'peraturan' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
            Peraturan
        </a>
        <a href="{{ route('dokumen.index', ['kategori' => 'informasi']) }}" 
           class="px-4 py-2 rounded-lg transition {{ request('kategori') === 'informasi' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
            Informasi
        </a>
    </div>

    <!-- Grid Dokumen -->
    @if ($dokumens->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @foreach ($dokumens as $dokumen)
                <a href="{{ route('dokumen.show', $dokumen) }}" 
                   class="bg-white rounded-lg shadow-md hover:shadow-lg transition overflow-hidden">
                    <div class="aspect-video overflow-hidden bg-gray-100">
                        <img src="{{ asset('storage/' . $dokumen->image_path) }}" 
                             alt="{{ $dokumen->judul }}"
                             class="w-full h-full object-cover hover:scale-105 transition">
                    </div>
                    <div class="p-4">
                        <div class="mb-2">
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                                {{ $dokumen->kategori === 'peraturan' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                {{ ucfirst($dokumen->kategori) }}
                            </span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">{{ $dokumen->judul }}</h3>
                        <p class="text-gray-600 text-sm line-clamp-2 mb-3">{{ $dokumen->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                        <div class="flex justify-between items-center text-xs text-gray-500">
                            <span>Oleh: {{ $dokumen->creator->name }}</span>
                            <span>{{ $dokumen->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mb-8">
            {{ $dokumens->links() }}
        </div>
    @else
        <div class="bg-gray-50 rounded-lg p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-1">Tidak ada dokumen</h3>
            <p class="text-gray-600">Dokumen {{ $kategori ? 'dengan kategori ' . ucfirst($kategori) : '' }} belum tersedia.</p>
        </div>
    @endif
</div>
@endsection
