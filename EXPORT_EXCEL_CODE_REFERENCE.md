# Code Reference - Export Excel Implementation

## Struktur Exporter Class

Setiap exporter mengikuti struktur dasar berikut:

```php
<?php

namespace App\Filament\Exports;

use App\Models\YourModel;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class YourExporter extends Exporter
{
    // Model yang akan di-export
    protected static ?string $model = YourModel::class;

    // Define kolom-kolom yang bisa di-export
    public static function getColumns(): array
    {
        return [
            // Simple column
            ExportColumn::make('column_name')
                ->label('Label Kolom'),
            
            // With formatting
            ExportColumn::make('price')
                ->label('Harga')
                ->formatStateUsing(fn ($state): string => 'Rp ' . number_format($state, 0, ',', '.')),
            
            // Boolean formatting
            ExportColumn::make('is_active')
                ->label('Status Aktif')
                ->formatStateUsing(fn (bool $state): string => $state ? 'Ya' : 'Tidak'),
            
            // Relationship
            ExportColumn::make('user.name')
                ->label('Nama User'),
            
            // With enum formatting
            ExportColumn::make('status')
                ->label('Status')
                ->formatStateUsing(fn (string $state): string => match ($state) {
                    'pending' => 'Menunggu',
                    'success' => 'Berhasil',
                    'failed' => 'Gagal',
                    default => $state,
                }),
        ];
    }

    // Custom filename untuk file yang dihasilkan
    public function getFileName(Export $export): string
    {
        return "your-resource-{$export->getKey()}.xlsx";
    }
}
```

---

## Contoh Implementasi di Resource

Cara menambahkan ExportAction ke dalam Resource:

```php
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\YourResource\Pages;
use App\Filament\Exports\YourExporter;  // ← Import exporter
use App\Models\YourModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\ExportAction;  // ← Import ExportAction

class YourResource extends Resource
{
    protected static ?string $model = YourModel::class;

    public static function form(Form $form): Form
    {
        // ... form definition
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // ... column definitions
            ])
            ->filters([
                // ... filter definitions
            ])
            // ← Add headerActions with ExportAction
            ->headerActions([
                ExportAction::make()
                    ->exporter(YourExporter::class)
                    ->label('Unduh Excel'),
            ])
            ->actions([
                // ... action definitions
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListYours::route('/'),
            'create' => Pages\CreateYour::route('/create'),
            'edit' => Pages\EditYour::route('/{record}/edit'),
        ];
    }
}
```

---

## Advanced ExportColumn Features

### 1. **Calculated State**
```php
ExportColumn::make('total_with_tax')
    ->label('Total dengan PPN')
    ->state(function ($record): float {
        return $record->total * 1.1; // 10% PPN
    })
```

### 2. **Limiting Text Length**
```php
ExportColumn::make('description')
    ->label('Deskripsi')
    ->limit(50)  // Max 50 characters
```

### 3. **Word Count Limit**
```php
ExportColumn::make('content')
    ->label('Konten')
    ->words(10)  // Max 10 words
```

### 4. **Prefix & Suffix**
```php
ExportColumn::make('phone')
    ->label('Telepon')
    ->prefix('+62 ')
    ->suffix(' (Mobile)')
```

### 5. **Relationship Count**
```php
ExportColumn::make('orders_count')
    ->label('Jumlah Pesanan')
    ->counts('orders')
```

### 6. **Relationship Existence**
```php
ExportColumn::make('has_invoice')
    ->label('Ada Invoice?')
    ->exists('invoice')
```

### 7. **Relationship Aggregation**
```php
ExportColumn::make('avg_rating')
    ->label('Rating Rata-rata')
    ->avg('reviews', 'rating')

// Atau dengan scope
ExportColumn::make('active_orders_sum')
    ->label('Total Pesanan Aktif')
    ->sum([
        'orders' => fn (Builder $query) => $query->where('status', 'active')
    ], 'amount')
```

### 8. **JSON Array Handling**
```php
ExportColumn::make('tags')
    ->label('Tags')
    ->listAsJson()  // Format sebagai JSON array
```

### 9. **Multiple Formatting**
```php
ExportColumn::make('status')
    ->label('Status')
    ->formatStateUsing(function (string $state): string {
        return match ($state) {
            'active' => '✅ Aktif',
            'inactive' => '❌ Nonaktif',
            'pending' => '⏳ Menunggu',
            default => $state,
        };
    })
```

---

## Custom Configuration pada Export Action

```php
use Filament\Tables\Actions\ExportAction;
use Filament\Actions\Exports\Enums\ExportFormat;

ExportAction::make()
    ->exporter(YourExporter::class)
    ->label('Unduh Excel')
    
    // Hanya format XLSX (bukan CSV)
    ->formats([ExportFormat::Xlsx])
    
    // Atau hanya CSV
    ->formats([ExportFormat::Csv])
    
    // Atau both (default)
    ->formats([ExportFormat::Xlsx, ExportFormat::Csv])
    
    // Custom max rows
    ->maxRows(50000)  // Default: 100000
    
    // Custom chunk size
    ->chunkSize(200)  // Default: 100
    
    // Disable column mapping
    ->columnMapping(false)  // User tidak bisa pilih kolom
    
    // Modify query sebelum export
    ->modifyQueryUsing(fn (Builder $query) => $query->where('is_active', true))
```

---

## Exporter Configuration Methods

```php
<?php

namespace App\Filament\Exports;

use App\Models\YourModel;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Filament\Actions\Exports\Enums\ExportFormat;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Common\Entity\Style\Color;

class YourExporter extends Exporter
{
    protected static ?string $model = YourModel::class;

    public static function getColumns(): array
    {
        return [
            // ... columns
        ];
    }

    // Tentukan format yang tersedia
    public function getFormats(): array
    {
        return [ExportFormat::Xlsx];  // Hanya XLSX
    }

    // Custom filename
    public function getFileName(Export $export): string
    {
        return "export-{$export->getKey()}.xlsx";
    }

    // Custom disk untuk menyimpan file
    public function getFileDisk(): string
    {
        return 'local';  // Default: public
    }

    // Modify query sebelum export
    public static function modifyQuery(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    // CSV delimiter (default comma)
    public static function getCsvDelimiter(): string
    {
        return ';';  // Semicolon untuk European format
    }

    // Styling untuk cell XLSX
    public function getXlsxCellStyle(): ?Style
    {
        return (new Style())
            ->setFontSize(11)
            ->setFontName('Calibri');
    }

    // Styling khusus untuk header XLSX
    public function getXlsxHeaderCellStyle(): ?Style
    {
        return (new Style())
            ->setFontBold()
            ->setFontSize(12)
            ->setBackgroundColor(Color::rgb(79, 129, 189))
            ->setFontColor(Color::rgb(255, 255, 255));
    }

    // Custom queue
    public function getJobQueue(): ?string
    {
        return 'exports';
    }

    // Custom connection
    public function getJobConnection(): ?string
    {
        return 'database';
    }

    // Job batch name
    public function getJobBatchName(): ?string
    {
        return 'your-model-exports';
    }

    // Lifecycle hooks
    protected function beforeValidate(): void
    {
        // Runs sebelum validasi
    }

    protected function afterValidate(): void
    {
        // Runs sesudah validasi
    }

    protected function beforeFill(): void
    {
        // Runs sebelum fill ke model
    }

    protected function afterFill(): void
    {
        // Runs sesudah fill ke model
    }

    protected function beforeSave(): void
    {
        // Runs sebelum save
    }

    protected function afterSave(): void
    {
        // Runs sesudah save
    }
}
```

---

## Contoh Real: PermohonanExporter

```php
<?php

namespace App\Filament\Exports;

use App\Models\Permohonan;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class PermohonanExporter extends Exporter
{
    protected static ?string $model = Permohonan::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('judul')
                ->label('Judul Permohonan'),
            
            ExportColumn::make('status')
                ->label('Status')
                ->formatStateUsing(fn (string $state): string => match ($state) {
                    'menunggu_verifikasi' => 'Menunggu Verifikasi',
                    'perlu_perbaikan' => 'Perlu Perbaikan',
                    'menunggu_pembayaran_sampel' => 'Menunggu Pembayaran & Sampel',
                    'sedang_diuji' => 'Sedang Diuji',
                    'menyusun_laporan' => 'Menyusun Laporan',
                    'selesai' => 'Selesai',
                    default => $state,
                }),
            
            ExportColumn::make('pemohon.name')
                ->label('Nama Pemohon'),
            
            ExportColumn::make('worker.name')
                ->label('Nama Petugas'),
            
            ExportColumn::make('total_biaya')
                ->label('Total Biaya')
                ->formatStateUsing(fn ($state): string => 
                    'Rp ' . number_format($state, 0, ',', '.')
                ),
            
            ExportColumn::make('is_paid')
                ->label('Pembayaran Selesai')
                ->formatStateUsing(fn (bool $state): string => 
                    $state ? 'Ya' : 'Tidak'
                ),
            
            ExportColumn::make('is_sample_ready')
                ->label('Sampel Diterima')
                ->formatStateUsing(fn (bool $state): string => 
                    $state ? 'Ya' : 'Tidak'
                ),
        ];
    }

    public function getFileName(Export $export): string
    {
        return "permohonan-{$export->getKey()}.xlsx";
    }
}
```

---

## Testing Exporter

```php
<?php

namespace Tests\Feature;

use App\Models\Permohonan;
use App\Filament\Exports\PermohonanExporter;
use Filament\Actions\Exports\Models\Export;
use Tests\TestCase;

class PermohonanExportTest extends TestCase
{
    public function test_exporter_has_columns()
    {
        $columns = PermohonanExporter::getColumns();
        
        $this->assertNotEmpty($columns);
        $this->assertCount(7, $columns);
    }

    public function test_exporter_generates_filename()
    {
        $exporter = new PermohonanExporter();
        
        $export = new Export([
            'id' => 123
        ]);
        
        $filename = $exporter->getFileName($export);
        
        $this->assertStringContainsString('permohonan-', $filename);
        $this->assertStringEndsWith('.xlsx', $filename);
    }

    public function test_exporter_can_format_state()
    {
        $columns = PermohonanExporter::getColumns();
        $statusColumn = collect($columns)->firstWhere('name', 'status');
        
        // Test format
        $this->assertNotNull($statusColumn);
    }
}
```

---

## Error Handling

```php
try {
    // Export process
    $export = ExportAction::make()
        ->exporter(YourExporter::class)
        ->dispatch();
} catch (\Exception $e) {
    // Log error
    \Log::error('Export failed: ' . $e->getMessage());
    
    // Notify user
    Notification::make()
        ->title('Export Gagal')
        ->body('Terjadi kesalahan: ' . $e->getMessage())
        ->danger()
        ->send();
}
```

---

## Performance Tips

1. **Use Chunk Size untuk Data Besar**
   ```php
   ->chunkSize(250)  // Increase dari default 100
   ```

2. **Use Queue untuk Better Performance**
   ```bash
   php artisan queue:work
   ```

3. **Filter Before Export**
   ```php
   ->modifyQueryUsing(fn (Builder $query) => 
       $query->where('created_at', '>', now()->subMonth())
   )
   ```

4. **Select Only Needed Columns**
   ```php
   ->modifyQueryUsing(fn (Builder $query) => 
       $query->select('id', 'name', 'email')
   )
   ```

5. **Add Index ke Database Column yang Sering di-Filter**
   ```php
   $table->index('status');
   $table->index('created_at');
   ```

---

## CLI Commands

```bash
# Generate new exporter
php artisan make:filament-exporter YourModel

# Generate with columns auto-generated
php artisan make:filament-exporter YourModel --generate

# Run queue listener
php artisan queue:listen

# Atau dengan database queue
php artisan queue:work database

# Check queue status
php artisan queue:failed

# Retry failed jobs
php artisan queue:retry all

# Clear queue
php artisan queue:flush
```

---

**Reference Guide Created: December 10, 2024**
