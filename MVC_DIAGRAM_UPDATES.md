# 📊 Update MVC Diagram - Penambahan Homepage & Dashboard

## Ringkasan Perubahan pada MVC_CLASS_DIAGRAM.puml

Diagram MVC telah diperbarui untuk mencerminkan penambahan fitur-fitur baru yang telah dibuat.

---

## 🆕 Penambahan Baru pada Diagram

### 1. **Public Pages Package** (NEW)
Ditambahkan package baru untuk halaman publik yang dapat diakses tanpa login:

```
package "Public Pages (Web Views)" as PublicViews {
    class HomePage {
        - Menampilkan informasi publik
        - Tabel jenis pengujian dengan load more
        - Navigation, Hero, About, Features sections
        - CTA dan Footer
    }
}
```

**Komponen HomePage:**
- `navigationBar` - Menu navigasi publik
- `heroSection` - Banner utama
- `aboutSection` - Informasi tentang UPT2
- `featuresSection` - Fitur-fitur utama
- `testingTypesSection` - Tabel jenis pengujian dengan pagination
- `ctaSection` - Call-to-action untuk pendaftaran
- `footer` - Footer dengan informasi kontak

---

### 2. **HomeController** (UPDATED)
Controller telah ditambahkan ke dalam diagram:

```php
class HomeController {
    + index(): Response
    - getLaboratoriesData(): array
}
```

**Fungsi:**
- Menangani request ke homepage publik
- Mengambil data jenis pengujian dari database
- Merender view homepage dengan data

---

### 3. **Filament Pages** (NEW)
Ditambahkan Filament Pages yang sebelumnya belum ada di diagram:

#### **Dashboard Page**
```php
class Dashboard {
    + getHeading(): string
    + getSubHeading(): string
    + getHeaderWidgets(): array
    + getFooterWidgets(): array
}
```

Fungsi:
- Welcome page untuk user yang login
- Menampilkan account widget
- Navigasi ke semua resource admin

#### **About Page**
```php
class About {
    + getHeading(): string
    + getSubHeading(): string
}
```

Fungsi:
- Informasi lengkap tentang UPT2
- Tabel jenis pengujian dengan load more pagination
- Stack teknologi dan informasi kontak

---

## 🔄 Relationship Updates

### Baru Ditambahkan:

#### **Public View Relationships**
```
HomePage --> JenisPengujian : displays
HomeController --> HomePage : renders
HomeController --> JenisPengujian : fetches
HomeController --|> Controller : inherits
```

#### **Dashboard & About Relationships**
```
Dashboard --> Permohonan : displays
Dashboard --> User : displays
About --> JenisPengujian : displays
```

---

## 📦 Package Structure (Updated)

```
┌─ Models (Data Layer)
│  ├─ User
│  ├─ Permohonan
│  ├─ JenisPengujian ⭐ (Used by HomePage & About)
│  ├─ Pembayaran
│  ├─ Dokumen
│  └─ PermohonanPengujian
│
├─ Public Pages (Web Views) ⭐ NEW
│  └─ HomePage
│     └─ Display JenisPengujian Table
│
├─ Filament Resources (Admin Views)
│  ├─ Dashboard ⭐ NEW
│  ├─ About ⭐ NEW
│  ├─ PermohonanResource
│  ├─ UserResource
│  ├─ JenisPengujianResource
│  ├─ PembayaranResource
│  └─ DokumenResource
│
├─ Controllers (Business Logic)
│  ├─ HomeController ⭐ NEW
│  ├─ PaymentController
│  ├─ DokumenController
│  └─ Controller (Base)
│
├─ Policies (Authorization)
│  ├─ PermohonanPolicy
│  ├─ PembayaranPolicy
│  └─ DokumenPolicy
│
├─ Observers (Event Handlers)
│  └─ PermohonanObserver
│
└─ Services (Business Logic)
   ├─ PaymentService
   └─ DokumenService
```

---

## 🎯 Data Flow (Updated)

### Flow Publik (Tanpa Login)
```
User Request (GET /)
    ↓
Routes (web.php)
    ↓
HomeController::index()
    ↓
JenisPengujian::all()  ⭐
    ↓
HomePage View
    ↓
Display Jenis Pengujian Table
    ↓ (Click Load More)
JavaScript handleLoadMore()
    ↓
Show next 10 items
```

### Flow Admin (Setelah Login)
```
User Request (GET /admin)
    ↓
Filament Authentication
    ↓
Dashboard Page
    ↓
AccountWidget + FilamentInfoWidget
    ↓ (User clicks "Tentang UPT2")
About Page
    ↓
Display Jenis Pengujian Table with Pagination
```

---

## 📝 Catatan Penting

1. **Homepage tidak memerlukan authentication** - Dapat diakses publik
2. **Dashboard & About memerlukan authentication** - Hanya untuk user yang login
3. **JenisPengujian digunakan oleh 3 layer:**
   - HomePage (Public)
   - About Page (Admin)
   - JenisPengujianResource (Admin CRUD)
4. **Load More Pagination** - Menampilkan 10 item pertama, rest tersembunyi sampai user klik tombol "Load More"
5. **HomeController** - Mengambil data dari database JenisPengujian dan pass ke view

---

## ✅ Checklist Update Diagram

- ✅ HomeController ditambahkan
- ✅ HomePage class ditambahkan ke Public Pages package
- ✅ Dashboard Page ditambahkan
- ✅ About Page ditambahkan
- ✅ Relationships diupdate
- ✅ Controller inheritance direvisi
- ✅ Catatan untuk public pages ditambahkan
- ✅ Data flow diperbarui

---

## 🚀 Kesimpulan

MVC Diagram sekarang mencerminkan **2 layer view utama:**
1. **Public Pages** - Accessible tanpa login (HomePage)
2. **Admin Pages** - Memerlukan authentication (Dashboard, About, Resources)

Diagram juga menunjukkan bagaimana **JenisPengujian model** digunakan di berbagai tempat:
- Display di homepage publik
- Display di about page admin
- CRUD management di JenisPengujianResource

Ini memberikan gambaran lengkap tentang arsitektur aplikasi UPT2 setelah penambahan fitur homepage dan dashboard.
