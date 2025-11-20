# Ringkasan Update: Multiple Sample Support

## 🎯 Objektif Selesai
Implementasi fitur untuk mendukung **multiple sampel per jenis pengujian** dalam satu permohonan, sehingga pengguna dapat menginputkan:
- ✅ Berbagai jenis pengujian dalam satu permohonan
- ✅ Jumlah sampel berbeda untuk setiap jenis pengujian
- ✅ Automatic calculation total biaya

---

## 📊 Struktur Database (Update)

### Tabel: `permohonan_pengujian` (Pivot Table)
**Kolom Baru Ditambahkan:**
```sql
ALTER TABLE permohonan_pengujian ADD COLUMN jumlah_sampel INT DEFAULT 1 AFTER jenis_pengujian_id;
```

**Schema Lengkap:**
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary Key |
| permohonan_id | bigint | FK to permohonan |
| jenis_pengujian_id | bigint | FK to jenis_pengujian |
| jumlah_sampel | integer | **NEW** - Jumlah sampel (min: 1) |
| created_at | timestamp | |
| updated_at | timestamp | |

**Unique Constraint:** (permohonan_id, jenis_pengujian_id) - tidak bisa add jenis pengujian yang sama 2x

---

## 🛠️ File-File Yang Diubah/Dibuat

### 1. **Migration** (NEW)
📄 `database/migrations/2025_11_17_150000_add_jumlah_sampel_to_permohonan_pengujian_table.php`
- Menambahkan kolom `jumlah_sampel` ke tabel pivot
- Status: ✅ Sudah dijalankan

### 2. **Model**
📄 `app/Models/Permohonan.php`
```php
public function jenisPengujians(): BelongsToMany
{
    return $this->belongsToMany(JenisPengujian::class, 'permohonan_pengujian')
        ->withPivot('jumlah_sampel')    // NEW
        ->withTimestamps();
}
```
- Update: Tambah `withPivot('jumlah_sampel')` untuk expose pivot data

### 3. **RelationManager** (NEW)
📄 `app/Filament/Resources/PermohonanResource/RelationManagers/JenisPengujiansRelationManager.php`

**Fitur:**
- Form untuk pilih jenis pengujian + input jumlah sampel
- Table menampilkan:
  - Nama jenis pengujian
  - Biaya per sampel
  - **Jumlah sampel**
  - **Total harga** (calculated: biaya × jumlah_sampel)
- Tombol Create/Edit/Delete
- Auto-calculate total_biaya di parent record setiap kali ada perubahan

### 4. **Resource**
📄 `app/Filament/Resources/PermohonanResource.php`

**Perubahan:**
- ❌ Hapus: Select field untuk `jenis_pengujian` (sekarang di RelationManager)
- ✅ Tambah: RelationManager ke `getRelations()`
- 📋 Update: Form schema dengan Section yang lebih rapi

### 5. **Pages - CreatePermohonan**
📄 `app/Filament/Resources/PermohonanResource/Pages/CreatePermohonan.php`

**Logika:**
```php
protected function afterCreate(): void
{
    // Hitung total_biaya berdasarkan pivot data
    $this->calculateTotalBiaya();
}

protected function calculateTotalBiaya(): void
{
    $total = 0;
    foreach ($this->record->jenisPengujians as $jenis) {
        $total += $jenis->biaya * $jenis->pivot->jumlah_sampel;
    }
    $this->record->update(['total_biaya' => $total]);
}
```

### 6. **Pages - EditPermohonan**
📄 `app/Filament/Resources/PermohonanResource/Pages/EditPermohonan.php`

**Logika:**
- Tetap maintain status reset logic (perlu_perbaikan → menunggu_verifikasi)
- Update: Calculate total_biaya saat save (via `afterSave()`)

### 7. **Pages - ViewPermohonan**
📄 `app/Filament/Resources/PermohonanResource/Pages/ViewPermohonan.php`

**Update Baru:**
- ✅ Tambah: `infolist()` method untuk tampilan detail
- **Section: Detail Pengujian** dengan RepeatableEntry menampilkan:
  - Nama jenis pengujian
  - Biaya per sampel
  - Jumlah sampel
  - Total harga per jenis
- **Section: Biaya** menampilkan total biaya keseluruhan
- **Section: File** dengan link ke surat permohonan & laporan hasil

---

## 👤 User Experience

### Membuat Permohonan (Pemohon)

**Step-by-Step:**
1. **Edit Form:**
   - Judul Permohonan
   - Deskripsi Isi
   - Upload Surat Permohonan (PDF)

2. **RelationManager - Tambah Jenis Pengujian:**
   ```
   [Create Button] 
        ↓
   Dialog Form:
   - Dropdown: Pilih Jenis Pengujian
   - TextInput: Jumlah Sampel (default: 1)
        ↓
   [Create] → auto add ke table
        ↓
   RelationManager:
   ┌─────────────────────────────────────────────────┐
   │ Jenis Pengujian │ Biaya │ Sampel │ Total Harga │
   ├─────────────────────────────────────────────────┤
   │ Kuat Tekan      │ Rp150K│   5   │ Rp750K      │
   │ Slump Test      │ Rp75K │   3   │ Rp225K      │
   └─────────────────────────────────────────────────┘
   
   Total Biaya: Rp975.000 (auto-calculated)
   ```

3. **Repeat** untuk tambah jenis pengujian lain

### Lihat Detail Permohonan (Petugas)

**View Page - Infolist:**
```
┌─ Informasi Permohonan ─────────┐
│ Judul: [title]                 │
│ Isi: [description]             │
│ Status: [badge]                │
│ Pemohon: [name]                │
│ Petugas: [name]                │
└────────────────────────────────┘

┌─ Detail Pengujian ─────────────┐
│ Jenis Pengujian  Biaya Sampel T.Harga
│ Kuat Tekan      150K    5     750K
│ Slump Test      75K     3     225K
└────────────────────────────────┘

┌─ Biaya ────────────────────────┐
│ Total: Rp975.000               │
└────────────────────────────────┘

┌─ File ─────────────────────────┐
│ Surat Permohonan: [Link PDF]   │
│ Laporan Hasil: [Link PDF]      │
└────────────────────────────────┘

┌─ Action Buttons ───────────────┐
│ [Terima] [Tolak - Perbaikan]   │
└────────────────────────────────┘
```

---

## 📈 Contoh Use Case

### Permohonan: Pengujian Beton untuk Proyek Gedung

| Jenis Pengujian | Deskripsi | Harga/Item | Jumlah | Total |
|---|---|---|---|---|
| Kuat Tekan Beton | Uji silinder 7, 14, 28 hari | Rp 150.000 | 5 | Rp 750.000 |
| Slump Test | Konsistensi beton segar | Rp 75.000 | 3 | Rp 225.000 |
| Berat Jenis & Penyerapan | Karakteristik agregat | Rp 125.000 | 2 | Rp 250.000 |
| **TOTAL BIAYA** | | | | **Rp 1.225.000** |

---

## ✨ Fitur-Fitur

### Auto-Calculation
- ✅ Total biaya otomatis update saat tambah/edit/hapus item di RelationManager
- ✅ Formula: `SUM(biaya_pengujian × jumlah_sampel)`

### Validation
- ✅ Jumlah sampel minimum 1
- ✅ Tidak bisa add jenis pengujian yang sama 2x (DB unique constraint)
- ✅ Jumlah sampel harus integer

### Display
- ✅ Table dengan "Total Harga" calculated column
- ✅ View page dengan RepeatableEntry untuk visualisasi yang bagus
- ✅ Money formatting untuk semua nilai rupiah

### User-Friendly UI
- ✅ RelationManager bawaan Filament (konsisten dengan design)
- ✅ Dropdown searchable untuk pilih jenis pengujian
- ✅ Inline create/edit/delete buttons
- ✅ Confirmation dialog sebelum delete

---

## 🔄 Workflow Integration

### Pemohon Edit Permohonan (perlu_perbaikan → menunggu_verifikasi)
```
Pemohon buka Edit Permohonan
    ↓
Ubah info (termasuk bisa ubah jenis pengujian via RelationManager)
    ↓
Save
    ↓
Hook: mutateFormDataBeforeSave()
├─ Reset status: perlu_perbaikan → menunggu_verifikasi
├─ Clear keterangan perbaikan
└─ Save form

Hook: afterSave()
├─ calculateTotalBiaya()
│  └─ SUM(biaya × sampel) untuk semua jenis pengujian
└─ Update record total_biaya
```

### Petugas Terima Permohonan (view page action)
```
Status: menunggu_verifikasi
    ↓
View page → [Terima - Lanjut Pembayaran] action
    ↓
Update record:
├─ status: menunggu_pembayaran_sampel
├─ worker_id: auth()->id()
└─ keterangan: null (clear feedback)
```

---

## 📦 Dependencies

Semua menggunakan fitur built-in Filament:
- ✅ RelationManager (Relations handling)
- ✅ RepeatableEntry (Infolist display)
- ✅ WithPivot (Eloquent pivot data)
- ✅ Auto-calculated columns (state callback)

**No external packages required!**

---

## 🧪 Testing Checklist

- ✅ Migration: `php artisan migrate` → Success
- ✅ Seeder: Data jenis pengujian loaded
- ✅ Create: Tambah permohonan + multiple jenis pengujian
- ✅ Edit: Update jumlah sampel, total biaya auto-update
- ✅ Delete: Hapus jenis pengujian, total biaya auto-update
- ✅ View: Lihat detail dengan RepeatableEntry
- ✅ Status workflow: Tetap maintain logic perlu_perbaikan
- ⏳ Authorization: Verify role-based access

---

## 📝 Catatan Penting

1. **Pivot Data**: Gunakan `$model->pivot->jumlah_sampel` untuk akses di RelationManager/Infolist
2. **Auto-Calculate**: Selalu dipanggil saat afterCreate() dan afterSave()
3. **ReadOnly Total**: Input `total_biaya` di form set sebagai readOnly karena calculated
4. **Seeder**: Data jenis pengujian sudah diisi via `JenisPengujianSeeder`

---

## 📚 Dokumentasi Lengkap
Lihat: `FITUR_MULTIPLE_SAMPLE.md` untuk detail implementasi dan usage guide.
