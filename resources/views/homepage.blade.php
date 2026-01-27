<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPT LAB - Sistem Manajemen Permohonan Pengujian</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica Neue', sans-serif;
            line-height: 1.6;
            color: #333;
        }

        /* Navigation */
        nav {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        nav .container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            transition: opacity 0.3s;
        }

        .nav-links a:hover {
            opacity: 0.8;
        }

        .nav-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            display: inline-block;
        }

        .btn-primary {
            background: white;
            color: #667eea;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid white;
        }

        .btn-secondary:hover {
            background: white;
            color: #667eea;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 6rem 2rem;
            text-align: center;
        }

        .hero .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .hero h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .hero p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.95;
        }

        .hero .btn {
            display: inline-block;
            margin: 0 0.5rem;
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        /* Section */
        section {
            padding: 4rem 2rem;
        }

        section.alt {
            background: #f8f9fa;
        }

        h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #333;
        }

        /* About Section */
        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
            margin-bottom: 3rem;
        }

        .about-grid.reverse {
            direction: rtl;
        }

        .about-grid.reverse > * {
            direction: ltr;
        }

        .about-content h3 {
            font-size: 1.5rem;
            color: #667eea;
            margin-bottom: 1rem;
        }

        .about-content ul {
            list-style: none;
            margin-bottom: 1rem;
        }

        .about-content li {
            padding: 0.5rem 0;
            padding-left: 1.5rem;
            position: relative;
        }

        .about-content li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #667eea;
            font-weight: bold;
        }

        .about-image {
            text-align: center;
        }

        .about-image svg {
            max-width: 100%;
            height: auto;
        }

        /* Features Grid */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .feature-card {
            background: white;
            padding: 2rem;
            border-radius: 0.75rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
            text-align: center;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .feature-card h3 {
            font-size: 1.25rem;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .feature-card p {
            color: #666;
            font-size: 0.95rem;
        }

        /* Table Styles */
        table tr:hover {
            background-color: #f8f9ff;
        }

        /* Hide rows after 10 */
        .jenis-row[data-index] {
            display: table-row;
        }

        .jenis-row[data-index].hidden {
            display: none;
        }

        .jenis-row[data-index].show {
            display: table-row;
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Responsive */
        .cta {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            padding: 4rem 2rem;
            border-radius: 0.75rem;
        }

        .cta h2 {
            color: white;
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .cta p {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            opacity: 0.95;
        }

        /* Footer */
        footer {
            background: #2c3e50;
            color: white;
            padding: 3rem 2rem;
            text-align: center;
            margin-top: 4rem;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-section h4 {
            margin-bottom: 1rem;
            color: #667eea;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section a {
            color: #bbb;
            text-decoration: none;
            display: block;
            margin: 0.5rem 0;
        }

        .footer-section a:hover {
            color: white;
        }

        .footer-bottom {
            border-top: 1px solid #444;
            padding-top: 2rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .about-grid,
            .about-grid.reverse {
                grid-template-columns: 1fr;
                direction: ltr;
            }

            .about-grid.reverse > * {
                direction: ltr;
            }

            .nav-links {
                gap: 1rem;
                font-size: 0.9rem;
            }

            h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav>
        <div class="container">
            <a href="/" class="logo">UPT LAB.</a>
            <ul class="nav-links">
                <li><a href="#about">Tentang</a></li>
                <li><a href="#features">Fitur</a></li>
                <li><a href="#laboratories">Laboratorium</a></li>
            </ul>
            <div class="nav-buttons">
                @auth
                    <a href="{{ route('filament.admin.pages.dashboard') }}" class="btn btn-primary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-secondary">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Sistem Manajemen Permohonan Pengujian</h1>
            <p>Platform digital untuk memudahkan pengajuan dan pengelolaan permohonan pengujian laboratorium</p>
            @auth
                <a href="{{ route('filament.admin.pages.dashboard') }}" class="btn btn-primary">Masuk ke Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">Mulai Sekarang</a>
                <a href="#about" class="btn btn-secondary">Pelajari Lebih Lanjut</a>
            @endauth
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="alt">
        <div class="container">
            <h2>Tentang UPT LAB</h2>

            <div class="about-grid">
                <div class="about-content">
                    <h3>Apa itu UPT LAB?</h3>
                    <p>UPT LAB adalah platform web terintegrasi untuk manajemen permohonan pengujian yang dirancang untuk memudahkan proses pengajuan, verifikasi, pembayaran, dan pengelolaan hasil pengujian laboratorium.</p>
                    <p style="margin-top: 1rem;">Sistem ini menggabungkan teknologi terkini dengan interface yang user-friendly untuk memberikan pengalaman terbaik bagi semua pengguna.</p>
                </div>
                <div class="about-image">
                    <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 24 24" fill="none" stroke="#667eea" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/>
                        <path d="M12 6v6l5 3"/>
                    </svg>
                </div>
            </div>

            <div class="about-grid reverse">
                <div class="about-content">
                    <h3>Tujuan & Manfaat</h3>
                    <ul>
                        <li><strong>Otomasi Proses</strong> - Menggantikan proses manual dengan sistem digital</li>
                        <li><strong>Efisiensi Waktu</strong> - Mengurangi waktu pemrosesan permohonan</li>
                        <li><strong>Transparansi</strong> - Tracking status permohonan real-time</li>
                        <li><strong>Keamanan Data</strong> - Penyimpanan dokumen digital yang aman</li>
                        <li><strong>Pembayaran Online</strong> - Berbagai metode pembayaran tersedia</li>
                        <li><strong>Laporan Digital</strong> - Hasil pengujian dapat diakses kapan saja</li>
                    </ul>
                </div>
                <div class="about-image">
                    <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 30 30" fill="none" stroke="#667eea" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5z"/>
                        <polyline points="10 17 14 13 10 9"/>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features">
        <div class="container">
            <h2>Fitur Utama</h2>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">📝</div>
                    <h3>Manajemen Permohonan</h3>
                    <p>Buat, kelola, dan lacak status permohonan pengujian dengan mudah melalui dashboard intuitif</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">💳</div>
                    <h3>Pembayaran Online</h3>
                    <p>Berbagai metode pembayaran tersedia (Virtual Account, Kartu Kredit, E-Wallet, QRIS)</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <h3>Tracking Real-Time</h3>
                    <p>Pantau progress pengujian Anda secara real-time dengan notifikasi otomatis</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">📄</div>
                    <h3>Dokumen Digital</h3>
                    <p>Upload, simpan, dan kelola dokumen permohonan serta hasil pengujian secara digital</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">👥</div>
                    <h3>Manajemen User</h3>
                    <p>Sistem role-based dengan akses terkontrol untuk setiap jenis pengguna</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">📈</div>
                    <h3>Laporan & Statistik</h3>
                    <p>Generate laporan lengkap dan visualisasi data untuk monitoring yang lebih baik</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Jenis Pengujian Section -->
    <section id="laboratories" class="alt">
        <div class="container">
            <h2>Jenis-Jenis Pengujian</h2>
            <p style="margin-bottom: 3rem; color: #666;">Daftar lengkap jenis pengujian yang tersedia di UPT LAB beserta harga layanan</p>

            <div style="overflow-x: auto; background: white; border-radius: 0.75rem; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                            <th style="padding: 1rem; text-align: left; font-weight: 600; border: 1px solid #ddd;">No.</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 600; border: 1px solid #ddd;">Jenis Pengujian</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 600; border: 1px solid #ddd;">Deskripsi</th>
                            <th style="padding: 1rem; text-align: right; font-weight: 600; border: 1px solid #ddd;">Biaya</th>
                        </tr>
                    </thead>
                    <tbody id="jenisPengujianTable">
                        @forelse($jenisPengujian as $index => $jenis)
                        <tr style="border-bottom: 1px solid #eee; transition: background-color 0.3s;" class="jenis-row" data-index="{{ $index }}">
                            <td style="padding: 1rem; border: 1px solid #ddd; color: #667eea; font-weight: 600;">{{ $index + 1 }}</td>
                            <td style="padding: 1rem; border: 1px solid #ddd; color: #333; font-weight: 500;">{{ $jenis->nama_pengujian }}</td>
                            <td style="padding: 1rem; border: 1px solid #ddd; color: #666; font-size: 0.95rem;">
                                {{ $jenis->deskripsi ?? '-' }}
                            </td>
                            <td style="padding: 1rem; border: 1px solid #ddd; text-align: right; font-weight: 600; color: #667eea;">
                                Rp {{ number_format($jenis->biaya, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="padding: 2rem; text-align: center; color: #999;">
                                Tidak ada jenis pengujian yang tersedia saat ini
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Load More Button -->
            @if(count($jenisPengujian) > 10)
            <div style="margin-top: 2rem; text-align: center;">
                <button id="loadMoreBtn" onclick="loadMoreRows()" style="
                    padding: 0.75rem 2rem;
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    color: white;
                    border: none;
                    border-radius: 0.5rem;
                    font-weight: 600;
                    cursor: pointer;
                    transition: all 0.3s;
                    display: inline-flex;
                    align-items: center;
                    gap: 0.5rem;
                " onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0, 0, 0, 0.2)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                    <span>Tampilkan Lainnya</span>
                </button>
            </div>
            @endif

            <div style="margin-top: 2rem; padding: 1.5rem; background: #f0f4ff; border-left: 4px solid #667eea; border-radius: 0.5rem;">
                <p style="color: #333; font-size: 0.95rem;">
                    <strong>📌 Catatan:</strong> Harga yang tercantum di atas adalah biaya dasar per item pengujian. Untuk kebutuhan khusus atau pengujian dengan sampel dalam jumlah besar, silakan hubungi layanan pelanggan kami untuk konsultasi lebih lanjut.
                </p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section>
        <div class="container">
            <div class="cta">
                <h2>Siap Mulai?</h2>
                <p>Daftarkan diri Anda sekarang dan nikmati kemudahan pengajuan permohonan pengujian</p>
                @auth
                    <a href="{{ route('filament.admin.pages.dashboard') }}" class="btn btn-primary">Ke Dashboard</a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-primary">Daftar Gratis</a>
                    <a href="{{ route('login') }}" class="btn btn-secondary">Sudah Punya Akun?</a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>UPT Lab.</h4>
                    <p>Sistem Manajemen Permohonan Pengujian</p>
                </div>
                <div class="footer-section">
                    <h4>Menu</h4>
                    <ul>
                        <li><a href="#about">Tentang</a></li>
                        <li><a href="#features">Fitur</a></li>
                        <li><a href="#laboratories">Laboratorium</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Kontak</h4>
                    <ul>
                        <li><a href="mailto:info@upt2lab.id">info@upt2lab.id</a></li>
                        <li><a href="tel:+621234567890">+62 123-456-7890</a></li>
                        <li>Jalan Laboratorium No. 1, Jakarta</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2026 UPT LAB - Sistem Manajemen Permohonan Pengujian. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        let currentShown = 10;
        const itemsPerLoad = 10;

        function loadMoreRows() {
            const rows = document.querySelectorAll('.jenis-row');
            const loadMoreBtn = document.getElementById('loadMoreBtn');
            let loaded = 0;

            // Show next 10 rows
            for (let i = currentShown; i < currentShown + itemsPerLoad && i < rows.length; i++) {
                rows[i].classList.remove('hidden');
                rows[i].classList.add('show');
                loaded++;
            }

            currentShown += loaded;

            // Hide button if all items are shown
            if (currentShown >= rows.length) {
                loadMoreBtn.style.display = 'none';
            }
        }

        // Initialize - hide rows after 10 on page load
        window.addEventListener('load', function() {
            const rows = document.querySelectorAll('.jenis-row');
            for (let i = 10; i < rows.length; i++) {
                rows[i].classList.add('hidden');
            }
        });
    </script>
</body>
</html>
