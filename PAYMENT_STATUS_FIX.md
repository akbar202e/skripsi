# 🔧 FIX: Payment Status Masih Pending Padahal Transaksi Berhasil

**Tanggal Update**: 7 Desember 2025  
**Issue**: Status pembayaran di web masih pending padahal transaksi di Duitku sudah success  
**Root Cause**: Callback URL tidak bisa diakses dari Duitku (localhost), jadi notifikasi pembayaran tidak diterima aplikasi  

---

## 📋 Penjelasan Masalah

Ketika Anda melakukan pembayaran:

1. ✅ User melakukan pembayaran di Duitku (berhasil)
2. ✅ Duitku menerima pembayaran dan menyimpannya
3. ❌ Duitku mencoba mengirim notifikasi ke callback URL `http://skripsi.test/api/payment/callback` (GAGAL)
4. ❌ User di-redirect ke return URL, tapi status di database masih pending

**Alasan Callback Gagal**:
- URL callback adalah localhost (`skripsi.test`) yang tidak bisa diakses dari server Duitku
- Jadi callback tidak bisa kirim notifikasi pembayaran ke aplikasi Anda
- Status pembayaran tetap pending di database

---

## ✅ Solusi yang Diimplementasikan

Kami mengimplementasikan **3 layer fallback system** untuk memastikan status pembayaran selalu terupdate:

### 1. **Return URL Handler (Layer 1 - Immediate)**
Ketika user berhasil di Duitku dan di-redirect ke `/payment/return`:
- Aplikasi langsung check status transaksi ke Duitku API
- Jika berhasil, update status pembayaran ke `success` dan `is_paid = true`
- Ini menangani kasus di mana callback tidak terima

**File yang diubah**: `app/Http/Controllers/PaymentController.php`

```php
public function return(Request $request)
{
    // 1. Get pembayaran dari merchant_order_id
    $pembayaran = Pembayaran::where('merchant_order_id', $merchantOrderId)->first();
    
    // 2. Check status ke Duitku API
    $status = $this->duitkuService->checkTransactionStatus($pembayaran);
    
    // 3. Update status jika success
    if ($status['statusCode'] === '00') {
        $pembayaran->update(['status' => 'success', 'paid_at' => now()]);
        $pembayaran->permohonan->update(['is_paid' => true]);
        return redirect()->with('success', 'Pembayaran berhasil!');
    }
}
```

### 2. **Manual Command (Layer 2 - Periodic Check)**
Command baru yang bisa dijalankan secara berkala (via cron job) untuk check semua pending payments:

```bash
php artisan payment:check-pending
```

**Fitur**:
- Check semua pembayaran yang status `pending` dan dibuat dalam 24 jam terakhir
- Query ke Duitku API untuk mendapatkan status terbaru
- Auto-update status jika ada yang berhasil atau gagal
- Logging lengkap untuk audit trail

**File yang dibuat**: `app/Console/Commands/CheckPendingPayments.php`

### 3. **Callback Handler (Layer 3 - Real-time)**
Jika di kemudian hari URL callback bisa diakses (misalnya saat production dengan domain real):
- Endpoint `/api/payment/callback` tetap siap menerima notifikasi real-time
- Verify signature dan update status immediately

---

## 🚀 Cara Menggunakan Solusi

### Opsi A: Manual Check (Saat Ini - Recommended)

**Saat user selesai pembayaran**:
1. User akan otomatis di-redirect ke `/payment/return`
2. Sistem akan check status ke Duitku dan update otomatis
3. Status akan langsung terupdate menjadi `success` dan `is_paid = true`

### Opsi B: Periodic Check (Setup Cron Job)

Jalankan command berikut setiap jam atau beberapa kali per hari:

```bash
php artisan payment:check-pending
```

Untuk setup otomatis di cron job, tambahkan ke `app/Console/Kernel.php`:

```php
protected function schedule(Schedule $schedule)
{
    // Check pending payments setiap 15 menit
    $schedule->command('payment:check-pending')->everyFifteenMinutes();
}
```

### Opsi C: Kombinasi (Best Practice)

1. **Immediate**: Return URL sudah handle (Layer 1) ✅
2. **Fallback**: Jalankan periodic check setiap 30 menit (Layer 2)
3. **Real-time**: Callback endpoint tetap aktif untuk production (Layer 3)

---

## 📊 Testing Solusi

### Cara Test:

1. **Lakukan pembayaran testing**:
   - Buka halaman pembayaran
   - Pilih metode pembayaran (coba credit card dengan data testing)
   - Selesaikan pembayaran di Duitku

2. **Perhatikan Redirect**:
   - Setelah pembayaran, Anda akan di-redirect ke `/payment/return`
   - Sistem akan check status ke Duitku
   - Status akan otomatis terupdate

3. **Verify Status**:
   - Cek di database: `SELECT * FROM pembayarans WHERE id = X;`
   - Status harus `success` (bukan `pending`)
   - `is_paid` di table `permohonans` harus `true`

4. **Alternative - Manual Check**:
   ```bash
   php artisan payment:check-pending --limit=10
   ```
   Akan menampilkan semua pending payments dan update statusnya

---

## 📝 Detail Implementasi

### PaymentController - Return Method (Enhanced)

**Perubahan**:
- ✅ Tambahan logging untuk debug
- ✅ Lebih robust error handling
- ✅ Update status berdasarkan response Duitku
- ✅ Better user feedback message

### DuitkuPaymentService - New Methods

**Method baru**:
1. `processSuccessfulPayment()` - Mark pembayaran sebagai success
2. `processFailedPayment()` - Mark pembayaran sebagai failed

### CheckPendingPayments Command (Baru)

**Fitur**:
- Check pending payments created within 24 hours
- Limit configurable (default 50, bisa ubah dengan `--limit=X`)
- Detailed logging
- Progress display (✓ success, ✗ failed, ⏳ pending)

---

## 🔍 Monitoring & Debugging

### Check Logs

```bash
tail -f storage/logs/laravel.log | grep "Payment\|Duitku"
```

### Database Query

```sql
-- Check payment status
SELECT id, merchant_order_id, status, result_code, is_paid, created_at, updated_at
FROM pembayarans 
ORDER BY created_at DESC 
LIMIT 10;

-- Check related permohonan
SELECT p.id, pb.status, pb.is_paid, p.is_paid
FROM pembayarans pb
JOIN permohonans p ON p.id = pb.permohonan_id
ORDER BY pb.created_at DESC
LIMIT 10;
```

### Run Command Manually

```bash
# Check with default limit (50)
php artisan payment:check-pending

# Check with custom limit
php artisan payment:check-pending --limit=100

# View full output
php artisan payment:check-pending -v
```

---

## ⚠️ Important Notes

1. **Local Development**: Return URL handler sudah otomatis dalam PaymentController. Tidak perlu setup callback.

2. **Production Setup**: Saat production dengan domain real:
   - Update `DUITKU_CALLBACK_URL` di `.env` dengan domain real
   - Contoh: `https://yourdomain.com/api/payment/callback`
   - Callback akan langsung terima notifikasi real-time

3. **Cron Job Setup**: Tambahkan ke `app/Console/Kernel.php`:
   ```php
   $schedule->command('payment:check-pending')->everyThirtyMinutes();
   ```

4. **Database Migration**: Tidak perlu migration baru, struktur tabel sudah sesuai

---

## 📞 Troubleshooting

### Q: Status tetap pending setelah pembayaran?
**A**: 
1. Cek log: `tail storage/logs/laravel.log`
2. Run manual check: `php artisan payment:check-pending`
3. Verify Duitku credentials di `.env`

### Q: Pembayaran tidak terupdate ke `is_paid`?
**A**: 
1. Check database: `SELECT * FROM pembayarans WHERE id = X;`
2. Pastikan status adalah `success`
3. Check `permohonans` table, field `is_paid`

### Q: Error saat check status ke Duitku?
**A**: 
1. Verify DUITKU credentials benar di `.env`
2. Test connection: `php artisan tinker` → `Http::get('https://sandbox.duitku.com/...')`
3. Check API key dan merchant code

---

## 📚 Related Files

- `app/Http/Controllers/PaymentController.php` - Modified
- `app/Services/DuitkuPaymentService.php` - Enhanced
- `app/Console/Commands/CheckPendingPayments.php` - New
- `routes/web.php` - Callback endpoint already configured
- `config/duitku.php` - Configuration

---

## ✨ Summary

Masalah status pembayaran pending sudah diperbaiki dengan solusi 3-layer:

1. **Immediate** (Return URL): Update status saat user kembali dari Duitku
2. **Fallback** (Periodic Check): Command untuk cek status berkala  
3. **Real-time** (Callback): Endpoint tetap siap untuk production

**Sekarang pembayaran Anda akan terupdate status dengan benar!** ✅
