# Fitur Pembayaran - Payment Gateway Duitku

## Daftar Isi
1. [Overview](#overview)
2. [Instalasi & Setup](#instalasi--setup)
3. [Flow Pembayaran](#flow-pembayaran)
4. [Struktur Database](#struktur-database)
5. [API Integration](#api-integration)
6. [Testing](#testing)
7. [Troubleshooting](#troubleshooting)

## Overview

Fitur pembayaran telah diintegrasikan menggunakan payment gateway **Duitku** yang mendukung berbagai metode pembayaran:
- Virtual Account (VA) - BCA, Mandiri, Maybank, BNI, CIMB, Permata, dll
- Kartu Kredit (Visa, Mastercard, JCB)
- E-Wallet (OVO, ShopeePay, DANA, LinkAja, dll)
- QRIS
- Paylater (Indodana, ATOME)
- E-Banking (Jenius Pay)

## Instalasi & Setup

### 1. Konfigurasi Environment

Edit file `.env` dan tambahkan konfigurasi Duitku:

```env
DUITKU_MERCHANT_CODE=DSKRIPSI
DUITKU_API_KEY=c8dc37ed95820f1cedd9958ecad3f1a7
DUITKU_SANDBOX_MODE=true
DUITKU_CALLBACK_URL=http://skripsi.test/api/payment/callback
DUITKU_RETURN_URL=http://skripsi.test/payment/return
DUITKU_EXPIRY_PERIOD=1440
```

**Penjelasan Parameter:**
- `DUITKU_MERCHANT_CODE`: Kode merchant dari Duitku dashboard
- `DUITKU_API_KEY`: API Key untuk autentikasi (JANGAN COMMIT!)
- `DUITKU_SANDBOX_MODE`: Set `true` untuk testing, `false` untuk production
- `DUITKU_CALLBACK_URL`: URL untuk menerima notifikasi pembayaran dari Duitku
- `DUITKU_RETURN_URL`: URL untuk redirect pengguna setelah pembayaran
- `DUITKU_EXPIRY_PERIOD`: Waktu ekspirasi pembayaran dalam menit (default: 1440 = 24 jam)

### 2. Jalankan Migration

```bash
php artisan migrate
```

Migration yang akan dijalankan:
- `2025_12_06_000000_update_permohonan_payment_status.php` - Tambah kolom `is_paid` dan `is_sample_ready` ke tabel `permohonans`
- `2025_12_06_000001_create_pembayarans_table.php` - Buat tabel untuk riwayat pembayaran
- `2025_12_06_000002_create_payment_methods_table.php` - Buat tabel cache metode pembayaran

### 3. Sinkronisasi Metode Pembayaran

Metode pembayaran akan disinkronisasi otomatis ketika pemohon membuka halaman pembayaran. Anda juga bisa menyinkronkan secara manual melalui command:

```bash
php artisan payment:sync-methods {amount}
```

Contoh:
```bash
php artisan payment:sync-methods 100000
```

## Flow Pembayaran

### Alur Bisnis

```
1. Pemohon membuat permohonan
   ↓
2. Petugas memeriksa permohonan
   ↓
3. Jika diterima → Status menjadi "Menunggu Pembayaran & Sampel"
   ↓
4. Pemohon melakukan pembayaran melalui website
   ├── Masuk ke halaman pembayaran
   ├── Pilih metode pembayaran
   └── Redirect ke Duitku payment page
   ↓
5. Duitku mengirim callback ke sistem
   ↓
6. Sistem mengupdate status `is_paid = true` otomatis
   ↓
7. Petugas centang checkbox "Sampel Sudah Diterima" (`is_sample_ready = true`)
   ↓
8. Petugas bisa mulai pengujian
```

### URL Routes

#### Untuk Pemohon (authenticated)
```
GET  /payment/permohonan/{permohonan}          → Halaman pembayaran
POST /payment/permohonan/{permohonan}/process  → Proses pembayaran (redirect ke Duitku)
GET  /payment/permohonan/{permohonan}/history  → Riwayat pembayaran
GET  /payment/invoice/{pembayaran}             → Download invoice
```

#### Untuk Duitku (tidak perlu auth)
```
POST /api/payment/callback  → Webhook dari Duitku
GET  /payment/return        → Redirect setelah pembayaran
```

## Struktur Database

### Tabel: `pembayarans`

| Kolom | Tipe | Keterangan |
|-------|------|-----------|
| id | bigint | Primary key |
| permohonan_id | bigint | Foreign key ke permohonans |
| user_id | bigint | Foreign key ke users |
| amount | decimal(12,2) | Nominal pembayaran |
| payment_method | varchar | Kode metode (VA, VC, OV, dll) |
| payment_method_name | varchar | Nama metode pembayaran |
| merchant_order_id | varchar | Order ID unik dari merchant |
| duitku_reference | varchar | Reference dari Duitku |
| va_number | varchar | Nomor VA (jika metode VA) |
| payment_url | text | URL payment page dari Duitku |
| status | enum | pending/success/failed/expired |
| result_code | varchar | Response code dari Duitku (00=sukses, 01=gagal) |
| paid_at | timestamp | Waktu pembayaran berhasil |
| notes | text | Catatan tambahan |
| created_at | timestamp | |
| updated_at | timestamp | |
| deleted_at | timestamp | Soft delete |

### Tabel: `payment_methods`

| Kolom | Tipe | Keterangan |
|-------|------|-----------|
| id | bigint | Primary key |
| payment_method | varchar | Kode metode (VA, VC, OV, dll) |
| payment_name | varchar | Nama metode pembayaran |
| payment_image | text | URL logo dari Duitku |
| total_fee | decimal(12,2) | Biaya pembayaran |
| is_active | boolean | Status aktif |
| created_at | timestamp | |
| updated_at | timestamp | |
| deleted_at | timestamp | |

### Update Tabel: `permohonans`

Tambahan kolom:
```sql
is_paid BOOLEAN DEFAULT FALSE          -- Pembayaran berhasil (otomatis TRUE dari callback)
is_sample_ready BOOLEAN DEFAULT FALSE  -- Sampel sudah diterima (manual di-centang petugas)
```

## API Integration

### Service: DuitkuPaymentService

Lokasi: `app/Services/DuitkuPaymentService.php`

#### Method-method utama:

```php
// 1. Generate Signature
public function generateSignature(string $merchantCode, string $orderId, int $amount, string $apiKey): string

// 2. Get Payment Methods dari Duitku
public function getPaymentMethods(int $amount): array

// 3. Sinkronisasi Payment Methods ke Database
public function syncPaymentMethods(int $amount): bool

// 4. Create Payment Request
public function createPaymentRequest(Pembayaran $pembayaran, string $paymentMethod): array

// 5. Verify Callback Signature
public function verifyCallbackSignature(array $data): bool

// 6. Check Transaction Status
public function checkTransactionStatus(Pembayaran $pembayaran): array
```

### Controller: PaymentController

Lokasi: `app/Http/Controllers/PaymentController.php`

#### Method-method:

```php
public function show(Permohonan $permohonan)              // Tampilkan halaman pembayaran
public function process(Request $request, Permohonan $permohonan) // Proses pembayaran
public function callback(Request $request)                // Webhook dari Duitku
public function return(Request $request)                  // Redirect setelah pembayaran
public function history(Permohonan $permohonan)          // Riwayat pembayaran
public function invoice(Pembayaran $pembayaran)          // Download invoice
```

## Registrasi di Duitku Dashboard

Untuk menghubungkan dengan Duitku, Anda perlu melakukan setup di Duitku Merchant Portal:

### Langkah-langkah:

1. **Buka Duitku Merchant Portal**: https://passport.duitku.com/merchant
2. **Login dengan akun Duitku Anda**
3. **Buat/Edit Project**:
   - **Nama Proyek**: skripsi
   - **Website Proyek**: http://skripsi.test/
   - **Callback URL**: http://skripsi.test/api/payment/callback
4. **Dapatkan Credentials**:
   - Merchant Code
   - API Key
   - Masukkan ke `.env` file
5. **Aktifkan Metode Pembayaran** yang ingin Anda gunakan
6. **Test menggunakan Sandbox Mode** (`DUITKU_SANDBOX_MODE=true`)

### Kredensial Saat Ini:

```
Merchant Code: DSKRIPSI
API Key: c8dc37ed95820f1cedd9958ecad3f1a7 ⚠️ SIMPAN DENGAN AMAN!
Status: Sandbox Mode (untuk testing)
```

## Testing

### Test Data Duitku Sandbox

#### Virtual Account (VA)
Gunakan demo transaction page: https://sandbox.duitku.com/payment/demo/demosuccesstransaction.aspx

#### Kartu Kredit
- VISA: `4000 0000 0000 0044` | CVV: `123` | Exp: `03/33`
- Mastercard: `5500 0000 0000 0004` | CVV: `123` | Exp: `03/33`

#### E-Wallet (Sandbox)
Lihat dokumentasi Duitku untuk test credentials setiap metode

### Test Flow Lokal

1. **Set Sandbox Mode**
   ```env
   DUITKU_SANDBOX_MODE=true
   ```

2. **Buat Permohonan Test**
   - Login sebagai Pemohon
   - Buat permohonan baru

3. **Terima Permohonan (sebagai Petugas)**
   - Login sebagai Petugas
   - Buka permohonan dan klik "Terima - Lanjut Pembayaran"
   - Status berubah ke "Menunggu Pembayaran & Sampel"

4. **Akses Halaman Pembayaran**
   - Login sebagai Pemohon
   - Akses URL: `/payment/permohonan/{id}`
   - Pilih metode pembayaran
   - Klik "Lanjutkan ke Pembayaran"
   - Akan redirect ke payment page Duitku

5. **Simulasi Pembayaran**
   - Gunakan test data di atas
   - Selesaikan pembayaran
   - Callback akan otomatis dikirim

6. **Verifikasi**
   - Check di admin panel → Pembayaran
   - Verify bahwa `is_paid` berubah menjadi `true`

### Troubleshooting Callback

Jika callback tidak diterima:

1. **Check Logs**
   ```bash
   tail -f storage/logs/laravel.log
   ```

2. **Whitelist IP Duitku** (untuk production)
   - Production: `182.23.85.8`, `182.23.85.9`, `182.23.85.10`, `182.23.85.13`, `182.23.85.14`, `103.177.101.184`, `103.177.101.185`, `103.177.101.186`, `103.177.101.189`, `103.177.101.190`
   - Sandbox: `182.23.85.11`, `182.23.85.12`, `103.177.101.187`, `103.177.101.188`

3. **Verifikasi Signature**
   - Pastikan `DUITKU_API_KEY` sudah benar
   - Callback signature diverifikasi dengan MD5

## Filament Integration

### Admin Panel - Pembayaran Resource

Lokasi: `app/Filament/Resources/PembayaranResource.php`

**Features:**
- List semua pembayaran dengan filter status
- View detail pembayaran
- Monitor status pembayaran
- Edit notes (untuk internal use)

**Permissions Required:**
- `view_pembayaran`
- `create_pembayaran`
- `update_pembayaran`
- `delete_pembayaran`

### Permohonan Resource Updates

**Kolom Baru di Table:**
- `is_paid` - Indikator pembayaran (icon)
- `is_sample_ready` - Indikator sampel (icon)

**Form Updates:**
- Section "Status Pembayaran & Sampel" dengan 2 checkboxes
- `is_paid` - Read-only (otomatis dari callback)
- `is_sample_ready` - Editable oleh Petugas

## Security Considerations

⚠️ **Penting:**

1. **Jangan commit API Key**
   - Selalu gunakan `.env` dan `.env.example`
   - Tambahkan `.env` ke `.gitignore`

2. **Signature Verification**
   - Semua callback dari Duitku di-verify dengan signature
   - Hindari penggunaan callback tanpa verifikasi

3. **HTTPS di Production**
   - Ubah `DUITKU_CALLBACK_URL` menjadi HTTPS
   - Ubah `DUITKU_SANDBOX_MODE` menjadi `false`

4. **Rate Limiting**
   - Implementasikan rate limiting di callback endpoint
   - Cegah duplicate payments

5. **Audit Log**
   - Semua transaksi dicatat di database
   - Monitor perubahan status pembayaran

## Troubleshooting

### 1. Error: "Metode pembayaran tidak tersedia"
**Solusi:**
- Pastikan sandbox mode sesuai dengan environment
- Check internet connection
- Verify Duitku credentials di `.env`

### 2. Callback tidak diterima
**Solusi:**
- Check firewall/IP whitelist
- Verify callback URL di Duitku dashboard
- Check logs: `storage/logs/laravel.log`

### 3. Signature mismatch
**Solusi:**
- Pastikan API Key sudah benar
- Verify parameter yang dikirim

### 4. Payment stuck di "Pending"
**Solusi:**
- Jalankan: `php artisan payment:check-status {pembayaran_id}`
- Check status di Duitku dashboard
- Manual update jika diperlukan (admin only)

## Command Artisan

```bash
# Sinkronisasi payment methods
php artisan payment:sync-methods {amount}

# Check status pembayaran
php artisan payment:check-status {pembayaran_id}

# Resend callback (manual)
php artisan payment:resend-callback {pembayaran_id}
```

## Production Checklist

Sebelum go-live ke production:

- [ ] Ubah `DUITKU_SANDBOX_MODE` ke `false`
- [ ] Update Merchant Code dan API Key untuk production
- [ ] Update callback URL dan return URL ke domain production
- [ ] Setup HTTPS/SSL certificate
- [ ] Whitelist IP Duitku production di firewall
- [ ] Setup email notifications untuk admin
- [ ] Setup backup dan disaster recovery
- [ ] Test end-to-end dengan real payment (minimal 1 transaksi)
- [ ] Monitor logs dan error rates
- [ ] Setup monitoring dan alerting

## Support & Documentation

- **Dokumentasi Duitku**: https://docs.duitku.com/api/en
- **Duitku Merchant Portal**: https://passport.duitku.com/merchant
- **Contact Duitku Support**: support@duitku.com

---

**Last Updated**: Desember 6, 2025
**Status**: Production Ready
