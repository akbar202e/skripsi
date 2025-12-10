# Fitur Export Excel - Rekap Data

## Deskripsi Fitur

Fitur ini memungkinkan pengguna untuk mengunduh rekap/laporan data dari setiap table resource dalam format Excel (.xlsx) atau CSV. Fitur ini menggunakan Filament Export Action yang terintegrasi dengan baik untuk pengelolaan data yang efisien.

## Resource yang Mendukung Export

Fitur Export Excel telah diimplementasikan di semua Resource berikut:

### 1. **Permohonan** (Permohonan Resource)
   - Kolom: Judul, Status, Pemohon, Petugas, Total Biaya, Pembayaran Selesai, Sampel Diterima, Waktu Verifikasi, dll
   - Nama File: `permohonan-{id}.xlsx`

### 2. **Pembayaran** (Pembayaran Resource)
   - Kolom: Judul Permohonan, Nama Pembayar, Nominal, Metode Pembayaran, Status, Result Code, Waktu Pembayaran, dll
   - Nama File: `pembayaran-{id}.xlsx`

### 3. **Jenis Pengujian** (Jenis Pengujian Resource)
   - Kolom: Nama Jenis Pengujian, Harga, Deskripsi, Aktif, Tanggal Dibuat
   - Nama File: `jenis-pengujian-{id}.xlsx`

### 4. **Pengguna** (User Resource)
   - Kolom: Nama, Email, Nomor Telepon, Tanggal Dibuat, Tanggal Diperbarui
   - Nama File: `users-{id}.xlsx`

### 5. **Dokumen** (Dokumen Resource)
   - Kolom: Nama Dokumen, Jenis Dokumen, Judul Permohonan, Path File, Diupload Oleh, Waktu Upload
   - Nama File: `dokumen-{id}.xlsx`

## Cara Menggunakan

### Langkah-langkah Export Data:

1. **Buka Halaman Resource**
   - Navigasi ke halaman salah satu Resource yang mendukung export (Permohonan, Pembayaran, Jenis Pengujian, Pengguna, atau Dokumen)

2. **Klik Tombol "Unduh Excel"**
   - Tombol ini berada di bagian atas kanan table (di sebelah tombol Create/Tambah)
   - Label tombol: **Unduh Excel**

3. **Pilih Kolom yang Ingin Diexport**
   - Setelah mengklik tombol, sebuah modal akan muncul
   - Pilih kolom-kolom mana yang ingin Anda include dalam file Excel
   - Secara default, semua kolom sudah tercentang

4. **Pilih Format File**
   - Anda bisa memilih format: **XLSX** (Excel Modern) atau **CSV** (Comma Separated Values)
   - Default: XLSX (Excel)

5. **Klik Tombol Export**
   - Klik tombol Export untuk memproses data
   - Sistem akan memproses data secara asinkron menggunakan queue jobs

6. **Download File**
   - Setelah proses selesai, Anda akan melihat notifikasi
   - Klik link download untuk mengunduh file Excel

### Fitur Filtering & Sorting Sebelum Export

- **Sebelum mengklik Export**, Anda bisa:
  - Mencari/filter data menggunakan search box dan filter yang tersedia
  - Mengurutkan data dengan mengklik header kolom
  - Mengubah jumlah item per halaman
  
- Data yang ditampilkan di table akan di-export, sehingga Anda bisa mengontrol data apa saja yang akan diinclude dalam export.

## Struktur File Exporter

Setiap Resource memiliki file Exporter terpisah di folder `app/Filament/Exports/`:

```
app/Filament/Exports/
├── PermohonanExporter.php
├── PembayaranExporter.php
├── JenisPengujianExporter.php
├── UserExporter.php
└── DokumenExporter.php
```

### Format State Kolom

Setiap kolom di-format sesuai dengan jenis data:

- **Boolean**: Diformat menjadi "Ya" atau "Tidak"
- **Currency**: Diformat dengan prefix "Rp" dan separator ribuan
- **Status**: Diformat dengan label yang lebih readable (misal: "Menunggu Verifikasi" daripada "menunggu_verifikasi")
- **Relationship**: Menampilkan data dari relasi menggunakan dot notation (misal: `pemohon.name`)

## Keamanan & Akses

- File yang di-export hanya dapat didownload oleh user yang menjalankan export tersebut
- Autentikasi diperlukan untuk mengakses fitur export
- Setiap export tercatat dalam database dengan informasi user dan timestamp

## Teknologi yang Digunakan

- **Filament v3.3**: Framework admin panel
- **OpenSpout**: Library untuk membaca/menulis file Excel
- **Laravel Queue**: Untuk memproses export secara asinkron
- **Database Notifications**: Untuk notifikasi status export

## Tips & Tricks

1. **Export Data Besar**
   - Untuk data yang sangat besar (>10.000 baris), gunakan filter untuk membatasi data terlebih dahulu
   - Data akan di-chunk menjadi 100 baris per job untuk efisiensi memory

2. **Format Tanggal**
   - Tanggal otomatis diformat sesuai dengan zona waktu server
   - Format: Y-m-d H:i:s (misal: 2024-12-10 14:30:00)

3. **Membuat Custom Kolom**
   - Jika ingin menambah kolom baru di export, edit file Exporter yang sesuai
   - Tambahkan baris baru di dalam method `getColumns()`:
     ```php
     ExportColumn::make('column_name')
         ->label('Label Kolom')
         ->formatStateUsing(fn ($state) => /* format logic */)
     ```

## Troubleshooting

### Masalah: Tombol Export tidak muncul
- Pastikan Anda memiliki akses ke Resource tersebut
- Clear cache: `php artisan cache:clear`
- Restart queue listener jika menggunakan async

### Masalah: Export stuck/loading lama
- Cek apakah queue listener berjalan: `php artisan queue:listen`
- Periksa log di `storage/logs/`
- Reduce chunk size di Exporter jika ada memory issue

### Masalah: File tidak bisa didownload
- Pastikan folder `storage/app` memiliki permission write
- Cek apakah user memiliki akses view pada export model
- Hubungi admin jika problem persists

## File dan Struktur Terkait

```
app/
├── Filament/
│   ├── Exports/
│   │   ├── PermohonanExporter.php
│   │   ├── PembayaranExporter.php
│   │   ├── JenisPengujianExporter.php
│   │   ├── UserExporter.php
│   │   └── DokumenExporter.php
│   └── Resources/
│       ├── PermohonanResource.php (headerActions dengan ExportAction)
│       ├── PembayaranResource.php
│       ├── JenisPengujianResource.php
│       ├── UserResource.php
│       └── DokumenResource.php
└── Models/ (models yang sudah ada)
```

## Update Log

- **2024-12-10**: Fitur Export Excel diimplementasikan untuk semua 5 Resource utama
- Menggunakan Filament ExportAction v3.3
- Format output: XLSX dan CSV

## Referensi

- [Filament Export Action Documentation](https://filamentphp.com/docs/3.x/actions/prebuilt-actions/export)
- [OpenSpout Documentation](https://github.com/openspout/openspout)
