<div class="p-6">
    <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">Dokumen Laboratorium</h2>
    
    <style>
        .dokumen-image-wrapper {
            overflow: hidden;
        }

        .dokumen-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: .3s ease-in-out;
            -webkit-transition: .3s ease-in-out;
        }

        .dokumen-image-wrapper:hover .dokumen-image {
            transform: scale(1.1);
            -webkit-transform: scale(1.1);
        }
    </style>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse ($this->getDokumen() as $dokumen)
            <a href="{{ route('filament.admin.resources.dokumens.view', $dokumen->id) }}" 
               class="group relative overflow-hidden rounded-lg shadow-md hover:shadow-lg transition-all duration-300 bg-white dark:bg-gray-800 hover:scale-105 transform flex flex-col h-full">
                
                <!-- Image Container -->
                <div class="dokumen-image-wrapper relative h-96 w-full bg-gray-200 dark:bg-gray-700 flex-shrink-0">
                    <img 
                        src="{{ $this->getImageUrl($dokumen->image_path) }}" 
                        alt="{{ $dokumen->judul }}"
                        class="dokumen-image"
                    >
                    
                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-40 transition-opacity duration-300"></div>
                </div>

                <!-- Content Container -->
                <div class="p-4 flex flex-col flex-grow">
                    <h3 class="font-semibold text-lg text-gray-900 dark:text-white line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                        {{ $dokumen->judul }}
                    </h3>
                    
                    @if ($dokumen->kategori)
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                            <span class="inline-block px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded">
                                {{ $dokumen->kategori }}
                            </span>
                        </p>
                    @endif
                    
                    @if ($dokumen->deskripsi)
                        <p class="text-sm text-gray-600 dark:text-gray-300 mt-2 line-clamp-2 flex-grow">
                            {{ $dokumen->deskripsi }}
                        </p>
                    @endif

                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-3 border-t border-gray-200 dark:border-gray-700 pt-3">
                        Dibuat oleh: {{ $dokumen->creator?->name ?? 'Unknown' }}
                    </p>
                </div>

                <!-- Click Indicator -->
                <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </a>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 dark:text-gray-400 text-lg">Tidak ada dokumen tersedia</p>
            </div>
        @endforelse
    </div>
</div>
