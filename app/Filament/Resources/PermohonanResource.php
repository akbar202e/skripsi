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
                    ->downloadable()
                    ->openable()
                    ->columnSpanFull(),
                Forms\Components\Select::make('jenis_pengujian')
                    ->relationship('jenisPengujians', 'nama_pengujian')
                    ->multiple()
                    ->required()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function ($state, Set $set) {
                        $total = \App\Models\JenisPengujian::whereIn('id', $state)->sum('biaya');
                        $set('total_biaya', $total);
                    })
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('total_biaya')
                    ->label('Total Biaya')
                    ->prefix('Rp')
                    ->numeric(),
                Forms\Components\FileUpload::make('laporan_hasil')
                    ->label('Upload Laporan Hasil (PDF)')
                    ->acceptedFileTypes(['application/pdf'])
                    ->downloadable()
                    ->openable()
                    ->visible(fn (Get $get) => in_array($get('status'), ['selesai']))
                    ->columnSpanFull(),
                Forms\Components\Placeholder::make('keterangan')
                    ->label('Keterangan Perbaikan') // Tetap tampilkan label
                    ->content(fn ($record): ?string => $record?->keterangan) // Ambil konten dari record
                    ->columnSpanFull()
                                // Opsional: Sembunyikan field ini jika keterangannya kosong
                    ->hidden(fn ($record): bool => empty($record?->keterangan)), 
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
                        'permohonan_masuk' => 'gray',
                        'verifikasi_berkas' => 'info',
                        'perlu_perbaikan' => 'warning',
                        'terverifikasi' => 'success',
                        'menunggu_sampel_dan_pembayaran' => 'warning',
                        'proses_administrasi' => 'info',
                        'pengujian' => 'info',
                        'selesai' => 'success',
                        default => 'secondary',
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
                    Tables\Actions\Action::make('verifikasi_berkas')
                        ->label('Verifikasi Berkas')
                        ->icon('heroicon-o-check')
                        ->requiresConfirmation()
                        ->visible(fn (Permohonan $record) => 
                            $record->status === 'permohonan_masuk' && 
                            auth()->user()->hasRole('Petugas'))
                        ->action(function (Permohonan $record) {
                            $record->update([
                                'status' => 'verifikasi_berkas',
                                'worker_id' => auth()->id()
                            ]);
                        }),
                    Tables\Actions\Action::make('perlu_perbaikan')
                        ->label('Perlu Perbaikan')
                        ->icon('heroicon-o-x-mark')
                        ->color('warning')
                        ->visible(fn (Permohonan $record) => 
                            $record->status === 'verifikasi_berkas' && 
                            auth()->user()->hasRole('Petugas'))
                        ->form([
                            Forms\Components\Textarea::make('keterangan')
                                ->label('Keterangan Perbaikan')
                                ->required(),
                        ])
                        ->action(function (Permohonan $record, array $data) {
                            $record->update([
                                'status' => 'perlu_perbaikan',
                                'keterangan' => $data['keterangan']
                            ]);
                        }),
                    Tables\Actions\Action::make('terverifikasi')
                        ->label('Terverifikasi')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->visible(fn (Permohonan $record) => 
                            $record->status === 'verifikasi_berkas' && 
                            auth()->user()->hasRole('Petugas'))
                        ->action(function (Permohonan $record) {
                            $record->update(['status' => 'terverifikasi']);
                        }),
                    Tables\Actions\Action::make('konfirmasi_sampel')
                        ->label('Konfirmasi Sampel & Pembayaran')
                        ->icon('heroicon-o-banknotes')
                        ->requiresConfirmation()
                        ->visible(fn (Permohonan $record) => 
                            $record->status === 'terverifikasi' && 
                            auth()->user()->hasRole('Petugas'))
                        ->action(function (Permohonan $record) {
                            $record->update(['status' => 'proses_administrasi']);
                        }),
                    Tables\Actions\Action::make('mulai_pengujian')
                        ->label('Mulai Pengujian')
                        ->icon('heroicon-o-beaker')
                        ->requiresConfirmation()
                        ->visible(fn (Permohonan $record) => 
                            $record->status === 'proses_administrasi' && 
                            auth()->user()->hasRole('Petugas'))
                        ->action(function (Permohonan $record) {
                            $record->update(['status' => 'pengujian']);
                        }),
                    Tables\Actions\Action::make('selesai')
                        ->label('Selesai')
                        ->icon('heroicon-o-check-badge')
                        ->color('success')
                        ->requiresConfirmation()
                        ->visible(fn (Permohonan $record) => 
                            $record->status === 'pengujian' && 
                            auth()->user()->hasRole('Petugas'))
                        ->form([
                            Forms\Components\FileUpload::make('laporan_hasil')
                                ->label('Upload Laporan Hasil (PDF)')
                                ->acceptedFileTypes(['application/pdf'])
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
            //
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
