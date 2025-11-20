<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PermohonanResource\Pages;
use App\Filament\Resources\PermohonanResource\RelationManagers;
use App\Models\Permohonan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Get;
use Filament\Forms\Set;

class PermohonanResource extends Resource
{
    protected static ?string $model = Permohonan::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Permohonan';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Permohonan')
                    ->schema([
                        Forms\Components\TextInput::make('judul')
                            ->required()
                            ->maxLength(100)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('isi')
                            ->required()
                            ->rows(10)
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('surat_permohonan')
                            ->label('Upload Surat Permohonan (PDF)')
                            ->acceptedFileTypes(['application/pdf'])
                            ->directory('permohonan')
                            ->disk('public')
                            ->downloadable()
                            ->openable()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Forms\Components\Section::make('Jenis Pengujian & Biaya')
                    ->schema([
                        Forms\Components\TextInput::make('total_biaya')
                            ->label('Total Biaya')
                            ->prefix('Rp')
                            ->numeric()
                            ->readOnly()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Forms\Components\Section::make('Laporan Hasil')
                    ->schema([
                        Forms\Components\FileUpload::make('laporan_hasil')
                            ->label('Upload Laporan Hasil (PDF)')
                            ->acceptedFileTypes(['application/pdf'])
                            ->directory('permohonan')
                            ->disk('public')
                            ->downloadable()
                            ->openable()
                            ->visible(fn (Get $get) => in_array($get('status'), ['menyusun_laporan', 'selesai']))
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Forms\Components\Section::make('Keterangan Perbaikan')
                    ->schema([
                        Forms\Components\Placeholder::make('keterangan')
                            ->label('Keterangan Perbaikan')
                            ->content(fn ($record): ?string => $record?->keterangan)
                            ->columnSpanFull()
                            ->hidden(fn ($record): bool => empty($record?->keterangan)),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (Permohonan $record): string => match ($record->status) {
                        'menunggu_verifikasi' => 'gray',
                        'perlu_perbaikan' => 'warning',
                        'menunggu_pembayaran_sampel' => 'info',
                        'sedang_diuji' => 'info',
                        'menyusun_laporan' => 'warning',
                        'selesai' => 'success',
                        default => 'secondary',
                    })
                    ->label('Status')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'menunggu_verifikasi' => 'Menunggu Verifikasi',
                        'perlu_perbaikan' => 'Perlu Perbaikan',
                        'menunggu_pembayaran_sampel' => 'Menunggu Pembayaran & Sampel',
                        'sedang_diuji' => 'Sedang Diuji',
                        'menyusun_laporan' => 'Menyusun Laporan',
                        'selesai' => 'Selesai',
                        default => 'Unknown',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_biaya')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('pemohon.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('worker.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn() => auth()->user()->hasRole('Admin')),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('lanjut_pembayaran_sampel')
                        ->label('Terima - Lanjut Pembayaran')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->visible(fn (Permohonan $record) => 
                            $record->status === 'menunggu_verifikasi' && 
                            auth()->user()->hasRole('Petugas') &&
                            ($record->worker_id === null || $record->worker_id === auth()->id()))
                        ->action(function (Permohonan $record) {
                            $record->update([
                                'status' => 'menunggu_pembayaran_sampel',
                                'worker_id' => auth()->id(),
                                'keterangan' => null // Clear keterangan when accepting
                            ]);
                        }),
                    Tables\Actions\Action::make('tolak_perbaikan')
                        ->label('Tolak - Perlu Perbaikan')
                        ->icon('heroicon-o-x-mark')
                        ->color('warning')
                        ->visible(fn (Permohonan $record) => 
                            $record->status === 'menunggu_verifikasi' && 
                            auth()->user()->hasRole('Petugas') &&
                            ($record->worker_id === null || $record->worker_id === auth()->id()))
                        ->form([
                            Forms\Components\Textarea::make('keterangan')
                                ->label('Keterangan Perbaikan')
                                ->required(),
                        ])
                        ->action(function (Permohonan $record, array $data) {
                            $record->update([
                                'status' => 'perlu_perbaikan',
                                'keterangan' => $data['keterangan'],
                                'worker_id' => auth()->id()
                            ]);
                        }),
                    Tables\Actions\Action::make('mulai_pengujian')
                        ->label('Mulai Pengujian')
                        ->icon('heroicon-o-beaker')
                        ->color('info')
                        ->requiresConfirmation()
                        ->visible(fn (Permohonan $record) => 
                            $record->status === 'menunggu_pembayaran_sampel' && 
                            auth()->user()->hasRole('Petugas') &&
                            $record->worker_id === auth()->id())
                        ->action(function (Permohonan $record) {
                            $record->update(['status' => 'sedang_diuji']);
                        }),
                    Tables\Actions\Action::make('selesai_pengujian')
                        ->label('Selesai Pengujian - Menyusun Laporan')
                        ->icon('heroicon-o-document-text')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->visible(fn (Permohonan $record) => 
                            $record->status === 'sedang_diuji' && 
                            auth()->user()->hasRole('Petugas') &&
                            $record->worker_id === auth()->id())
                        ->action(function (Permohonan $record) {
                            $record->update(['status' => 'menyusun_laporan']);
                        }),
                    Tables\Actions\Action::make('finalisasi_selesai')
                        ->label('Finalisasi - Selesai')
                        ->icon('heroicon-o-check-badge')
                        ->color('success')
                        ->requiresConfirmation()
                        ->visible(fn (Permohonan $record) => 
                            $record->status === 'menyusun_laporan' && 
                            auth()->user()->hasRole('Petugas') &&
                            $record->worker_id === auth()->id())
                        ->form([
                            Forms\Components\FileUpload::make('laporan_hasil')
                                ->label('Upload Laporan Hasil (PDF)')
                                ->acceptedFileTypes(['application/pdf'])
                                ->directory('permohonan')
                                ->disk('public')
                                ->required(),
                        ])
                        ->action(function (Permohonan $record, array $data) {
                            $record->update([
                                'status' => 'selesai',
                                'laporan_hasil' => $data['laporan_hasil']
                            ]);
                        }),
                ])
                ->visible(fn() => auth()->user()->hasRole('Petugas')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ])
                ->visible(fn() => auth()->user()->hasRole('Admin')),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\JenisPengujiansRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPermohonans::route('/'),
            'create' => Pages\CreatePermohonan::route('/create'),
            'view' => Pages\ViewPermohonan::route('/{record}'),
            'edit' => Pages\EditPermohonan::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ])
            ->when(auth()->user()->hasRole('Pemohon'), function($query){
                $query->where('user_id', auth()->user()->id);
            });
    }
}
