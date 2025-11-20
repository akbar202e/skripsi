# Update Struktur Database - Multiple Sample Support

## Perubahan Struktur Database

### 1. Migration Baru
File: `database/migrations/2025_11_17_150000_add_jumlah_sampel_to_permohonan_pengujian_table.php`

Menambahkan kolom `jumlah_sampel` ke tabel pivot `permohonan_pengujian`:
- Kolom: `jumlah_sampel` (integer, default: 1)
- Ini memungkinkan setiap jenis pengujian dalam satu permohonan dapat memiliki jumlah sampel yang berbeda

### 2. Update Model Permohonan

```php
public function jenisPengujians(): BelongsToMany
{
    return $this->belongsToMany(JenisPengujian::class, 'permohonan_pengujian')
        ->withPivot('jumlah_sampel')
        ->withTimestamps();
}
```

Relationship sekarang include kolom pivot `jumlah_sampel`.

## Cara Penggunaan

### Membuat Permohonan Baru

1. **Buka Filament Admin** → Permohonan → Create
2. **Isi Informasi Dasar:**
   - Judul Permohonan
   - Deskripsi Isi
   - Upload Surat Permohonan (PDF)

3. **Tambah Jenis Pengujian di RelationManager:**
   - Klik tombol "Create" di section "Jenis Pengujian"
   - Pilih jenis pengujian dari dropdown
   - Input jumlah sampel (default: 1)
   - Klik "Create"
   - Lakukan berulang untuk jenis pengujian lainnya

4. **Total Biaya Otomatis:**
   - Total biaya otomatis terhitung saat menambah/mengubah/menghapus jenis pengujian
   - Formula: `Sum(biaya_pengujian × jumlah_sampel)`

### Contoh

**Permohonan:** Kuat Tekan Beton 5 item, Slump Test 3 item

| Jenis Pengujian | Biaya Per Sampel | Jumlah Sampel | Total |
|---|---|---|---|
| Kuat Tekan Beton | Rp 150.000 | 5 | Rp 750.000 |
| Slump Test | Rp 75.000 | 3 | Rp 225.000 |
| **Total Biaya** | | | **Rp 975.000** |

### Mengedit Permohonan

1. Buka Permohonan → Edit
2. Informasi dasar tetap dapat diedit
3. Untuk mengubah jenis pengujian/sampel:
   - Edit item di RelationManager
   - Atau hapus dan tambah yang baru
4. Total biaya otomatis terupdate

## Database Schema

### Tabel: permohonan_pengujian
```sql
+-----------------------+-----------+
| Column                | Type      |
+-----------------------+-----------+
| id                    | bigint    |
| permohonan_id         | bigint    |
| jenis_pengujian_id    | bigint    |
| jumlah_sampel         | integer   | ← NEW
| created_at            | timestamp |
| updated_at            | timestamp |
+-----------------------+-----------+
```

## File Yang Diubah

1. **Migration**: `2025_11_17_150000_add_jumlah_sampel_to_permohonan_pengujian_table.php` (NEW)
2. **Model**: `app/Models/Permohonan.php`
3. **RelationManager**: `app/Filament/Resources/PermohonanResource/RelationManagers/JenisPengujiansRelationManager.php` (NEW)
4. **Resource**: `app/Filament/Resources/PermohonanResource.php`
5. **Pages**:
   - `app/Filament/Resources/PermohonanResource/Pages/CreatePermohonan.php`
   - `app/Filament/Resources/PermohonanResource/Pages/EditPermohonan.php`

## Fitur

✅ Multiple jenis pengujian per permohonan
✅ Custom jumlah sampel per jenis pengujian
✅ Auto-calculate total biaya
✅ UI yang user-friendly dengan RelationManager
✅ Validasi jumlah sampel (minimal 1)
✅ Preview total harga di tabel
