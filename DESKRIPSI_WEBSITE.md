# 📋 DESKRIPSI WEBSITE UPT2 - SISTEM MANAJEMEN PERMOHONAN PENGUJIAN

## 📖 Daftar Isi
1. [Ringkasan Umum](#ringkasan-umum)
2. [Tujuan Sistem](#tujuan-sistem)
3. [Target Pengguna](#target-pengguna)
4. [Fitur-Fitur Utama](#fitur-fitur-utama)
5. [Alur Bisnis](#alur-bisnis)
6. [Teknologi yang Digunakan](#teknologi-yang-digunakan)
7. [Struktur Database](#struktur-database)
8. [Arsitektur Sistem](#arsitektur-sistem)
9. [Detail Fitur](#detail-fitur)

---

## 🎯 Ringkasan Umum

**UPT2** adalah platform web untuk manajemen permohonan pengujian yang terintegrasi dengan sistem pembayaran online. Sistem ini dirancang untuk:

- 📝 Memudahkan pihak luar mengajukan permohonan pengujian sampel
- 💳 Memproses pembayaran secara online melalui Duitku Payment Gateway
- 🔍 Memberikan transparansi status permohonan kepada pemohon
- 👥 Memberikan interface admin untuk mengelola permohonan dan pengujian
- 📊 Menyediakan laporan hasil pengujian digital

---

## 🎓 Tujuan Sistem

Sistem ini dibuat untuk:

1. **Otomasi Proses Permohonan**
   - Menggantikan proses manual pengajuan permohonan di atas kertas
   - Mengurangi waktu pemrosesan
   - Menghilangkan duplikasi data

2. **Manajemen Pembayaran Terpusat**
   - Menerima pembayaran secara online
   - Mengurangi beban kasir
   - Menciptakan audit trail untuk setiap transaksi

3. **Transparansi Informasi**
   - Pemohon bisa tracking status permohonan real-time
   - Mengurangi pertanyaan yang masuk ke customer service

4. **Integrasi Workflow**
   - Menghubungkan proses permohonan, pembayaran, dan pengujian
   - Otomasi status updates
   - Notifikasi real-time untuk semua stakeholder

---

## 👥 Target Pengguna

### 1. **Pemohon (External User)**
   - Pihak eksternal yang ingin mengajukan permohonan pengujian
   - Bisa melakukan registrasi mandiri
   - Bisa melacak status permohonan
   - Melakukan pembayaran online
   - Melihat hasil pengujian

### 2. **Petugas/Operator (Staff)**
   - Karyawan bagian administrasi
   - Mengelola permohonan yang masuk
   - Melakukan verifikasi kelengkapan dokumen
   - Update status permohonan
   - Generate laporan

### 3. **Teknisi/Laborant (Worker)**
   - Karyawan laboratorium
   - Menerima sampel
   - Melakukan pengujian
   - Upload hasil pengujian
   - Dokumentasi sampel

### 4. **Pimpinan**
   - Pimpinan/Manager untuk monitoring keseluruhan sistem
   - View-only access ke semua permohonan dan pembayaran
   - Bisa melihat jenis pengujian dan dokumen
   - Bisa export/download laporan data
   - Monitoring status semua request tanpa bisa edit

### 5. **Admin Sistem**
   - Mengelola user dan role permissions
   - Mengelola master data (jenis pengujian, metode pembayaran)
   - Monitor sistem keseluruhan
   - Generate laporan dan statistik

---

## ✨ Fitur-Fitur Utama

### 1. **Manajemen Permohonan** 📋
   - **Create Permohonan**: Pemohon membuat permohonan baru dengan:
     - Judul dan deskripsi pengujian yang diminta
     - Upload surat permohonan (PDF)
     - Pemilihan jenis pengujian (multiple select)
     - Jumlah sampel untuk setiap jenis pengujian
   
   - **View & Edit**: Pemohon bisa melihat detail permohonan mereka
   
   - **Status Tracking**: Real-time status permohonan:
     - `draft` → Permohonan baru
     - `submitted` → Sudah dikirim, menunggu verifikasi
     - `verified` → Diverifikasi staff, menunggu persetujuan
     - `approved` → Disetujui, menunggu pembayaran dan sampel
     - `menunggu_pembayaran_sampel` → Status pembayaran/sampel pending
     - `testing_in_progress` → Sedang dalam proses pengujian
     - `testing_completed` → Pengujian selesai
     - `completed` → Selesai dan laporan sudah diberikan
     - `rejected` → Ditolak oleh staff

### 2. **Manajemen Pembayaran** 💳
   - **Multiple Payment Methods**: Dukung berbagai metode pembayaran:
     - Virtual Account (VA) - BCA, Mandiri, Maybank, BNI, CIMB, Permata, dll
     - Kartu Kredit (Visa, Mastercard, JCB)
     - E-Wallet (OVO, ShopeePay, DANA, LinkAja)
     - QRIS
     - Paylater (Indodana, ATOME)
     - E-Banking (Jenius Pay)
   
   - **Payment Gateway Integration**: Terintegrasi dengan Duitku
     - Auto-sync metode pembayaran berdasarkan nominal
     - Real-time payment verification
     - Secure callback handling
   
   - **Payment Status Tracking**:
     - Pending → Menunggu pembayaran
     - Success → Pembayaran berhasil (is_paid = true)
     - Failed → Pembayaran gagal
     - Expired → Pembayaran kedaluwarsa
   
   - **Features**:
     - Invoice digital otomatis
     - Nota pembayaran (downloadable)
     - Riwayat pembayaran per permohonan
     - Payment retry mechanism

### 3. **Master Data Management** ⚙️
   - **Jenis Pengujian** (JenisPengujian)
     - Nama pengujian
     - Biaya per item
     - Deskripsi
     - Digunakan untuk perhitungan total biaya
   
   - **Metode Pembayaran** (PaymentMethod)
     - Kode metode (VA, VC, OV, dll)
     - Nama metode pembayaran
     - Logo pembayaran
     - Biaya admin (fee)
     - Status aktif/inactive
     - Auto-sync dari Duitku API

### 4. **Manajemen Pengguna & Role** 👤
   - **User Registration & Authentication**
     - Login system dengan email/password
     - Password hashing (bcrypt)
     - Session management
   
   - **Role-Based Access Control (RBAC)**
     - Admin: Full system access
     - Pimpinan: View-only access (read + export) ke semua data
     - Petugas: Manage applications & samples
     - Teknisi: Input test results
     - Pemohon: View own applications & payments
   
   - **Permission Management**
     - Fine-grained permissions
     - Policy-based authorization
     - Dynamic role assignment

### 5. **Manajemen Dokumen & File** 📄
   - **Document Storage**
     - Surat permohonan (PDF)
     - Laporan hasil pengujian
     - Nota pembayaran
     - Invoice digital
   
   - **File Management**
     - Upload file handling
     - Secure file storage
     - Download & preview capabilities
     - File categorization

### 6. **Admin Panel (Filament)** 🎛️
   - **Dashboard**:
     - Overview statistik
     - Recent activities
     - Pending tasks
   
   - **Resources** (CRUD Interface):
     - Permohonan Resource: Manage applications
     - Pembayaran Resource: Manage payments
     - User Resource: Manage users & roles
     - JenisPengujian Resource: Manage test types
     - Dokumen Resource: Manage documents
   
   - **Features**:
     - Advanced filtering
     - Bulk actions
     - Custom forms
     - Table customization
     - Export capabilities

### 7. **Pelaporan & Statistik** 📊
   - Revenue tracking
   - Application statistics
   - Payment status overview
   - User activity logs
   - Test completion rates

### 8. **Security Features** 🔒
   - **Authentication & Authorization**
     - Session-based authentication
     - Password protection
     - CSRF protection
     - Rate limiting
   
   - **Payment Security**
     - Signature verification untuk callback
     - API key protection (environment variables)
     - HTTPS ready
     - Secure data transmission
   
   - **Data Protection**
     - Soft delete untuk data integrity
     - Audit logging
     - User activity tracking
     - Role-based access control

---

## 🔄 Alur Bisnis

### Flow Standar Permohonan:

```
┌─────────────────────────────────────────────────────────────┐
│ 1. PEMOHON MENGAJUKAN PERMOHONAN                            │
├─────────────────────────────────────────────────────────────┤
│ • Login ke sistem                                           │
│ • Isi form permohonan (judul, deskripsi, jenis pengujian)  │
│ • Upload surat permohonan (PDF)                            │
│ • Tentukan jumlah sampel untuk setiap jenis pengujian      │
│ • Submit permohonan                                        │
│ Status: SUBMITTED                                          │
└─────────────────────────────────────────────────────────────┘
                           ↓
┌─────────────────────────────────────────────────────────────┐
│ 2. STAFF VERIFIKASI PERMOHONAN                              │
├─────────────────────────────────────────────────────────────┤
│ • Login ke admin panel                                      │
│ • Review permohonan yang masuk                              │
│ • Cek kelengkapan dokumen                                   │
│ • APPROVED → Permohonan diterima                            │
│ • REJECTED → Permohonan ditolak (beri alasan)              │
│ Status: APPROVED / REJECTED                                │
└─────────────────────────────────────────────────────────────┘
                           ↓ (jika APPROVED)
┌─────────────────────────────────────────────────────────────┐
│ 3. SISTEM HITUNG TOTAL BIAYA                                │
├─────────────────────────────────────────────────────────────┤
│ • Total = SUM(jumlah_sampel * biaya_pengujian)             │
│ • Update field: total_biaya, is_paid = false               │
│ Status: MENUNGGU_PEMBAYARAN_SAMPEL                          │
└─────────────────────────────────────────────────────────────┘
                           ↓
┌─────────────────────────────────────────────────────────────┐
│ 4. PEMOHON MELAKUKAN PEMBAYARAN                             │
├─────────────────────────────────────────────────────────────┤
│ • Akses halaman pembayaran                                  │
│ • Pilih metode pembayaran                                   │
│ • Redirect ke Duitku payment page                           │
│ • Selesaikan pembayaran                                     │
│ Status: PENDING / SUCCESS / FAILED / EXPIRED                │
└─────────────────────────────────────────────────────────────┘
                           ↓ (jika SUCCESS)
┌─────────────────────────────────────────────────────────────┐
│ 5. SISTEM TERIMA CALLBACK PEMBAYARAN                        │
├─────────────────────────────────────────────────────────────┤
│ • Duitku mengirim callback ke /api/payment/callback        │
│ • Sistem verifikasi signature callback                      │
│ • Update: pembayaran.status = 'success'                     │
│ • Update: permohonan.is_paid = true (OTOMATIS)             │
│ • Notifikasi pemohon                                        │
└─────────────────────────────────────────────────────────────┘
                           ↓
┌─────────────────────────────────────────────────────────────┐
│ 6. TEKNISI TERIMA SAMPEL & MULAI PENGUJIAN                 │
├─────────────────────────────────────────────────────────────┤
│ • Sampel tiba di laboratorium                               │
│ • Staff centang checkbox "is_sample_ready = true"          │
│ • Teknisi mulai proses pengujian                            │
│ • Update status: TESTING_IN_PROGRESS                        │
└─────────────────────────────────────────────────────────────┘
                           ↓
┌─────────────────────────────────────────────────────────────┐
│ 7. TEKNISI INPUT HASIL PENGUJIAN                            │
├─────────────────────────────────────────────────────────────┤
│ • Pengujian selesai                                         │
│ • Upload laporan hasil pengujian (PDF)                      │
│ • Isi data hasil pengujian                                  │
│ • Update status: TESTING_COMPLETED                          │
└─────────────────────────────────────────────────────────────┘
                           ↓
┌─────────────────────────────────────────────────────────────┐
│ 8. STAFF FINALISASI & TUTUP PERMOHONAN                      │
├─────────────────────────────────────────────────────────────┤
│ • Review laporan hasil                                      │
│ • Update status: COMPLETED                                  │
│ • Notifikasi pemohon bahwa hasil siap diambil              │
└─────────────────────────────────────────────────────────────┘
                           ↓
┌─────────────────────────────────────────────────────────────┐
│ 9. PEMOHON DOWNLOAD HASIL & NOTA PEMBAYARAN                │
├─────────────────────────────────────────────────────────────┤
│ • Login ke sistem                                           │
│ • Akses halaman permohonan                                  │
│ • Download laporan hasil pengujian                          │
│ • Download nota/invoice pembayaran                          │
│ Status: COMPLETED                                           │
└─────────────────────────────────────────────────────────────┘
```

---

## 🛠️ Teknologi yang Digunakan

### **Backend**
| Teknologi | Versi | Fungsi |
|-----------|-------|--------|
| **Laravel** | 12.x | Web Framework |
| **PHP** | 8.2+ | Server-side language |
| **MySQL** | 8.0 | Database relational |
| **Eloquent ORM** | - | Database abstraction |
| **Filament** | 3.3 | Admin panel & CRUD UI |
| **Spatie Roles & Permissions** | 6.x | Role-based access control |
| **Duitku API** | v2 | Payment gateway integration |
| **DOMPDF** | - | PDF generation |

### **Frontend**
| Teknologi | Versi | Fungsi |
|-----------|-------|--------|
| **Blade** | - | Template engine Laravel |
| **Tailwind CSS** | - | Styling |
| **Alpine.js** | - | Interactive components |
| **Livewire** | - | Real-time components |
| **JavaScript/Vite** | - | Frontend bundling |

### **Infrastructure**
| Teknologi | Fungsi |
|-----------|--------|
| **Laragon** | Local development server |
| **Composer** | PHP dependency manager |
| **npm** | JavaScript dependency manager |
| **Git** | Version control |

---

## 🗄️ Struktur Database

### **Tabel Utama**

#### **1. Users**
```
id (PK)
name
email (UNIQUE)
password (hashed)
email_verified_at
created_at
updated_at
deleted_at (soft delete)
```

#### **2. Permohonans** (Request/Application)
```
id (PK)
judul
isi (deskripsi)
user_id (FK → users)
worker_id (FK → users)
status (enum: draft, submitted, verified, approved, menunggu_pembayaran_sampel, 
              testing_in_progress, testing_completed, completed, rejected)
surat_permohonan (file path)
laporan_hasil (file path)
total_biaya (decimal)
keterangan (notes)
is_paid (boolean) - otomatis dari callback pembayaran
is_sample_ready (boolean) - manual checkbox oleh staff
created_at
updated_at
deleted_at (soft delete)
```

**Relationships:**
- `pemohon()` → User (many-to-one)
- `worker()` → User (many-to-one)
- `jenisPengujians()` → JenisPengujian (many-to-many via permohonan_pengujian)
- `pembayarans()` → Pembayaran (one-to-many)
- `latestPembayaran()` → Pembayaran (one-to-one, latest)

#### **3. Pembayarans** (Payment Records)
```
id (PK)
permohonan_id (FK → permohonans)
user_id (FK → users)
amount (decimal)
payment_method (string: VA, VC, OV, dll)
payment_method_name (string: nama metode)
merchant_order_id (string: unik order ID)
duitku_reference (string: reference dari Duitku)
va_number (string: nomor VA jika metode VA)
payment_url (text: URL payment page)
status (enum: pending, success, failed, expired)
result_code (string: 00=success, 01=failed, dll)
paid_at (timestamp)
notes (text)
created_at
updated_at
```

**Relationships:**
- `permohonan()` → Permohonan (many-to-one)
- `user()` → User (many-to-one)

#### **4. JenisPengujians** (Test Types)
```
id (PK)
nama_pengujian
biaya (decimal)
deskripsi (text)
created_at
updated_at
```

**Relationships:**
- `permohonans()` → Permohonan (many-to-many via permohonan_pengujian)

#### **5. Permohonan_Pengujian** (Pivot Table)
```
permohonan_id (FK → permohonans)
jenis_pengujian_id (FK → jenis_pengujians)
jumlah_sampel (integer)
created_at
updated_at
```

#### **6. PaymentMethods** (Available Payment Methods)
```
id (PK)
payment_method (string: VA, VC, OV, dll)
payment_name (string: nama metode)
payment_image (text: URL logo)
total_fee (decimal: biaya admin)
is_active (boolean)
created_at
updated_at
deleted_at (soft delete)
```

#### **7. Dokumen** (Documents)
```
id (PK)
judul
deskripsi
kategori (string: hasil, panduan, template, dll)
image_path (file path)
created_by (FK → users)
created_at
updated_at
```

**Relationships:**
- `creator()` → User (many-to-one)

#### **8. Model_Has_Roles / Model_Has_Permissions** (Spatie)
Tabel-tabel untuk manage roles dan permissions (dari package Spatie).

---

## 🏗️ Arsitektur Sistem

### **MVC Architecture**

```
┌──────────────────────────────────────────────────────────┐
│                        VIEW LAYER                        │
│  • Filament Admin Panel                                 │
│  • Blade Templates (Frontend)                           │
│  • Forms & Tables Components                            │
│  • Email Templates                                      │
└──────────────────────────────────────────────────────────┘
                           ↕
┌──────────────────────────────────────────────────────────┐
│                   CONTROLLER LAYER                       │
│  • PaymentController                                    │
│  • DokumenController                                    │
│  • Authentication/Authorization                        │
└──────────────────────────────────────────────────────────┘
                           ↕
┌──────────────────────────────────────────────────────────┐
│                    SERVICE LAYER                         │
│  • DuitkuPaymentService                                 │
│  • DokumenService                                       │
│  • NotaPembayaranService                                │
│  • Business Logic & External APIs                       │
└──────────────────────────────────────────────────────────┘
                           ↕
┌──────────────────────────────────────────────────────────┐
│                     MODEL LAYER                          │
│  • User                                                 │
│  • Permohonan                                           │
│  • Pembayaran                                           │
│  • JenisPengujian                                       │
│  • PaymentMethod                                        │
│  • Dokumen                                              │
│  • Database Relations & Queries                         │
└──────────────────────────────────────────────────────────┘
                           ↕
┌──────────────────────────────────────────────────────────┐
│                   DATABASE LAYER                         │
│  • MySQL 8.0                                            │
│  • Migrations & Seeds                                   │
│  • Eloquent ORM                                         │
└──────────────────────────────────────────────────────────┘
```

### **Component Layers**

```
┌─────────────────────────────────────────┐
│   POLICIES (Authorization)              │
│   • PermohonanPolicy                    │
│   • PembayaranPolicy                    │
│   • DokumenPolicy                       │
│   → Check user permissions              │
└─────────────────────────────────────────┘
         ↑
         │
┌─────────────────────────────────────────┐
│   OBSERVERS (Event Handlers)            │
│   • PermohonanObserver                  │
│   → Lifecycle event tracking            │
│   → Automatic status updates            │
└─────────────────────────────────────────┘
         ↑
         │
┌─────────────────────────────────────────┐
│   FILAMENT RESOURCES (CRUD UI)          │
│   • PermohonanResource                  │
│   • PembayaranResource                  │
│   • UserResource                        │
│   • JenisPengujianResource              │
│   • DokumenResource                     │
└─────────────────────────────────────────┘
```

---

## 📚 Detail Fitur

### **1. Fitur Permohonan - CRUD Lengkap**

#### **Create Permohonan**
- Pemohon isi form:
  - Judul pengujian
  - Deskripsi detail
  - Pilih jenis pengujian (multiple)
  - Masukkan jumlah sampel per jenis
  - Upload surat permohonan (PDF)
- Sistem otomatis:
  - Set status = 'draft'
  - Set user_id dari user login
  - Simpan ke database

#### **Read/View Permohonan**
- Pemohon: Hanya bisa lihat permohonan miliknya
- Staff: Bisa lihat semua permohonan
- Filter: By status, date, user
- Detail view: Semua info + riwayat pembayaran + attachments

#### **Update Permohonan**
- Pemohon: Hanya bisa edit form (sebelum submit)
- Staff: Bisa update status, assign worker, edit notes
- Teknisi: Bisa upload hasil pengujian
- Otomasi: Beberapa field read-only (is_paid, calculated total_biaya)

#### **Delete Permohonan**
- Soft delete untuk audit trail
- Hanya admin yang bisa hard delete

---

### **2. Fitur Pembayaran - Payment Gateway Integration**

#### **Inisiasi Pembayaran**
1. User click "Bayar Sekarang" di halaman permohonan
2. Sistem validasi: permohonan.status = 'menunggu_pembayaran_sampel'
3. Create/fetch Pembayaran record
4. Sync payment methods dari Duitku API
5. Display form pilih metode pembayaran

#### **Process Pembayaran**
1. User pilih metode pembayaran
2. POST ke `/payment/permohonan/{id}/process`
3. Sistem create payment request ke Duitku API:
   - Signature generation
   - Amount, merchant code, order ID
4. Duitku return payment URL
5. Redirect user ke payment page Duitku

#### **Callback Handling**
1. User selesai pembayaran di Duitku
2. Duitku kirim callback POST ke `/api/payment/callback`
3. Sistem verify signature callback
4. Update Pembayaran:
   - status = 'success'
   - result_code = '00'
   - paid_at = now()
   - duitku_reference = from callback
5. Update Permohonan:
   - is_paid = true (OTOMATIS)
6. Log transaction
7. Trigger observer/events

#### **Return URL Handling**
1. User redirect dari Duitku ke `/payment/return?resultCode=...&reference=...`
2. Sistem fetch pembayaran dari reference
3. Verifikasi result code
4. Update status jika belum update dari callback
5. Display success/failed message

#### **Fitur Tambahan**
- **Riwayat Pembayaran**: View all payments for a permohonan
- **Invoice Download**: Download invoice PDF
- **Nota Pembayaran**: Download nota/bukti pembayaran
- **Payment Retry**: Jika payment gagal, bisa retry dengan metode lain
- **Payment Methods Sync**: Auto-sync dari Duitku sesuai nominal

---

### **3. Fitur Admin Panel (Filament)**

#### **Dashboard**
- Statistics widgets (total applications, revenue, pending items)
- Recent activities
- Quick action buttons

#### **Permohonan Resource**
- **List View**:
  - Table dengan kolom: ID, Pemohon, Judul, Status, Total Biaya, is_paid, is_sample_ready
  - Filter by status, date range, user
  - Bulk actions: approve multiple, reject multiple
  - Export to CSV/Excel

- **View/Edit Form**:
  - Section 1: Application Info (read-only)
  - Section 2: Status & Assignment
  - Section 3: Payment Status (read-only, dari callback)
  - Section 4: Sample Status (checkbox is_sample_ready)
  - Section 5: Test Results (upload laporan)
  - Section 6: Notes & History

#### **Pembayaran Resource**
- **List View**:
  - Table: ID, Permohonan, Amount, Method, Status, Date
  - Filter by status, date range, method
  - Visual status indicators

- **View Detail**:
  - Payment info (amount, method, reference)
  - Status history
  - Callback details
  - Manual notes field

#### **User Management**
- List all users
- Assign/revoke roles
- Create new users
- Reset password
- View user activity

#### **JenisPengujian Management**
- CRUD jenis pengujian
- Set biaya untuk setiap jenis
- Enable/disable jenis
- View usage statistics

#### **Dokumen Management**
- Upload/manage dokumen
- Categorize dokumen
- Set visibility
- Track who created dokumen

---

### **4. Fitur Security & Authorization**

#### **Authentication**
- Email/password login
- Password hashing (bcrypt)
- Remember me functionality
- Session management
- Email verification (optional)

#### **Authorization (RBAC)**
- **Admin**: Full system access
- **Petugas**: Create/update/delete permohonan, view payments, manage samples
- **Teknisi**: View assigned permohonan, upload test results
- **Pemohon**: Create permohonan, view own data, pay payments, download results

#### **Permissions**
- Fine-grained permissions for each action
- Policy-based authorization
- Middleware for route protection
- Model authorization (can user update this permohonan?)

#### **Data Protection**
- Soft deletes untuk audit trail
- Activity logging
- Signature verification untuk payment callbacks
- CSRF protection
- SQL injection prevention (prepared statements)
- XSS protection (HTML escaping)

---

### **5. Fitur Reporting & Export**

#### **Reports**
- Total applications by status
- Revenue by month/period
- Payment success rate
- Application completion time
- User activity logs

#### **Export**
- Export applications to CSV/Excel
- Export payments to CSV
- Export test results
- PDF report generation

---

### **6. Fitur Notifikasi (Planned)**
- Email notifikasi status perubahan
- Email invoice otomatis
- SMS notification (optional)
- In-app notifications

---

## 📊 User Journey

### **Pemohon Flow**
```
1. Register → 2. Login → 3. Create Permohonan → 4. Upload Dokumen
                           ↓
5. Wait Staff Verification → 6. Approved → 7. Pay Online
                              ↓
8. Payment Success → 9. Send Sample → 10. Wait Test Results
                      ↓
11. Download Results & Nota → 12. Complete
```

### **Staff Flow**
```
1. Login → 2. View Permohonan Queue → 3. Verify Kelengkapan Dokumen
            ↓
4. Approve/Reject → 5. Assign Worker → 6. Monitor Payment Status
                      ↓
7. Check Sample Received → 8. Review Test Results
                             ↓
9. Finalize & Close → 10. Generate Reports
```

### **Teknisi Flow**
```
1. Login → 2. View Assigned Permohonan → 3. Check Sampel Received
            ↓
4. Mulai Pengujian → 5. Input Test Results → 6. Upload Laporan
                       ↓
7. Mark Complete → 8. Return to Staff for Review
```

---

## 🚀 Deployment & Environment

### **Development**
- Local setup dengan Laragon
- SQLite atau MySQL lokal
- Sandbox Duitku untuk testing

### **Production**
- Server dedicated/cloud
- MySQL production
- HTTPS/SSL certificate
- Duitku production account
- Environment-based configuration

### **Configuration Files**
- `.env`: Environment variables
- `config/app.php`: Application config
- `config/database.php`: Database config
- `config/duitku.php`: Payment gateway config
- `config/filament-spatie-roles-permissions.php`: RBAC config

---

## 📈 Statistik & Monitoring

### **Metrics Tracked**
- Total applications per month
- Payment success rate
- Average processing time
- Completed applications
- Pending applications
- User activity

### **Logging**
- Application logs: `storage/logs/laravel.log`
- Payment logs: Detailed payment transaction logs
- Database activity: Query logs (development)

---

## 🔐 Compliance & Best Practices

### **Security**
- ✅ Password hashing
- ✅ CSRF protection
- ✅ SQL injection prevention
- ✅ XSS protection
- ✅ Rate limiting
- ✅ Secure payment handling
- ✅ API key protection

### **Data Privacy**
- ✅ Soft deletes untuk audit trail
- ✅ User data protection
- ✅ Payment data encryption (via Duitku)
- ✅ Compliance dengan payment processing standards

### **Code Quality**
- ✅ MVC architecture
- ✅ Object-oriented design
- ✅ SOLID principles
- ✅ DRY (Don't Repeat Yourself)
- ✅ Consistent coding standards
- ✅ Laravel best practices

---

## 📞 Support & Maintenance

### **Documentation**
- Code comments
- README files untuk setiap fitur
- API documentation (Duitku)
- Database schema documentation

### **Troubleshooting**
- Common issues documented
- Log analysis untuk debugging
- Testing procedures dokumentasi
- Rollback procedures

### **Maintenance**
- Regular backups
- Database optimization
- Security updates
- Dependency updates
- Performance monitoring

---

## 🎯 Fitur Future (Roadmap)

Fitur yang bisa ditambahkan di masa depan:
- [ ] SMS notifications
- [ ] Mobile app (iOS/Android)
- [ ] Advanced analytics
- [ ] Machine learning untuk prediction
- [ ] Multi-language support
- [ ] API gateway untuk third-party integration
- [ ] Blockchain untuk audit trail
- [ ] Advanced reporting tools

---

## 📝 Conclusion

**UPT2** adalah sistem manajemen permohonan pengujian yang komprehensif dan modern, dengan integrasi payment gateway yang aman dan user-friendly interface. Sistem ini dirancang untuk:

✅ Meningkatkan efisiensi operasional  
✅ Memberikan transparansi kepada pemohon  
✅ Otomasi workflow bisnis  
✅ Secure payment processing  
✅ Scalable dan maintainable architecture  

Dengan teknologi Laravel, Filament, dan Duitku Payment Gateway, sistem ini siap untuk production dan mampu menangani volume transaksi yang signifikan.

---

**Dokumentasi dibuat**: Desember 2025  
**Status**: Active Development  
**Version**: 1.0  
**Maintainer**: Tim Pengembang UPT2
