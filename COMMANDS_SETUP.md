# 🔧 COMMANDS UNTUK SETUP PEMBAYARAN

Jalankan commands berikut untuk setup fitur pembayaran:

---

## 1️⃣ SETUP AWAL (Run Once)

```bash
# Pindah ke project directory
cd c:\laragon\www\skripsi

# Jalankan database migrations
php artisan migrate

# Seed payment methods
php artisan db:seed PaymentMethodSeeder

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Verify routes
php artisan route:list | grep payment
```

---

## 2️⃣ DEVELOPMENT SERVER

```bash
# Start development server
php artisan serve

# Server akan berjalan di http://localhost:8000
# Akses project di http://skripsi.test
```

---

## 3️⃣ PAYMENT COMMANDS

```bash
# Sync payment methods dari Duitku
php artisan payment:sync-methods 100000

# Check payment status (ganti ID sesuai pembayaran)
php artisan payment:check-status 1
```

---

## 4️⃣ DATABASE COMMANDS

```bash
# Reset database (WARNING: hapus semua data!)
php artisan migrate:reset

# Refresh database (reset + migrate + seed)
php artisan migrate:fresh --seed

# Check migration status
php artisan migrate:status
```

---

## 5️⃣ CACHE & CONFIG COMMANDS

```bash
# Clear all caches
php artisan cache:clear

# Clear config cache
php artisan config:clear

# Clear view cache
php artisan view:clear

# Clear all (termasuk compiled files)
php artisan cache:clear && php artisan config:clear && php artisan view:clear
```

---

## 6️⃣ TESTING COMMANDS

```bash
# Run tests (jika ada)
php artisan test

# Check for errors
php artisan tinker
  # Di dalam tinker shell, test service:
  # $service = app(\App\Services\DuitkuPaymentService::class);
  # exit()
```

---

## 7️⃣ DEBUG COMMANDS

```bash
# Lihat config duitku
php artisan config:get duitku

# Lihat environment variables
php artisan config:get app.url

# Tail logs (live monitoring)
tail -f storage/logs/laravel.log
```

---

## 8️⃣ PRODUCTION COMMANDS

```bash
# Compile assets
npm run build

# Optimize autoloader
composer install --optimize-autoloader --no-dev

# Optimize config (cache all config files)
php artisan config:cache

# Optimize routes
php artisan route:cache

# Optimize views
php artisan view:cache
```

---

## QUICK SETUP SEQUENCE

Copy-paste commands ini secara berurutan:

```bash
cd c:\laragon\www\skripsi
php artisan migrate
php artisan db:seed PaymentMethodSeeder
php artisan cache:clear
php artisan config:clear
echo "Setup selesai! Buka http://skripsi.test"
```

---

## TROUBLESHOOTING COMMANDS

```bash
# Jika ada error, jalankan:
php artisan cache:clear
php artisan config:clear

# Jika migration error, cek:
php artisan migrate:status

# Reset & start fresh:
php artisan migrate:fresh --seed

# Check database connection:
php artisan migrate --pretend  # Preview tanpa execute
```

---

## MAINTENANCE COMMANDS

```bash
# Backup database
mysqldump -u root upt > backup_$(date +%Y%m%d_%H%M%S).sql

# Check application logs
tail -100 storage/logs/laravel.log

# Monitor Duitku API calls
grep -i "duitku" storage/logs/laravel.log
```

---

## ARTISAN COMMANDS REFERENCE

### Payment Specific Commands
```
php artisan payment:sync-methods {amount}     - Sync payment methods
php artisan payment:check-status {id}         - Check payment status
```

### Standard Commands
```
php artisan migrate                           - Run pending migrations
php artisan migrate:fresh                     - Reset & migrate
php artisan migrate:fresh --seed              - Reset, migrate & seed
php artisan db:seed                           - Seed database
php artisan db:seed {Seeder}                 - Seed specific seeder
php artisan cache:clear                       - Clear all caches
php artisan config:clear                      - Clear config cache
php artisan serve                             - Start dev server
php artisan tinker                            - Interactive PHP shell
php artisan route:list                        - List all routes
```

---

## WINDOWS/LARAGON SPECIFIC

Jika menggunakan Laragon:

```bash
# Di Laragon terminal:
cd www\skripsi

# Run commands seperti biasa
php artisan migrate
php artisan serve

# Atau gunakan terminal built-in Laragon
# Klik project → Terminal
```

---

## NPM COMMANDS (untuk assets)

```bash
# Install dependencies
npm install

# Development mode
npm run dev

# Production build
npm run build

# Watch for changes
npm run watch
```

---

## QUICK REFERENCE

| Command | Tujuan |
|---------|--------|
| `php artisan migrate` | Run migrations |
| `php artisan db:seed PaymentMethodSeeder` | Seed payment methods |
| `php artisan cache:clear` | Clear cache |
| `php artisan serve` | Start dev server |
| `php artisan payment:sync-methods 100000` | Sync payment methods |
| `php artisan payment:check-status 1` | Check payment status |
| `php artisan route:list \| grep payment` | View payment routes |
| `tail -f storage/logs/laravel.log` | Monitor logs |

---

## NOTES

⚠️ **Important:**
- Jangan jalankan `migrate:fresh` di production!
- Backup database sebelum menjalankan reset commands
- Test di development dulu sebelum production
- Check logs jika ada error

✅ **Tip:**
- Selalu jalankan `cache:clear` dan `config:clear` setelah ubah config
- Monitor logs dengan `tail -f storage/logs/laravel.log`
- Use `--pretend` flag untuk preview migration tanpa execute

---

**Last Updated**: 6 Desember 2025
