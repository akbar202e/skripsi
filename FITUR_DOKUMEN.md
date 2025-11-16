# Dokumentasi Fitur Dokumen dengan Pan & Zoom

## Overview
Fitur Dokumen adalah modul untuk mengelola dokumen laboratorium seperti SOP, peraturan, dan informasi pengujian dengan viewer interaktif menggunakan plugin Pan & Zoom.

## Fitur Utama

### 1. **Admin Panel (CRUD Dokumen)**
- ✅ Upload gambar dokumen (JPG, PNG, max 5MB)
- ✅ Kategori dokumen: Peraturan dan Informasi
- ✅ Preview gambar dengan Pan & Zoom saat edit
- ✅ Edit judul, deskripsi, dan kategori
- ✅ Hapus dokumen
- ✅ Hanya admin yang dapat mengelola

### 2. **User Interface (View Dokumen)**
- ✅ Lihat semua dokumen (bisa diakses semua user yang login)
- ✅ Filter berdasarkan kategori
- ✅ Viewer gambar dengan Pan & Zoom interaktif
- ✅ Pan dengan mouse drag
- ✅ Zoom dengan mouse wheel
- ✅ Double-click zoom ke posisi tertentu
- ✅ Download gambar original
- ✅ Responsive design

## File-File yang Dibuat

### Models
- `app/Models/Dokumen.php` - Model untuk tabel dokumen

### Database
- `database/migrations/2025_11_16_055643_create_dokumens_table.php` - Migration tabel dokumen
- `database/seeders/DokumenSeeder.php` - Seeder data contoh

### Filament Resources
- `app/Filament/Resources/DokumenResource.php` - Resource utama
- `app/Filament/Resources/DokumenResource/Pages/ListDokumens.php` - Halaman list
- `app/Filament/Resources/DokumenResource/Pages/CreateDokumen.php` - Halaman create
- `app/Filament/Resources/DokumenResource/Pages/EditDokumen.php` - Halaman edit
- `app/Filament/Resources/DokumenResource/Pages/ViewDokumen.php` - Halaman view detail

### Policies & Authorization
- `app/Policies/DokumenPolicy.php` - Policy untuk kontrol akses

### Controllers
- `app/Http/Controllers/DokumenController.php` - Controller untuk public routes

### Views
- `resources/views/dokumen/index.blade.php` - List dokumen untuk user
- `resources/views/dokumen/show.blade.php` - Detail dokumen dengan Pan & Zoom

### Configuration
- `app/Providers/AppServiceProvider.php` - Register policy
- `app/Providers/Filament/AdminPanelProvider.php` - Register Pan & Zoom plugin
- `routes/web.php` - Routes untuk dokumen public

## Database Schema

```sql
CREATE TABLE dokumens (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    judul VARCHAR(255) NOT NULL,
    deskripsi TEXT NULL,
    kategori ENUM('peraturan', 'informasi') NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    created_by BIGINT NOT NULL (FK to users),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

## Struktur Folder Storage
```
storage/app/public/dokumen/
├── [nama-file-1].jpg
├── [nama-file-2].png
└── ...
```

Diakses via: `/storage/dokumen/[nama-file].jpg`

## Cara Penggunaan

### 1. Setup Awal
```bash
# Jalankan migration (jika belum)
php artisan migrate

# (Opsional) Jalankan seeder untuk data contoh
php artisan db:seed --class=DokumenSeeder
```

### 2. Di Admin Panel (`/admin/dokumen`)

#### Upload Dokumen (Admin Only)
1. Klik tombol "Create" di halaman list dokumen
2. Isi form:
   - **Judul**: Nama dokumen (wajib)
   - **Deskripsi**: Penjelasan singkat (opsional)
   - **Kategori**: Pilih "Peraturan" atau "Informasi" (wajib)
   - **Upload Gambar**: Pilih file JPG/PNG max 5MB (wajib)
3. Preview gambar akan muncul setelah upload
4. Klik "Create" untuk simpan

#### Edit Dokumen (Admin Only)
1. Klik tombol "View" pada dokumen yang ingin diedit
2. Klik tombol "Edit" di bagian atas
3. Update informasi sesuai kebutuhan
4. Gunakan preview Pan & Zoom untuk melihat gambar
5. Klik "Save" untuk simpan perubahan

#### Hapus Dokumen (Admin Only)
1. Di halaman list, pilih dokumen yang ingin dihapus
2. Klik "Delete" atau "Bulk Delete" untuk multiple
3. Konfirmasi penghapusan

### 3. Di Public View (`/dokumen`)

#### Lihat Daftar Dokumen
1. Akses `/dokumen` (perlu login)
2. Lihat grid dokumen dengan preview thumbnail
3. Filter dengan tombol kategori (Semua, Peraturan, Informasi)
4. Scroll untuk pagination

#### Lihat Detail Dokumen dengan Pan & Zoom
1. Klik salah satu dokumen dari grid
2. Halaman detail terbuka dengan:
   - **Zoom**: Gunakan mouse wheel
   - **Pan**: Click & drag dengan mouse
   - **Double-Click Zoom**: Klik dua kali untuk zoom ke lokasi (3x zoom)
   - **Double-Click Lagi**: Zoom out kembali ke normal
3. Download tombol untuk download gambar original
4. Lihat dokumen terkait di bagian bawah

## Permission & Role

### Authorization Rules
```php
// Dapat lihat: Semua user (authenticated)
viewAny(), view()

// Hanya Admin yang dapat:
create()  - Upload dokumen baru
update()  - Edit dokumen
delete()  - Hapus dokumen
```

## Pan & Zoom Library

Plugin menggunakan **solution-forest/filament-panzoom** dengan fitur:

### Di Filament Admin:
- Component `PanZoom` untuk forms
- Component `PanZoomEntry` untuk infolists
- Double-click zoom level: 3.0x

### Di Public View:
- Library **panzoom.js** dari CDN
- Zoom range: 0.5x - 5.0x
- Smooth transitions
- Touch support untuk mobile

## Konfigurasi (Opsional)

### Mengubah Ukuran Max Upload
Di `app/Filament/Resources/DokumenResource.php`, ubah:
```php
->maxSize(5120)  // Dalam KB, sekarang 5MB
```

### Mengubah Double-Click Zoom Level
```php
->doubleClickZoomLevel(3.0)  // Ubah nilai sesuai keinginan (0.5-5.0)
```

### Mengubah Direktori Upload
```php
->directory('dokumen')  // Ganti 'dokumen' dengan nama lain
```

## Troubleshooting

### 1. Gambar tidak muncul setelah upload
- Pastikan symbolic link sudah dibuat: `php artisan storage:link`
- Cek folder `storage/app/public/dokumen/` ada file gambarnya
- Pastikan permission folder writable

### 2. Pan & Zoom tidak berfungsi
- Bersihkan cache: `php artisan cache:clear`
- Clear assets: `php artisan filament:clear-cached-components`
- Hard refresh browser (Ctrl+Shift+R)

### 3. Admin tidak bisa upload
- Pastikan user memiliki role 'admin'
- Cek policy di `app/Policies/DokumenPolicy.php`

### 4. Zoom terlalu lambat/cepat
- Sesuaikan `maxZoom`, `minZoom` di `show.blade.php`
- Ubah nilai `doubleClickZoomLevel` di DokumenResource

## API Reference

### Model Dokumen

```php
// Get dokumen dengan creator
$dokumen = Dokumen::with('creator')->find($id);

// Get dokumen by kategori
$dokumens = Dokumen::where('kategori', 'peraturan')->get();

// Query dokumen dengan pagination
$dokumens = Dokumen::paginate(12);

// Akses properties
$dokumen->judul           // Judul dokumen
$dokumen->deskripsi       // Deskripsi
$dokumen->kategori        // 'peraturan' atau 'informasi'
$dokumen->image_path      // Path relatif: 'dokumen/filename.jpg'
$dokumen->creator         // Relasi ke User
$dokumen->created_at      // Timestamp
$dokumen->updated_at      // Timestamp
```

### Routes

```php
// Public Routes (Authenticated)
GET /dokumen              // List semua dokumen
GET /dokumen/{dokumen}    // Detail dokumen

// Admin Routes (via Filament)
GET /admin/dokumen        // List (Filament)
GET /admin/dokumen/create // Create form
POST /admin/dokumen       // Store
GET /admin/dokumen/{id}   // View detail
GET /admin/dokumen/{id}/edit // Edit form
PUT /admin/dokumen/{id}   // Update
DELETE /admin/dokumen/{id} // Delete
```

## Next Steps / Enhancement

Fitur yang bisa ditambahkan di masa depan:
- [ ] Bulk upload dokumen
- [ ] Search & full-text search
- [ ] Comment/review pada dokumen
- [ ] Version control untuk dokumen
- [ ] Export ke PDF
- [ ] OCR untuk text recognition
- [ ] Integration dengan media library
- [ ] Audit log untuk tracking changes
- [ ] Email notification untuk update dokumen

## Support

Jika ada pertanyaan atau masalah, silakan:
1. Check troubleshooting section di atas
2. Bersihkan cache dan assets
3. Restart development server
