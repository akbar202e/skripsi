# ⚡ QUICK GUIDE - Tombol Pembayaran & Konfirmasi Sampel

**Tanggal**: 7 Desember 2025  
**Status**: ✅ READY

---

## 🎯 Fitur 1: Tombol Pembayaran

### Untuk User yang Mengajukan Permohonan

**Sebelum**: Ketik URL manual `http://skripsi.test/payment/permohonan/{id}`  
**Sesudah**: Klik tombol "Lakukan Pembayaran" di halaman detail permohonan

### Cara Pakai

1. Login sebagai User
2. Buka detail permohonan (status = menunggu_pembayaran_sampel)
3. Lihat tombol **💳 Lakukan Pembayaran** di header
4. Klik → langsung ke halaman pembayaran
5. Selesai pembayaran → `is_paid` otomatis terupdate

### Tombol Muncul Jika

- ✅ Status = `menunggu_pembayaran_sampel`
- ✅ `is_paid` = `false`
- ✅ User adalah pemilik permohonan

---

## 🎯 Fitur 2: Konfirmasi Sampel

### Untuk Petugas

**Sebelum**: Checkbox `is_sample_ready` tidak bisa diubah  
**Sesudah**: Klik tombol "Konfirmasi Sampel Diterima" → modal konfirmasi → checkbox terupdate

### Cara Pakai

1. Login sebagai Petugas
2. Buka detail permohonan (status = menunggu_pembayaran_sampel)
3. Lihat tombol **Konfirmasi Sampel Diterima** di header
4. Klik tombol
5. Modal muncul → baca deskripsi
6. Klik **Confirm**
7. ✅ Checkbox `is_sample_ready` = true
8. ✅ Notification berhasil muncul
9. ✅ Tombol **Mulai Pengujian** sekarang aktif

### Tombol Muncul Jika

- ✅ Role = `Petugas`
- ✅ Status = `menunggu_pembayaran_sampel`
- ✅ Petugas assigned (`worker_id` = user login)

---

## 🔄 Workflow Lengkap

```
USER SIDE:
1. Permohonan diterima (status = menunggu_pembayaran_sampel)
2. Klik 💳 Lakukan Pembayaran
3. Pembayaran selesai
4. is_paid = true ✅

PETUGAS SIDE:
1. Tunggu user bayar (is_paid = true)
2. Terima sampel dari user
3. Klik "Konfirmasi Sampel Diterima"
4. Modal konfirmasi muncul
5. Klik Confirm
6. is_sample_ready = true ✅
7. Klik "Mulai Pengujian"
8. Status = sedang_diuji ✅
```

---

## 🧪 Testing Checklist

### User Feature

- [ ] Login sebagai User
- [ ] Buka detail permohonan status = menunggu_pembayaran_sampel
- [ ] Tombol "Lakukan Pembayaran" ada di header
- [ ] Klik tombol → halaman pembayaran terbuka (new tab)
- [ ] Lakukan pembayaran di Duitku
- [ ] is_paid otomatis terupdate ke true

### Petugas Feature

- [ ] Login sebagai Petugas
- [ ] Buka detail permohonan status = menunggu_pembayaran_sampel
- [ ] Tombol "Konfirmasi Sampel Diterima" ada di header
- [ ] Klik tombol → modal konfirmasi muncul
- [ ] Baca deskripsi di modal
- [ ] Klik Confirm → modal tutup
- [ ] Notification success muncul
- [ ] Page di-refresh
- [ ] Checkbox "Sampel Sudah Diterima" = checked ✅
- [ ] Tombol "Mulai Pengujian" sekarang aktif (bisa diklik)
- [ ] Klik "Mulai Pengujian" → status berubah ke sedang_diuji

---

## 📊 Button Display Logic

| Kondisi | Tombol Pembayaran | Tombol Konfirmasi Sampel | Tombol Mulai Pengujian |
|---------|------------------|--------------------------|------------------------|
| Status = menunggu_pembayaran_sampel, is_paid = false, User | ✅ | ❌ | ❌ |
| Status = menunggu_pembayaran_sampel, is_paid = true, is_sample_ready = false, Petugas | ❌ | ✅ | ❌ |
| Status = menunggu_pembayaran_sampel, is_paid = true, is_sample_ready = true, Petugas | ❌ | ❌ | ✅ |

---

## 💡 Tips

1. **Tombol Pembayaran**: Buka di tab baru → user tidak hilang dari halaman permohonan
2. **Konfirmasi Modal**: Pastikan sampel fisik sudah diterima sebelum klik confirm
3. **Workflow**: Pembayaran harus selesai (is_paid = true) sebelum bisa mulai pengujian
4. **Notification**: Lihat notification success untuk konfirmasi action berhasil

---

## 🔧 Troubleshooting

**Q: Tombol pembayaran tidak muncul?**  
A: Check apakah:
- Status = `menunggu_pembayaran_sampel`
- `is_paid` = `false`
- User adalah pemilik permohonan

**Q: Tombol konfirmasi sampel tidak muncul?**  
A: Check apakah:
- Role = `Petugas`
- Status = `menunggu_pembayaran_sampel`
- `worker_id` = user yang login

**Q: Modal tidak muncul saat klik konfirmasi?**  
A: Reload halaman atau clear browser cache

---

## 📚 More Details

Baca: `FITUR_PEMBAYARAN_SAMPEL.md` untuk penjelasan teknis lengkap

---

**Ready to use!** 🚀
