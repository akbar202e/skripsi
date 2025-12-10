# Fitur Nota Pembayaran PDF

## Deskripsi
Fitur untuk download nota pembayaran dalam format PDF. User dapat mendownload nota pembayaran setelah transaksi berhasil.

## Files Created/Modified

### New Files
1. **`app/Services/TerbilangService.php`**
   - Service untuk convert angka ke terbilang (Indonesian words)
   - Method: `toTerbilang($num)` - convert number ke kata
   - Method: `format($num)` - format lengkap dengan "Rupiah"

2. **`app/Services/NotaPembayaranService.php`**
   - Service untuk generate nota pembayaran PDF
   - Method: `generatePdf(Pembayaran $pembayaran)` - return DOMPDF instance
   - Uses: `payment.nota-pdf` blade template
   - Paper size: A4 dengan margin 10mm

3. **`resources/views/payment/nota-pdf.blade.php`**
   - Blade template untuk nota pembayaran
   - Styling: HTML dengan inline CSS (A4 paper format)
   - Content: Header, nota details, items table, total, signature space
   - Font: Times New Roman, 11pt

### Modified Files
1. **`app/Http/Controllers/PaymentController.php`**
   - Added import: `use App\Services\NotaPembayaranService;`
   - Added method: `downloadNota(Pembayaran $pembayaran)` 
   - Authorization: Check user ownership atau admin/petugas role
   - Returns: PDF download dengan filename `NOTA-{merchant_order_id}.pdf`

2. **`routes/web.php`**
   - Added route: `Route::get('/{pembayaran}/nota', [PaymentController::class, 'downloadNota'])->name('payment.nota');`
   - Full path: `/payment/{pembayaran}/nota`
   - Middleware: `auth` (dari payment group)

3. **`resources/views/payment/history.blade.php`**
   - Updated action column untuk tampilkan button nota
   - Added link: `route('payment.nota', $pembayaran)` 
   - Visible hanya saat pembayaran status success
   - Display: "Nota" link di samping "Invoice" link

## Usage

### Untuk User (Pemohon)
1. Navigasi ke halaman Riwayat Pembayaran (`payment/permohonan/{id}/history`)
2. Cari pembayaran dengan status "Berhasil"
3. Klik tombol "Nota" untuk download PDF nota pembayaran

### Untuk Admin/Petugas
- Akses sama dengan Pemohon
- Dapat download nota pembayaran apapun

## Authorization
- **Pemohon**: Hanya dapat download nota milik sendiri (check `user_id`)
- **Admin/Petugas**: Dapat download nota apapun

## API Route
```
GET /payment/{pembayaran}/nota
Name: payment.nota
Auth: Required
```

## Struktur Nota PDF
```
┌─────────────────────────────────────┐
│     HEADER (Logo + Lab Info)        │
├─────────────────────────────────────┤
│     NOTA PEMBAYARAN                 │
├─────────────────────────────────────┤
│  Details:                           │
│  - Nomor Nota                       │
│  - Tanggal                          │
│  - Pemohon                          │
│  - Pekerjaan/Judul Permohonan       │
│  - Metode Pembayaran                │
├─────────────────────────────────────┤
│  Items Table:                       │
│  [No] [Uraian] [Qty] [Harga] [Jml] │
├─────────────────────────────────────┤
│  TOTAL KESELURUHAN: Rp XXX.XXX      │
│  Terbilang: ... Rupiah              │
├─────────────────────────────────────┤
│  Signature Space (3 kolom)          │
└─────────────────────────────────────┘
```

## Testing
```bash
# Test service manually
php artisan tinker
>>> $pembayaran = App\Models\Pembayaran::where('status', 'success')->first();
>>> App\Services\NotaPembayaranService::generatePdf($pembayaran)->download('test.pdf');
```

## Dependencies
- `barryvdh/laravel-dompdf` - PDF generation library
- `App\Services\TerbilangService` - Number to words conversion
- Blade Template Engine

## Notes
- PDF generation otomatis include all pembayaran data
- Filename format: `NOTA-{merchant_order_id}.pdf`
- Terbilang conversion support sampai triliunan
- A4 paper format dengan margin 10mm
