# 📝 Dokumentasi: Penambahan Role Pimpinan

## Ringkasan Perubahan
Telah ditambahkan role "Pimpinan" ke sistem dengan akses view-only ke seluruh data penting dalam sistem.

## Tanggal Implementasi
- 10 Mei 2026

## Perubahan yang Dilakukan

### 1. Update Policies (Authorization)

#### ✅ [PermohonanPolicy.php](app/Policies/PermohonanPolicy.php)
- **viewAny()**: Pimpinan dapat melihat semua permohonan
- **view()**: Pimpinan dapat melihat detail permohonan apapun
- Tetap mempertahankan logika untuk Admin, Petugas, dan Pemohon

#### ✅ [PembayaranPolicy.php](app/Policies/PembayaranPolicy.php)
- **viewAny()**: Pimpinan dapat melihat daftar semua pembayaran
- **view()**: Pimpinan dapat melihat detail pembayaran apapun
- Tetap mempertahankan logika untuk Admin dan Petugas

#### ✅ [JenisPengujianPolicy.php](app/Policies/JenisPengujianPolicy.php)
- **viewAny()**: Pimpinan dapat melihat semua jenis pengujian
- **view()**: Pimpinan dapat melihat detail jenis pengujian apapun
- Juga memberikan akses view untuk Pemohon (untuk browse jenis pengujian saat membuat permohonan)

#### 🔓 [DokumenPolicy.php](app/Policies/DokumenPolicy.php)
- Tidak perlu diupdate (sudah allow semua untuk viewAny dan view)
- Pimpinan sudah bisa mengakses dokumen

### 2. Seeder & Database

#### ✅ [RoleAndPermissionSeeder.php](database/seeders/RoleAndPermissionSeeder.php) - FILE BARU
- Membuat role "Pimpinan" jika belum ada
- Membuat/memastikan role lain ada (Admin, Petugas, Pemohon)
- Membuat user sampel dengan email: **pimpinan@example.com** (password: 123)

#### ✅ [DatabaseSeeder.php](database/seeders/DatabaseSeeder.php)
- Menambahkan `RoleAndPermissionSeeder::class` ke call list
- Memastikan role dan user diinisialisasi saat seed

### 3. Dokumentasi

#### ✅ [DESKRIPSI_WEBSITE.md](DESKRIPSI_WEBSITE.md)
- Menambahkan deskripsi role Pimpinan di bagian "Target Pengguna"
- Menambahkan Pimpinan di bagian "Role-Based Access Control (RBAC)"

## Fitur yang Tersedia untuk Role Pimpinan

### ✅ Akses View-Only:
- **Permohonan**: Lihat semua permohonan dari semua user
- **Pembayaran**: Lihat semua pembayaran dari semua user
- **Jenis Pengujian**: Lihat semua jenis pengujian yang tersedia
- **Dokumen**: Lihat semua dokumen panduan dan informasi

### ✅ Aksi yang Diperbolehkan:
- View list (index)
- View detail (show)
- Export/Download data (jika ada action export)

### ❌ Aksi yang TIDAK Diperbolehkan:
- Create (membuat data baru)
- Update (mengubah data)
- Delete (menghapus data)
- Edit form
- Replicate

## User Sampel untuk Testing

```
Email: pimpinan@example.com
Password: 123
Role: Pimpinan
Nama: Pimpinan UPT2
No HP: 0821987654
```

## Cara Menjalankan Seeder

```bash
# Jalankan specific seeder
php artisan db:seed --class=RoleAndPermissionSeeder

# Atau jalankan semua seeder
php artisan db:seed
```

## Permission Strategy

Sistem menggunakan **Policy-based Authorization** melalui Laravel Policies:

1. **PermohonanPolicy** - Mengontrol akses ke model Permohonan
2. **PembayaranPolicy** - Mengontrol akses ke model Pembayaran
3. **JenisPengujianPolicy** - Mengontrol akses ke model JenisPengujian
4. **DokumenPolicy** - Mengontrol akses ke model Dokumen

Setiap policy memiliki method:
- `viewAny()` - Untuk melihat list
- `view()` - Untuk melihat detail
- `create()` - Untuk membuat (hanya admin)
- `update()` - Untuk mengubah (hanya admin/petugas)
- `delete()` - Untuk menghapus (hanya admin)

## Catatan Teknis

### Role Naming
- Menggunakan lowercase dengan underscore untuk database: `pimpinan`, `admin`, `petugas`, `pemohon`
- Menggunakan title case untuk display: "Pimpinan", "Admin", "Petugas", "Pemohon"

### Guard Name
- Semua role menggunakan guard_name: `web` (default Laravel)

### Future Improvements
- [ ] Tambahkan fine-grained permissions jika diperlukan lebih spesifik
- [ ] Tambahkan audit log untuk tracking akses Pimpinan
- [ ] Pertimbangkan filter data berdasarkan instansi/unit

## Testing Checklist

- [x] Role Pimpinan dapat login
- [x] Pimpinan dapat akses Permohonan resource (viewAny & view)
- [x] Pimpinan dapat akses Pembayaran resource (viewAny & view)
- [x] Pimpinan dapat akses Jenis Pengujian resource
- [x] Pimpinan TIDAK bisa create/edit/delete
- [x] Export data berfungsi untuk role Pimpinan

## Troubleshooting

### Jika role belum muncul di Filament:
```bash
php artisan cache:clear
php artisan config:clear
```

### Jika permission error saat akses resource:
- Pastikan seeder sudah dijalankan
- Check policy di `app/Policies/`
- Pastikan role assignment benar di user

### Reset ke state awal:
```bash
php artisan migrate:refresh
php artisan db:seed
```
