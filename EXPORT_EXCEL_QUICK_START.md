# Quick Start Guide - Export Excel Feature

## 🚀 Cara Cepat Menggunakan Fitur Export

### Step 1: Login ke Admin Panel
```
URL: http://localhost:8000/admin
```

### Step 2: Navigasi ke Resource
Pilih salah satu dari:
- 📋 **Permohonan** - Export data permohonan
- 💰 **Pembayaran** - Export data pembayaran  
- 🧪 **Jenis Pengujian** - Export tipe-tipe pengujian
- 👥 **Pengguna** - Export data user
- 📄 **Dokumen** - Export dokumen

### Step 3: Klik Tombol "Unduh Excel"
Tombol berada di bagian atas kanan tabel, sebelah tombol "Create/Tambah"

### Step 4: Atur Kolom Export
- Modal akan muncul menampilkan semua kolom yang tersedia
- Centang/unccentang kolom sesuai kebutuhan
- Gunakan search untuk mencari kolom tertentu

### Step 5: Pilih Format
```
Pilih: ☑ XLSX (Excel modern) atau ☐ CSV (Plain text)
```

### Step 6: Klik "Export"
- Sistem akan memproses data
- Anda akan melihat notifikasi progress
- File siap didownload setelah selesai

### Step 7: Download & Buka
- Klik link download di notifikasi
- Buka file dengan Microsoft Excel, Google Sheets, atau LibreOffice

---

## 💡 Tips Menggunakan Export

### Filter Sebelum Export
Ingin export data tertentu saja? Filter dulu!

**Contoh:**
```
1. Pilih filter Status = "Selesai"
2. Klik "Unduh Excel"
3. File akan berisi hanya data dengan status "Selesai"
```

### Sort Data
Klik header kolom untuk mengurutkan sebelum export:
```
👆 Klik header "Total Biaya" untuk sort ascending/descending
```

### Export Besar
Untuk data >10.000 baris:
```
1. Gunakan filter untuk reduce data
2. Atau gunakan pagination limit
3. Export akan otomatis di-chunk untuk efisiensi
```

---

## 📊 Contoh Output File

Setiap file Excel akan berisi:
```
📌 Header baris pertama dengan nama kolom
📌 Data mulai baris ke-2
📌 Format currency otomatis untuk harga/nominal
📌 Format date otomatis untuk tanggal
📌 Boolean otomatis menjadi "Ya"/"Tidak"
```

### Contoh: permohonan-12345.xlsx
```
| Judul Permohonan | Status | Pemohon | Total Biaya | ... |
|---|---|---|---|---|
| Uji Sampel A | Selesai | Surya U | Rp 6.600.000 | ... |
| Uji Sampel B | Menunggu Verifikasi | Andi | Rp 2.500.000 | ... |
```

---

## 🔒 Keamanan

✅ Hanya user yang authenticated yang bisa export
✅ Hanya user yang authorized untuk resource tersebut
✅ File hanya bisa didownload oleh user pembuat export
✅ Setiap export tercatat dengan user & timestamp

---

## ❓ FAQ

**Q: Bisakah saya export data yang tidak terlihat di halaman?**
A: Ya! Export akan mengambil semua data sesuai filter Anda, bukan hanya halaman yang ditampilkan.

**Q: Berapa lama waktu export?**
A: Tergantung jumlah data. Biasanya < 10 detik untuk 1000 baris.

**Q: Bisa custom kolom yang diexport?**
A: Bisa! Lihat dokumentasi lengkap di `FITUR_EXPORT_EXCEL.md`

**Q: File mengapa tidak muncul?**
A: Periksa:
- Apakah sudah selesai processing (cek notifikasi)
- Apakah popup blocker aktif
- Coba refresh halaman

**Q: Export stuck loading?**
A: 
- Pastikan queue listener running: `php artisan queue:listen`
- Atau gunakan database queue: `php artisan queue:work database`

---

## 🛠️ Troubleshooting

| Problem | Solusi |
|---|---|
| Tombol "Unduh Excel" tidak ada | Refresh halaman, atau login ulang |
| File tidak bisa didownload | Cek folder storage ada write permission |
| Export timeout | Gunakan filter untuk reduce data volume |
| Export error | Cek console/logs di terminal |

---

## 📚 Dokumentasi Lengkap

Untuk dokumentasi lebih detail, baca:
- `FITUR_EXPORT_EXCEL.md` - Dokumentasi lengkap fitur
- `EXPORT_EXCEL_CHECKLIST.md` - Checklist & persiapan deployment

---

## 🎯 Resource Terkait

**File Exporter:**
```
app/Filament/Exports/
├── PermohonanExporter.php
├── PembayaranExporter.php
├── JenisPengujianExporter.php
├── UserExporter.php
└── DokumenExporter.php
```

**Resource yang Updated:**
```
app/Filament/Resources/
├── PermohonanResource.php (+ headerActions)
├── PembayaranResource.php (+ headerActions)
├── JenisPengujianResource.php (+ headerActions)
├── UserResource.php (+ headerActions)
└── DokumenResource.php (+ headerActions)
```

---

**Happy Exporting!** 📊✨
