<x-filament-panels::page>
    <style>
        .testing-table tbody tr.hidden-row {
            display: none;
        }
    </style>
    <div class="space-y-8">
        <!-- Hero Section -->
        

        <!-- About Section -->
        <div class="grid gap-8 md:grid-cols-2 mb-5">
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    Apa itu UPT LAB?
                </h2>
                <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">
                    UPT LAB adalah platform web terintegrasi untuk manajemen permohonan pengujian yang dirancang untuk memudahkan proses pengajuan, verifikasi, pembayaran, dan pengelolaan hasil pengujian laboratorium.
                </p>
                <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                    Sistem ini menggabungkan teknologi terkini dengan interface yang user-friendly untuk memberikan pengalaman terbaik bagi semua pengguna.
                </p>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    Tujuan Sistem
                </h2>
                <ul class="space-y-2">
                    <li class="flex items-start gap-3">
                        <span class="mt-1 inline-flex h-5 w-5 items-center justify-center rounded-full bg-primary-100 text-primary-600 dark:bg-primary-900 dark:text-primary-300">
                            <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <span class="text-gray-700 dark:text-gray-300"><strong>Otomasi Proses</strong> - Menggantikan proses manual dengan sistem digital</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="mt-1 inline-flex h-5 w-5 items-center justify-center rounded-full bg-primary-100 text-primary-600 dark:bg-primary-900 dark:text-primary-300">
                            <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <span class="text-gray-700 dark:text-gray-300"><strong>Efisiensi Waktu</strong> - Mengurangi waktu pemrosesan permohonan</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="mt-1 inline-flex h-5 w-5 items-center justify-center rounded-full bg-primary-100 text-primary-600 dark:bg-primary-900 dark:text-primary-300">
                            <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <span class="text-gray-700 dark:text-gray-300"><strong>Transparansi</strong> - Tracking status permohonan real-time</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="mt-1 inline-flex h-5 w-5 items-center justify-center rounded-full bg-primary-100 text-primary-600 dark:bg-primary-900 dark:text-primary-300">
                            <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <span class="text-gray-700 dark:text-gray-300"><strong>Keamanan Data</strong> - Penyimpanan dokumen digital yang aman</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Features Grid -->
        <div>
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 mb-5">
                <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                    <div class="text-3xl mb-3">📝</div>
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Manajemen Permohonan</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Buat, kelola, dan lacak status permohonan pengujian dengan mudah</p>
                </div>

                <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                    <div class="text-3xl mb-3">💳</div>
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Pembayaran Online</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Berbagai metode pembayaran tersedia untuk kemudahan Anda</p>
                </div>

                <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                    <div class="text-3xl mb-3">📊</div>
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Tracking Real-Time</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Pantau progress pengujian Anda dengan notifikasi otomatis</p>
                </div>

                <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                    <div class="text-3xl mb-3">📄</div>
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Dokumen Digital</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Kelola dokumen permohonan dan hasil pengujian secara digital</p>
                </div>

                <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                    <div class="text-3xl mb-3">👥</div>
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Manajemen User</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Sistem role-based dengan akses terkontrol untuk setiap pengguna</p>
                </div>

                <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                    <div class="text-3xl mb-3">📈</div>
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Laporan & Statistik</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Generate laporan lengkap dan visualisasi data untuk monitoring</p>
                </div>
            </div>
        </div>

        <!-- Laboratories Section -->
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Jenis-Jenis Pengujian
            </h2>
            <div class="mb-5"></div>
            <div class="rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-900 overflow-hidden mb-5">
                <table class="w-full text-sm testing-table">
                    <!-- <thead class="bg-gradient-to-r from-primary-600 to-purple-600 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold">No.</th>
                            <th class="px-6 py-3 text-left font-semibold">Jenis Pengujian</th>
                            <th class="px-6 py-3 text-left font-semibold">Deskripsi</th>
                            <th class="px-6 py-3 text-right font-semibold">Biaya</th>
                        </tr>
                    </thead> -->
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse(\App\Models\JenisPengujian::orderBy('nama_pengujian')->get() as $index => $jenis)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors {{ $index >= 10 ? 'hidden-row' : '' }}" data-row-index="{{ $index }}">
                            <td class="px-6 py-4 text-primary-600 dark:text-primary-400 font-semibold">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $jenis->nama_pengujian }}</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $jenis->deskripsi ?? '-' }}</td>
                            <td class="px-6 py-4 text-right font-semibold text-primary-600 dark:text-primary-400">
                                Rp {{ number_format($jenis->biaya, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                Tidak ada jenis pengujian yang tersedia
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(\App\Models\JenisPengujian::count() > 10)
            <div class="mt-4 text-center">
                <button id="loadMoreBtn" onclick="loadMoreRows()" class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors duration-200 shadow-md hover:shadow-lg">
                    <span>Lihat Lainnya</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                    </svg>
                </button>
            </div>
            @endif

            <div class="mt-4 rounded-lg border-l-4 border-primary-600 bg-primary-50 p-4 dark:bg-primary-900/20">
                
            </div>
        </div>

        <!-- Technology Stack -->
        

        <!-- Contact Section -->
        <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                Hubungi Kami
            </h2>
            <div class="grid gap-4 md:grid-cols-3">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">📧</span>
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Email</p>
                        <p class="text-gray-900 dark:text-white">info@upt2lab.id</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-2xl">📞</span>
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Telepon</p>
                        <p class="text-gray-900 dark:text-white">+62 123-456-7890</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-2xl">📍</span>
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Alamat</p>
                        <p class="text-gray-900 dark:text-white">Jalan Laboratorium No. 1</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentDisplayedRows = 10;
        const itemsPerLoad = 10;

        function loadMoreRows() {
            const table = document.querySelector('.testing-table');
            const hiddenRows = table.querySelectorAll('tbody tr.hidden-row');
            let rowsToShow = 0;

            // Show next 10 hidden rows
            for (let row of hiddenRows) {
                if (rowsToShow >= itemsPerLoad) break;
                row.classList.remove('hidden-row');
                rowsToShow++;
            }

            currentDisplayedRows += rowsToShow;

            // Hide button if no more rows
            if (table.querySelectorAll('tbody tr.hidden-row').length === 0) {
                document.getElementById('loadMoreBtn').style.display = 'none';
            }
        }
    </script>
</x-filament-panels::page>
