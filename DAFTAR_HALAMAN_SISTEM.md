# Daftar Halaman Sistem - Persiapan Bab 4 Skripsi

## Halaman-Halaman Sistem UPT2

Berikut adalah daftar lengkap halaman-halaman yang ada dalam sistem manajemen permohonan pengujian UPT2:

---

### 1. HOMEPAGE
**Akses**: Publik (Tanpa Login)
**URL**: `/`
**Deskripsi**: Halaman utama sistem yang dapat diakses oleh siapa saja tanpa perlu login. Menampilkan informasi umum tentang sistem, fitur-fitur utama, dan daftar jenis pengujian dalam bentuk tabel dengan pagination "Load More".

---

### 2. LOGIN
**Akses**: Publik (Tanpa Login)
**URL**: `/admin/login`
**Deskripsi**: Halaman untuk pengguna yang sudah terdaftar melakukan autentikasi. Meminta input email dan password, serta menyediakan fitur lupa password dan link ke halaman registrasi.

---

### 3. REGISTRASI
**Akses**: Publik (Tanpa Login)
**URL**: `/admin/register`
**Deskripsi**: Halaman untuk calon pengguna membuat akun baru. Menampilkan form input nama lengkap, email, password, dan konfirmasi password dengan validasi lengkap.

---

### 4. DASHBOARD
**Akses**: Private (Login Required)
**URL**: `/admin`
**Deskripsi**: Halaman utama setelah login yang menampilkan welcome message, informasi profil pengguna, dan navigasi ke semua fitur sistem sesuai dengan role pengguna.

---

### 5. ABOUT PAGE (Halaman Tentang)
**Akses**: Private (Login Required)
**URL**: `/admin/about`
**Deskripsi**: Halaman informasi lengkap tentang sistem UPT2. Menampilkan penjelasan sistem, tujuan, fitur-fitur, tabel jenis pengujian dengan load more pagination, stack teknologi, dan informasi kontak.

---

### 6. PERMOHONAN (Manajemen Permohonan)
**Akses**: Private (Login Required)
**URL**: `/admin/permohonans`
**Deskripsi**: Halaman manajemen semua permohonan pengujian. Menampilkan tabel daftar permohonan dengan status, biaya, pemohon, dan worker. Dilengkapi fitur search, filter, export Excel, serta aksi view, edit, dan delete. Form edit menampilkan beberapa section termasuk informasi permohonan, jenis pengujian, status pembayaran dan sampel, laporan hasil, dan keterangan perbaikan.

**Akses Berdasarkan Role**:
- **Pemohon**: Hanya dapat melihat permohonan milik sendiri, dapat membuat permohonan baru
- **Petugas**: Dapat melihat semua permohonan, mengelola status dan sampel
- **Admin**: Full access ke semua permohonan

---

### 7. JENIS PENGUJIAN (Master Data)
**Akses**: Private (Login Required)
**URL**: `/admin/jenis-pengujians`
**Deskripsi**: Halaman manajemen master data jenis pengujian yang tersedia di laboratorium. Menampilkan tabel dengan kolom nama pengujian, biaya dalam format rupiah, waktu pembuatan, dan update. Dilengkapi fitur search, filter, export Excel, serta aksi edit dan delete. Form edit memiliki field nama pengujian, biaya (numeric dengan prefix Rp), dan deskripsi.

**Akses Berdasarkan Role**:
- **Pemohon**: Hanya dapat melihat daftar jenis pengujian saat membuat permohonan
- **Petugas & Admin**: Dapat melihat dan mengelola data jenis pengujian

---

### 8. PEMBAYARAN (Manajemen Pembayaran)
**Akses**: Private (Login Required)
**URL**: `/admin/pembayarans`
**Deskripsi**: Halaman manajemen semua transaksi pembayaran dalam sistem. Menampilkan tabel dengan kolom referensi duitku, permohonan terkait, pengguna pembayar, nominal (format rupiah), metode pembayaran, dan status pembayaran dalam badge berwarna. Dilengkapi fitur search, filter, export Excel, dan aksi view. Form detail pembayaran bersifat read-only dengan section informasi pembayaran, detail transaksi, dan status pembayaran.

**Akses Berdasarkan Role**:
- **Pemohon**: Hanya dapat melihat pembayaran milik sendiri
- **Petugas & Admin**: Dapat melihat semua pembayaran

---

### 9. PENGGUNA (User Management)
**Akses**: Private (Login Required - Admin Only)
**URL**: `/admin/users`
**Deskripsi**: Halaman manajemen user dalam sistem. Menampilkan tabel dengan kolom nama, email, role yang dimiliki, verifikasi email, waktu pembuatan, dan update. Dilengkapi fitur search, filter (termasuk filter soft delete), export Excel, serta aksi view, edit, dan delete. Form edit memiliki field nama lengkap, email (dengan validasi), verifikasi email, dan multi-select untuk role assignment.

**Akses Berdasarkan Role**:
- **Admin**: Full access untuk view, edit, delete user
- **Role Lain**: Tidak dapat mengakses halaman ini

---

### 10. PANDUAN & INFORMASI (Dokumen)
**Akses**: Private (Login Required)
**URL**: `/admin/dokumens`
**Deskripsi**: Halaman manajemen dokumen panduan, peraturan, dan informasi penting. Menampilkan tabel dengan kolom judul, kategori, pembuat, waktu pembuatan, dan update. Dilengkapi fitur search, filter kategori, export Excel, serta aksi view, edit, dan delete. Form edit memiliki field judul, deskripsi, kategori (peraturan/informasi), dan upload gambar dengan preview dan fitur pan-zoom.

**Akses Berdasarkan Role**:
- **Admin**: Full access untuk create, edit, delete dokumen
- **Role Lain**: Hanya dapat view dokumen untuk referensi

---

## Tabel Ringkas Akses Per Role

| Halaman | Pemohon | Petugas | Admin | Public |
|---------|---------|---------|-------|--------|
| Homepage | ✓ | ✓ | ✓ | ✓ |
| Login | ✓ | ✓ | ✓ | ✓ |
| Registrasi | ✓ | ✓ | ✓ | ✓ |
| Dashboard | ✓ | ✓ | ✓ | ✗ |
| About | ✓ | ✓ | ✓ | ✗ |
| Permohonan | ✓ (Milik) | ✓ (Semua) | ✓ (Semua) | ✗ |
| Jenis Pengujian | ✓ (View) | ✓ (Full) | ✓ (Full) | ✗ |
| Pembayaran | ✓ (Milik) | ✓ (Semua) | ✓ (Semua) | ✗ |
| Pengguna | ✗ | ✗ | ✓ (Full) | ✗ |
| Panduan & Informasi | ✓ (View) | ✓ (View) | ✓ (Full) | ✗ |

---

## Fitur Umum di Semua Halaman Admin

1. **Tabel Data**: Menampilkan daftar record dengan kolom-kolom relevan
2. **Search**: Pencarian data berdasarkan field yang searchable
3. **Filter**: Penyaringan data berdasarkan kriteria tertentu
4. **Export**: Export data ke format Excel (.xlsx)
5. **Aksi CRUD**: Create (formulir), Read (view detail), Update (edit), Delete (hapus data)
6. **Pagination**: Navigasi antar halaman untuk data yang banyak
7. **Sorting**: Pengurutan data berdasarkan kolom tertentu
8. **Responsive Design**: Kompatibel dengan berbagai ukuran layar

---

## Teknologi & Framework

- **Frontend**: Filament v3 (Laravel Admin Panel), HTML5, CSS3, JavaScript, Alpine.js
- **Backend**: Laravel 12, PHP 8.2+
- **Database**: MySQL/MariaDB
- **Payment Gateway**: Duitku
- **Authentication**: Laravel Sanctum dengan Spatie Roles & Permissions
- **Export**: OpenSpout untuk export Excel
- **Icons**: Heroicons

---

## Catatan Penting

1. Semua halaman private (kecuali Homepage, Login, Registrasi) memerlukan autentikasi
2. Akses ke halaman dan fitur tertentu dibatasi berdasarkan role pengguna
3. Halaman permohonan, pembayaran, dan panduan memiliki fitur akses berbeda per role
4. Semua form dilengkapi dengan validasi input untuk menjaga integritas data
5. Soft delete diimplementasikan pada beberapa model untuk data backup
6. Setiap halaman memiliki fitur audit trail melalui created_at dan updated_at timestamp
