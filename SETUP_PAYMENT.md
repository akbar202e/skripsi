# Setup Pembayaran - Panduan Langkah Demi Langkah

## Ringkasan Cepat Setup

Fitur pembayaran sudah sepenuhnya terintegrasi. Ikuti langkah-langkah di bawah untuk setup final dan test.

## 1. Update Environment Variables

Edit file `.env` di root project dan pastikan sudah ada konfigurasi Duitku:

```env
# Duitku Payment Gateway Configuration
DUITKU_MERCHANT_CODE=DSKRIPSI
DUITKU_API_KEY=c8dc37ed95820f1cedd9958ecad3f1a7
DUITKU_SANDBOX_MODE=true
DUITKU_CALLBACK_URL=http://skripsi.test/api/payment/callback
DUITKU_RETURN_URL=http://skripsi.test/payment/return
DUITKU_EXPIRY_PERIOD=1440
```

**⚠️ PENTING**: Jangan commit API key ke Git!

## 2. Jalankan Database Migration

```bash
cd c:\laragon\www\skripsi

# Jalankan migration
php artisan migrate

# Seeding payment methods
php artisan db:seed PaymentMethodSeeder
```

Atau sekaligus:
```bash
php artisan migrate --seed
```

Tabel yang dibuat:
- `pembayarans` - Riwayat pembayaran
- `payment_methods` - Cache metode pembayaran dari Duitku
- Update kolom di `permohonans`: `is_paid`, `is_sample_ready`

## 3. Clear Cache

```bash
php artisan cache:clear
php artisan config:clear
```

## 4. Test Setup

### 4.1 Verifikasi File & Folder

Pastikan file-file berikut sudah ada:

```
✓ config/duitku.php
✓ app/Services/DuitkuPaymentService.php
✓ app/Http/Controllers/PaymentController.php
✓ app/Models/Pembayaran.php
✓ app/Models/PaymentMethod.php
✓ app/Filament/Resources/PembayaranResource.php
✓ app/Filament/Resources/PembayaranResource/Pages/ListPembayarans.php
✓ app/Filament/Resources/PembayaranResource/Pages/ViewPembayaran.php
✓ database/migrations/2025_12_06_000000_update_permohonan_payment_status.php
✓ database/migrations/2025_12_06_000001_create_pembayarans_table.php
✓ database/migrations/2025_12_06_000002_create_payment_methods_table.php
✓ routes/web.php (sudah update)
✓ app/Models/Permohonan.php (sudah update)
✓ resources/views/payment/show.blade.php
✓ resources/views/payment/history.blade.php
✓ resources/views/payment/invoice.blade.php
```

### 4.2 Test Via Routes

Gunakan browser atau Postman untuk test:

```bash
# Start development server
php artisan serve

# Atau via Laragon
# Klik "Start All" di Laragon
```

Akses: `http://skripsi.test`

## 5. Full Test Flow

### Step 1: Login sebagai Pemohon

1. Buka `http://skripsi.test`
2. Login dengan akun Pemohon (jika tidak ada, buat dulu via admin panel)

### Step 2: Buat Permohonan Baru

1. Masuk ke admin panel
2. Menu: Permohonan → Create
3. Isi form:
   - Judul
   - Isi/Deskripsi
   - Upload Surat Permohonan
   - Pilih Jenis Pengujian (akan otomatis hitung total biaya)
4. Submit

### Step 3: Login sebagai Petugas & Terima Permohonan

1. Logout (jika sudah login sebagai pemohon)
2. Login sebagai Petugas
3. Menu: Permohonan
4. Cari permohonan yang baru dibuat
5. Klik "Terima - Lanjut Pembayaran"
   - Status berubah dari "Menunggu Verifikasi" → "Menunggu Pembayaran & Sampel"

### Step 4: Login sebagai Pemohon & Akses Halaman Pembayaran

1. Logout
2. Login sebagai Pemohon
3. Buka: `http://skripsi.test/payment/permohonan/{id}`
   - Ganti `{id}` dengan ID permohonan
   - Contoh: `http://skripsi.test/payment/permohonan/1`

### Step 5: Pilih Metode & Lanjutkan Pembayaran

1. Halaman menampilkan:
   - Info Permohonan
   - List Metode Pembayaran dari Duitku
   - Total yang harus dibayar
2. Pilih salah satu metode (contoh: "BCA Virtual Account")
3. Klik "Lanjutkan ke Pembayaran"
4. Akan redirect ke payment page Duitku

### Step 6: Simulasi Pembayaran di Sandbox

Di halaman Duitku:

1. **Virtual Account**: Gunakan demo: https://sandbox.duitku.com/payment/demo/demosuccesstransaction.aspx
2. **Kartu Kredit**: 
   - Nomor: `4000 0000 0000 0044`
   - CVV: `123`
   - Exp: `03/33`
3. Selesaikan pembayaran

### Step 7: Verifikasi Callback & Status

Setelah pembayaran:

1. Callback otomatis dikirim dari Duitku
2. Check di admin panel:
   - Menu: Pembayaran
   - Verifikasi bahwa pembayaran sudah tercatat dengan status "success"
3. Check Permohonan:
   - Refresh halaman permohonan
   - Lihat `is_paid` berubah menjadi TRUE ✓

### Step 8: Login sebagai Petugas & Centang Sampel

1. Login sebagai Petugas
2. Buka Permohonan
3. Edit dan centang checkbox "Sampel Sudah Diterima"
4. Sekarang button "Mulai Pengujian" akan aktif

### Step 9: Lanjutkan Workflow Pengujian

Dari sini, workflow lanjut seperti biasa:
- Mulai Pengujian → status "Sedang Diuji"
- Selesai Pengujian → status "Menyusun Laporan"
- Finalisasi Selesai → status "Selesai"

## 6. Fitur-Fitur Pembayaran

### A. Halaman Pembayaran (`/payment/permohonan/{id}`)

**Fitur:**
- View info permohonan
- View metode pembayaran yang tersedia
- Pilih metode pembayaran
- Lanjut ke payment page Duitku
- Display status pembayaran saat ini
- Lihat riwayat pembayaran

**Kondisi Akses:**
- Hanya pemohon yang bisa akses (`user_id` harus sama)
- Permohonan harus status "menunggu_pembayaran_sampel"

### B. Riwayat Pembayaran (`/payment/permohonan/{id}/history`)

**Fitur:**
- List semua pembayaran untuk permohonan
- Tampilkan status, nominal, metode, waktu
- Download invoice untuk pembayaran yang berhasil

### C. Invoice (`/payment/invoice/{pembayaran_id}`)

**Fitur:**
- Print-friendly invoice
- Download as PDF (bisa via browser print → save as PDF)
- Tampilkan detail pembayaran & permohonan

### D. Admin Panel - Pembayaran Resource

**Fitur:**
- View list semua pembayaran
- Filter by status
- View detail pembayaran
- Monitor status pembayaran secara real-time

## 7. Testing Methods

### Virtual Account (Recommended untuk testing)

Paling mudah untuk testing karena bisa langsung simulasi via demo page.

**Demo URL**: https://sandbox.duitku.com/payment/demo/demosuccesstransaction.aspx

### Credit Card

Test dengan nomor kartu:
```
VISA: 4000 0000 0000 0044
Mastercard: 5500 0000 0000 0004
CVV: 123
Exp: 03/33
```

### E-Wallet & QRIS

Memerlukan app mobile sandbox (download dari Duitku docs)

## 8. Callback Troubleshooting

Jika callback tidak diterima:

### Check 1: Verify Callback URL

```bash
# Di .env, pastikan:
DUITKU_CALLBACK_URL=http://skripsi.test/api/payment/callback
```

### Check 2: Verify di Duitku Dashboard

1. Buka Duitku Merchant Portal
2. Edit Project
3. Verifikasi Callback URL sudah benar
4. Save

### Check 3: Check Logs

```bash
tail -f storage/logs/laravel.log

# Cari "Duitku Callback Received"
```

### Check 4: Test Manual Callback

Gunakan Postman atau curl:

```bash
curl -X POST http://skripsi.test/api/payment/callback \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "merchantCode=DSKRIPSI&merchantOrderId=TEST-001&amount=100000&resultCode=00&signature=xxx"
```

## 9. Important URLs

```
Admin Panel:     http://skripsi.test/admin
Pembayaran Res:  http://skripsi.test/admin/pembayarans
Permohonan:      http://skripsi.test/admin/permohonans
Payment Page:    http://skripsi.test/payment/permohonan/{id}
Payment History: http://skripsi.test/payment/permohonan/{id}/history
Payment Invoice: http://skripsi.test/payment/invoice/{pembayaran_id}

Callback URL:    http://skripsi.test/api/payment/callback
Return URL:      http://skripsi.test/payment/return
```

## 10. Production Setup

Sebelum go-live:

1. **Update Credentials**
   ```env
   DUITKU_MERCHANT_CODE=<production merchant code>
   DUITKU_API_KEY=<production api key>
   DUITKU_SANDBOX_MODE=false
   ```

2. **Update URLs**
   ```env
   DUITKU_CALLBACK_URL=https://yourdomain.com/api/payment/callback
   DUITKU_RETURN_URL=https://yourdomain.com/payment/return
   APP_URL=https://yourdomain.com
   ```

3. **Setup HTTPS/SSL**
   - Get SSL certificate
   - Configure web server
   - Force HTTPS

4. **Whitelist Duitku IP**
   - Production IPs: `182.23.85.8, 182.23.85.9, 182.23.85.10, 182.23.85.13, 182.23.85.14, 103.177.101.184, 103.177.101.185, 103.177.101.186, 103.177.101.189, 103.177.101.190`

5. **Database Backup**
   ```bash
   mysqldump -u root upt > backup_$(date +%Y%m%d_%H%M%S).sql
   ```

6. **Test Real Transaction**
   - Lakukan minimal 1 real payment
   - Verifikasi end-to-end flow

7. **Setup Monitoring**
   - Log rotation
   - Error tracking
   - Payment monitoring

## 11. Permissions & Roles

Pastikan roles sudah setup:

```php
// Untuk Petugas
- view_pembayaran
- view permohonan
- update permohonan

// Untuk Admin
- semua di atas + full access
```

Setup di: Admin Panel → Roles & Permissions

## 12. Support

Jika ada issues:

1. **Check Logs**: `storage/logs/laravel.log`
2. **Check Database**: Lihat tabel `pembayarans`
3. **Check Duitku Dashboard**: Verifikasi transaction di merchant portal
4. **Contact Duitku**: support@duitku.com

## Checklist Setup

- [ ] `.env` sudah update dengan Duitku credentials
- [ ] Migration sudah dijalankan
- [ ] Seeder sudah dijalankan (`php artisan db:seed`)
- [ ] Cache sudah di-clear
- [ ] File & folder sudah lengkap
- [ ] Routes sudah ditest (`php artisan route:list`)
- [ ] Test flow sudah berhasil
- [ ] Callback sudah diterima dengan benar
- [ ] Admin panel Pembayaran sudah bisa diakses
- [ ] Invoice sudah bisa di-download

---

**Setup Date**: Desember 6, 2025
**Status**: Ready for Testing ✓
