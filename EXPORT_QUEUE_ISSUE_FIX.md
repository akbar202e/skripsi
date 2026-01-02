# Export Queue Issue - Root Cause & Solution

## Problem Summary
Notifikasi "Export started" muncul, tapi notifikasi "Export completed" tidak muncul ketika melakukan export data tabel.

## Root Causes

### 1. **Queue Worker Tidak Berjalan** (Primary Cause)
Filament export menggunakan async queue jobs untuk memproses export. Jika queue worker tidak berjalan, jobs akan menumpuk di database tapi tidak diproses.

**Status dalam proyek:**
- ✅ Queue connection: `database` (benar)
- ❌ Queue worker: Tidak berjalan (inilah masalahnya)

### 2. **Type Hint Error di Exporter Classes** (Secondary Cause)
Ada error di beberapa exporter file yang mencegah queue job berhasil:

**File yang bermasalah:**
1. `app/Filament/Exports/JenisPengujianExporter.php` - Line 26
2. `app/Filament/Exports/PermohonanExporter.php` - Lines 41, 44

**Masalah:**
```php
// ❌ SEBELUM (Type hint terlalu ketat)
->formatStateUsing(fn (bool $state): string => $state ? 'Ya' : 'Tidak')

// Masalah: Nilai is_active/is_paid/is_sample_ready bisa NULL, tidak hanya boolean
// Ini menyebabkan TypeError pada queue worker
```

**Solusi:**
```php
// ✅ SESUDAH (Menerima any type)
->formatStateUsing(fn ($state): string => $state ? 'Ya' : 'Tidak')
```

## Error Log Evidence
```
[2025-12-31 03:03:58] local.ERROR: App\Filament\Exports\JenisPengujianExporter::App\Filament\Exports\{closure}(): 
Argument #1 ($state) must be of type bool, null given, called in 
C:\laragon\www\skripsi\vendor\filament\support\src\Concerns\EvaluatesClosures.php on line 35
```

## Fixes Applied

### Fix #1: JenisPengujianExporter.php
**Changed Line 26:**
```php
// FROM:
->formatStateUsing(fn (bool $state): string => $state ? 'Ya' : 'Tidak'),

// TO:
->formatStateUsing(fn ($state): string => $state ? 'Ya' : 'Tidak'),
```

### Fix #2: PermohonanExporter.php
**Changed Lines 41 & 44:**
```php
// FROM:
->formatStateUsing(fn (bool $state): string => $state ? 'Ya' : 'Tidak'),

// TO:
->formatStateUsing(fn ($state): string => $state ? 'Ya' : 'Tidak'),
```

## Implementation Guide

### For Development
1. **Open Terminal 1 - Run Laravel Server:**
   ```bash
   php artisan serve
   ```

2. **Open Terminal 2 - Run Queue Worker:**
   ```bash
   php artisan queue:work database --verbose --timeout=300
   ```

3. **Now when you export data:**
   - Notifikasi "Export started" muncul (instantly)
   - Queue worker memproses file
   - Notifikasi "Export completed" muncul (setelah selesai)
   - File otomatis didownload

### For Production (Using Supervisor)

1. **Install Supervisor** (if not already installed)
   ```bash
   # For Windows using Laragon
   # Supervisor biasanya sudah include
   ```

2. **Create Supervisor config file** at `etc/supervisor/conf.d/laravel-queue.conf`:
   ```ini
   [program:laravel-queue-worker]
   process_name=%(program_name)s_%(process_num)02d
   command=php /var/www/skripsi/artisan queue:work database --timeout=300 --tries=3
   autostart=true
   autorestart=true
   numprocs=1
   redirect_stderr=true
   stdout_logfile=/var/www/skripsi/storage/logs/queue-worker.log
   ```

3. **Restart Supervisor:**
   ```bash
   supervisorctl reread
   supervisorctl update
   supervisorctl start laravel-queue-worker:*
   ```

4. **Check Status:**
   ```bash
   supervisorctl status
   ```

## Testing

### Manual Test
1. Go to any resource with export button (e.g., Jenis Pengujian)
2. Click "Unduh Excel" button
3. You should see:
   - ✅ "Export started" notification
   - ✅ File download starts automatically
   - ✅ "Rekap [Resource] berhasil diunduh" notification appears

### Verify Queue Processing
```bash
# Check pending jobs
php artisan tinker
> DB::table('jobs')->count()

# Should return 0 if queue worker is processing successfully
```

## Troubleshooting

### Queue Worker Stuck / Not Processing
1. **Clear all jobs:**
   ```bash
   php artisan queue:flush
   php artisan tinker
   > DB::table('jobs')->delete()
   ```

2. **Restart queue worker:**
   ```bash
   # Kill existing process (Ctrl+C)
   # Start new one:
   php artisan queue:work database --verbose
   ```

### Check Logs
```bash
tail -f storage/logs/laravel.log
```

### Jobs in Failed State
```bash
php artisan tinker
> DB::table('failed_jobs')->get()
```

## Key Learnings

1. **Queue Driver Selection:**
   - `database` - Good for development & small deployments
   - `redis` - Better for high-volume production
   - `sync` - Process immediately (no async, blocks UI)

2. **Filament Export Process:**
   - Jobs are created in `jobs` table
   - Queue worker processes them asynchronously
   - On completion, sends notification & marks job as done
   - File stored in `storage/app/private/`

3. **Type Hinting Best Practices:**
   - Be careful with nullable columns in formatStateUsing
   - Use `mixed` or `any` type when value could be null
   - Or use null coalescing: `$state ?? false`

## Files Modified
- `app/Filament/Exports/JenisPengujianExporter.php`
- `app/Filament/Exports/PermohonanExporter.php`

## Date Fixed
December 31, 2025
