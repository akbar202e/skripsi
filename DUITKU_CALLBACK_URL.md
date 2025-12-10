# Duitku Integration Configuration

## Callback URL untuk Duitku Dashboard

Ketika Anda setup project di Duitku merchant portal, gunakan informasi berikut:

### Development/Testing
```
Callback URL: http://skripsi.test/api/payment/callback
Return URL:   http://skripsi.test/payment/return
```

### Production
```
Callback URL: https://yourdomain.com/api/payment/callback
Return URL:   https://yourdomain.com/payment/return
```

---

## Setup di Duitku Dashboard

1. Buka: https://passport.duitku.com/merchant
2. Login dengan akun Duitku Anda
3. Edit Project "skripsi"
4. Isi field:
   - **Nama Proyek**: skripsi
   - **Website Proyek**: http://skripsi.test/ (development) atau https://yourdomain.com (production)
   - **Callback URL**: Paste URL callback dari atas sesuai environment
5. **SIMPAN**
6. Copy **Merchant Code** dan **API Key** → Paste ke `.env` file

---

## Konfigurasi .env

File `.env` di root project sudah diupdate dengan:

```env
DUITKU_MERCHANT_CODE=DSKRIPSI
DUITKU_API_KEY=c8dc37ed95820f1cedd9958ecad3f1a7
DUITKU_SANDBOX_MODE=true
DUITKU_CALLBACK_URL=http://skripsi.test/api/payment/callback
DUITKU_RETURN_URL=http://skripsi.test/payment/return
DUITKU_EXPIRY_PERIOD=1440
```

---

## Testing Callback

Untuk verify callback bekerja, Anda bisa:

### Option 1: Full End-to-End Test
1. Buat permohonan
2. Go through payment flow
3. Complete pembayaran di sandbox Duitku
4. Check logs: `storage/logs/laravel.log` → cari "Duitku Callback Received"
5. Verify di admin panel pembayaran

### Option 2: Manual Testing (Postman/curl)
```bash
curl -X POST http://skripsi.test/api/payment/callback \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "merchantCode=DSKRIPSI&amount=100000&merchantOrderId=TEST-001&resultCode=00&signature=<calculated_signature>"
```

---

## Production Deployment

Sebelum go-live ke production:

1. **Update Credentials**
   ```env
   DUITKU_MERCHANT_CODE=<production_code>
   DUITKU_API_KEY=<production_key>
   DUITKU_SANDBOX_MODE=false
   ```

2. **Update URLs**
   ```env
   DUITKU_CALLBACK_URL=https://yourdomain.com/api/payment/callback
   DUITKU_RETURN_URL=https://yourdomain.com/payment/return
   APP_URL=https://yourdomain.com
   ```

3. **Update di Duitku Dashboard**
   - Website Proyek → https://yourdomain.com
   - Callback URL → https://yourdomain.com/api/payment/callback
   - SAVE

4. **HTTPS/SSL Setup**
   - Dapatkan SSL certificate
   - Configure web server
   - Force HTTPS redirect

5. **Test Real Transaction**
   - Lakukan minimal 1 real payment dengan nominal kecil
   - Verify end-to-end

---

## Support

- **Duitku Docs**: https://docs.duitku.com/api/en
- **Duitku Support**: support@duitku.com

---

**Last Updated**: 6 Desember 2025
