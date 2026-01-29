# BAB 4: HASIL DAN PEMBAHASAN
## 4.1 Tampilan Halaman Sistem

### 4.1.1 Halaman Utama (Homepage)

Halaman utama merupakan halaman pertama yang dilihat pengunjung ketika membuka website sistem manajemen permohonan pengujian. Halaman ini dapat diakses oleh siapa saja tanpa memerlukan login. Halaman utama menampilkan beberapa bagian utama yaitu navigasi bar yang menampilkan logo dan menu navigasi, hero section dengan judul menarik dan deskripsi singkat tentang sistem, section tentang yang menjelaskan tujuan dan manfaat UPT2, section fitur yang menampilkan 6 fitur utama sistem dalam bentuk kartu dengan emoji dan deskripsi, serta section yang menampilkan daftar jenis pengujian dalam bentuk tabel dengan pagination "Load More" yang memungkinkan pengguna melihat 10 item pertama dan menampilkan item berikutnya dengan klik tombol. Halaman ini juga dilengkapi dengan section call-to-action yang mengajak pengunjung untuk mendaftar dan footer yang berisi informasi kontak serta menu penting. Desain halaman menggunakan gradient color dengan palet warna ungu dan biru yang modern serta fully responsive untuk berbagai ukuran layar.

---

### 4.1.2 Halaman Login

Halaman login merupakan pintu masuk bagi pengguna yang sudah terdaftar untuk mengakses sistem. Halaman ini meminta masukan berupa email dan password dari pengguna. Fitur utama halaman login mencakup form input email dengan validasi format email, form input password yang aman, tombol "Lupa Password" untuk reset password, tombol login untuk memproses autentikasi pengguna, dan link menuju halaman registrasi untuk pengguna yang belum memiliki akun. Halaman ini juga menampilkan pesan error jika login gagal dengan memberitahu kredensial yang salah. Desain halaman login menggunakan antarmuka yang bersih dan mengikuti style dari admin panel Filament dengan fokus pada kesederhanaan dan keamanan.

---

### 4.1.3 Halaman Registrasi

Halaman registrasi memungkinkan calon pengguna mendaftar akun baru di sistem. Halaman ini menampilkan form dengan beberapa field yaitu nama lengkap, email, password, dan konfirmasi password. Fitur utama halaman registrasi mencakup validasi input untuk memastikan semua field terisi dengan benar, pengecekan email yang unik untuk mencegah duplikasi akun, pengecekan kesesuaian password dan konfirmasi password, serta tombol registrasi untuk membuat akun baru. Halaman ini juga menyediakan link kembali ke halaman login untuk pengguna yang sudah memiliki akun. Setelah berhasil mendaftar, pengguna akan mendapatkan role default "Pemohon" sehingga dapat langsung menggunakan sistem untuk membuat permohonan pengujian.

---

### 4.1.4 Halaman Dashboard

Halaman dashboard merupakan halaman utama setelah pengguna login. Halaman ini menampilkan informasi ringkas dan navigasi ke semua fitur sistem. Halaman dashboard menampilkan welcome message yang menyapa pengguna, account widget yang menampilkan profil pengguna, dan navigasi ke semua menu utama sistem dalam bentuk sidebar. Fitur utama dashboard mencakup overview statistik yang ringkas, tautan menuju semua resource utama seperti Permohonan, Pembayaran, Jenis Pengujian, dan Pengguna. Tampilan dashboard akan berbeda-beda tergantung role pengguna sehingga setiap role hanya melihat menu dan fitur yang sesuai dengan wewenang mereka. Desain dashboard mengikuti design system Filament v3 dengan interface yang intuitif dan user-friendly.

---

### 4.1.5 Halaman Permohonan (Manajemen Permohonan)

Halaman permohonan merupakan pusat manajemen semua permohonan pengujian dalam sistem. Halaman ini menampilkan tabel daftar semua permohonan dengan informasi lengkap untuk setiap permohonan. Fitur utama halaman permohonan mencakup tabel dengan kolom judul permohonan, status (dalam badge berwarna), pembayaran, sampel, total biaya, nama pemohon, nama worker, dan waktu pembuatan. Status permohonan ditampilkan dalam bentuk badge dengan warna yang berbeda-beda untuk memudahkan identifikasi, yaitu warna abu untuk menunggu verifikasi, warna kuning untuk perlu perbaikan, warna biru untuk menunggu pembayaran dan sampel, warna biru untuk sedang diuji, warna kuning untuk menyusun laporan, dan warna hijau untuk selesai.

Halaman permohonan juga dilengkapi dengan fitur pencarian dan filter untuk memudahkan pengguna menemukan permohonan tertentu, fitur export data ke format Excel, serta aksi untuk melihat detail, mengedit, dan menghapus permohonan. Form edit permohonan menampilkan beberapa section yaitu informasi permohonan dengan field judul, isi, dan upload surat permohonan, jenis pengujian dan biaya dengan field total biaya yang read-only, status pembayaran dan sampel dengan checkbox untuk menandai pembayaran dan penerimaan sampel (hanya terlihat pada status tertentu), laporan hasil dengan field upload laporan (hanya terlihat saat menyusun laporan atau selesai), dan keterangan perbaikan yang menampilkan pesan jika ada catatan perbaikan dari staff.

Akses ke halaman permohonan berbeda tergantung role, dimana pemohon hanya dapat melihat permohonan miliknya sendiri dan dapat membuat permohonan baru, petugas dapat melihat semua permohonan dan mengelola status serta sampel, sementara admin dapat melihat dan mengelola semua aspek permohonan.

---

### 4.1.6 Halaman Jenis Pengujian

Halaman jenis pengujian merupakan halaman manajemen master data untuk jenis pengujian yang tersedia di laboratorium. Halaman ini menampilkan tabel daftar semua jenis pengujian dengan informasi lengkap. Fitur utama halaman jenis pengujian mencakup tabel dengan kolom nama pengujian, biaya (dalam format rupiah), waktu pembuatan, dan waktu update. Halaman juga dilengkapi dengan fitur pencarian untuk mencari jenis pengujian berdasarkan nama atau deskripsi, fitur filter untuk menyaring data, serta fitur export data ke format Excel untuk laporan atau analisis lebih lanjut.

Aksi yang tersedia pada halaman jenis pengujian mencakup tombol edit untuk mengubah data jenis pengujian dan tombol delete untuk menghapus data. Form edit jenis pengujian memiliki field nama pengujian, biaya dalam format rupiah dengan validasi numeric, dan deskripsi dalam format textarea. Akses ke halaman jenis pengujian umumnya terbatas pada admin dan petugas untuk manajemen data, sedangkan pemohon hanya dapat melihat daftar jenis pengujian saat membuat permohonan.

---

### 4.1.7 Halaman Pembayaran

Halaman pembayaran merupakan halaman untuk mengelola semua transaksi pembayaran dalam sistem. Halaman ini menampilkan tabel daftar semua pembayaran dengan informasi transaksi yang lengkap dan terperinci. Fitur utama halaman pembayaran mencakup tabel dengan kolom referensi duitku, permohonan terkait, pengguna pembayar, nominal pembayaran (dalam format rupiah), metode pembayaran, status pembayaran (dalam bentuk badge berwarna), dan waktu pembayaran.

Status pembayaran ditampilkan dalam bentuk badge dengan warna yang berbeda untuk setiap kondisi, yaitu warna kuning untuk status pending (menunggu), warna hijau untuk status success (berhasil), warna merah untuk status failed (gagal), dan warna abu untuk status expired (kadaluarsa). Halaman pembayaran juga dilengkapi dengan fitur pencarian untuk menemukan pembayaran tertentu, fitur filter untuk menyaring data berdasarkan status atau metode pembayaran, serta fitur export data ke format Excel.

Setiap record pembayaran dapat dilihat detail lengkapnya melalui tombol view, dan form detail pembayaran menampilkan beberapa section yaitu informasi pembayaran yang mencakup permohonan, pengguna, dan nominal, detail transaksi yang menampilkan merchant order ID, referensi duitku, metode pembayaran dan nama metode, serta status dan waktu pembayaran. Semua field dalam form pembayaran bersifat read-only karena pembayaran adalah informasi transaksi yang tidak boleh diubah setelah tercatat.

---

### 4.1.8 Halaman Pengguna

Halaman pengguna merupakan halaman untuk manajemen user dalam sistem. Halaman ini menampilkan tabel daftar semua pengguna yang terdaftar dengan informasi lengkap. Fitur utama halaman pengguna mencakup tabel dengan kolom nama pengguna, email, role yang dimiliki, waktu verifikasi email, waktu pembuatan akun, dan waktu update terakhir. Halaman pengguna dilengkapi dengan fitur pencarian untuk menemukan pengguna berdasarkan nama, email, atau role, fitur filter untuk menyaring user berdasarkan status (termasuk filter untuk user yang dihapus), serta fitur export data ke format Excel.

Aksi yang tersedia pada halaman pengguna mencakup tombol view untuk melihat detail pengguna, tombol edit untuk mengubah data dan role pengguna, dan tombol delete untuk menghapus akun pengguna. Form edit pengguna memiliki field nama lengkap, email dengan validasi format email, waktu verifikasi email, dan multi-select untuk memilih role atau peran pengguna dalam sistem. Akses ke halaman pengguna umumnya terbatas hanya pada admin untuk menjaga keamanan sistem, sedangkan user biasa tidak dapat mengakses halaman ini.

---

### 4.1.9 Halaman Panduan & Informasi (Dokumen)

Halaman panduan dan informasi merupakan halaman untuk menampilkan panduan, peraturan, dan informasi penting tentang sistem. Halaman ini menampilkan daftar semua dokumen dalam bentuk tabel dengan informasi lengkap. Fitur utama halaman dokumen mencakup tabel dengan kolom judul dokumen, kategori (peraturan atau informasi), pembuat dokumen, waktu pembuatan, dan waktu update. Halaman dokumen dilengkapi dengan fitur pencarian untuk menemukan dokumen berdasarkan judul atau deskripsi, fitur filter untuk menyaring dokumen berdasarkan kategori, serta fitur export data ke format Excel.

Aksi yang tersedia pada halaman dokumen mencakup tombol view untuk melihat preview gambar dokumen dengan fitur zoom in/zoom out, tombol edit untuk mengubah data dokumen, dan tombol delete untuk menghapus dokumen. Form edit dokumen memiliki field judul dokumen, deskripsi dalam format textarea, kategori dokumen (peraturan atau informasi), dan upload file gambar dengan validasi format (JPG, PNG) dan ukuran maksimal 20MB. Form juga menampilkan preview gambar dengan fitur pan-zoom untuk melihat detail dokumen dengan lebih baik.

Akses ke halaman dokumen umum terbatas pada admin untuk menambah dan mengedit dokumen, sedangkan user lain dapat melihat daftar dokumen untuk referensi. Halaman ini berguna untuk menyimpan berbagai panduan penggunaan sistem, peraturan laboratorium, dan informasi penting lainnya yang perlu diketahui oleh semua pengguna.

---

### 4.1.10 Halaman Tentang (About Page)

Halaman tentang merupakan halaman informasi yang menjelaskan lengkap tentang sistem UPT2. Halaman ini dapat diakses dari menu navigasi dalam admin panel setelah pengguna login. Fitur utama halaman tentang mencakup bagian hero dengan judul dan deskripsi singkat, bagian penjelasan apa itu UPT2 dengan informasi detail tentang sistem, bagian tujuan sistem yang menampilkan daftar tujuan dan manfaat sistem dalam bentuk poin-poin dengan checkmark, bagian fitur utama yang menampilkan 6 fitur utama dalam bentuk kartu dengan emoji dan deskripsi singkat.

Halaman tentang juga menampilkan tabel lengkap jenis pengujian yang tersedia dengan fitur load more pagination untuk menampilkan 10 item pertama dan dapat di-expand untuk melihat item berikutnya, bagian stack teknologi yang menampilkan teknologi utama yang digunakan dalam membangun sistem (Laravel, Filament, Spatie Roles, Duitku Payment), dan bagian kontak yang menampilkan informasi kontak untuk menghubungi pihak admin atau support. Desain halaman tentang mengikuti design system Filament dengan interface yang clean dan informasi yang terstruktur dengan baik.

---

## Ringkasan Alur Navigasi Sistem

Pengguna baru dimulai dari halaman homepage yang bersifat publik, kemudian dapat melakukan registrasi untuk membuat akun baru. Setelah memiliki akun, pengguna dapat login dan masuk ke dashboard yang akan menampilkan navigasi ke berbagai fitur sesuai dengan role mereka. Dari dashboard, pengguna dapat mengakses halaman-halaman lain seperti permohonan, pembayaran, jenis pengujian, pengguna (khusus admin), dokumen panduan, dan halaman tentang. Setiap halaman dilengkapi dengan fitur-fitur seperti pencarian, filter, export, dan aksi CRUD (Create, Read, Update, Delete) untuk manajemen data yang efisien.
