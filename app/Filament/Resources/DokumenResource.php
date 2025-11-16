<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Dokumen;
use Filament\Infolists;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Infolists\Components\TextInput;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\DokumenResource\Pages;
use SolutionForest\FilamentPanzoom\Components\PanZoom;
use SolutionForest\FilamentPanzoom\Infolists\Components\PanZoomEntry;

class DokumenResource extends Resource
{
    protected static ?string $model = Dokumen::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    protected static ?string $navigationLabel = 'Dokumen';

    protected static ?int $navigationSort = 2;

    public static function canViewAny(): bool
    {
        return Auth::user()?->can('viewAny', Dokumen::class) ?? false;
    }

    public static function canCreate(): bool
    {
        return Auth::user()?->can('create', Dokumen::class) ?? false;
    }

    public static function canEdit($record): bool
    {
        return Auth::user()?->can('update', $record) ?? false;
    }

    public static function canDelete($record): bool
    {
        return Auth::user()?->can('delete', $record) ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('judul')
                    ->required()
                    ->maxLength(255)
                    ->label('Judul Dokumen')
                    ->columnSpanFull(),
                
                Forms\Components\Textarea::make('deskripsi')
                    ->nullable()
                    ->maxLength(1000)
                    ->label('Deskripsi')
                    ->columnSpanFull()
                    ->rows(4),
                
                Forms\Components\Select::make('kategori')
                    ->required()
                    ->options([
                        'peraturan' => 'Peraturan',
                        'informasi' => 'Informasi',
                    ])
                    ->label('Kategori'),
                
                Forms\Components\FileUpload::make('image_path')
                    ->required()
                    ->image()
                    ->directory('dokumen')
                    ->disk('public')
                    ->maxSize(20480)
                    ->label('Upload Gambar')
                    ->columnSpanFull()
                    ->helperText('Format: JPG, PNG (max. 20MB)'),
                
                PanZoom::make('preview')
                    ->imageUrl(function ($record) {
                        if (!$record || !$record->image_path) {
                            return null;
                        }
                        return asset('storage/' . $record->image_path);
                    })
                    ->label('Preview Gambar')
                    ->columnSpanFull()
                    ->doubleClickZoomLevel(1.0)
                    ->hidden(fn ($livewire) => $livewire instanceof Pages\CreateDokumen),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->searchable()
                    ->sortable()
                    ->label('Judul'),
                
                Tables\Columns\TextColumn::make('kategori')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'peraturan' => 'info',
                        'informasi' => 'success',
                    })
                    ->label('Kategori'),
                
                Tables\Columns\BadgeColumn::make('image_path')
                    ->getStateUsing(fn () => 'IMG')
                    ->color('info')
                    ->label('Gambar'),
                
                Tables\Columns\TextColumn::make('creator.name')
                    ->label('Dibuat Oleh')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->label('Tanggal Dibuat')
                    ->sortable()
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->options([
                        'peraturan' => 'Peraturan',
                        'informasi' => 'Informasi',
                    ])
                    ->label('Filter Kategori'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn () => Auth::user()?->hasRole('Admin') ?? false),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn () => Auth::user()?->hasRole('Admin') ?? false),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ])->visible(fn () => Auth::user()?->hasRole('Admin') ?? false),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('judul')
                    ->label('Judul Dokumen'),
                
                Infolists\Components\TextEntry::make('kategori')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'peraturan' => 'info',
                        'informasi' => 'success',
                    })
                    ->label('Kategori'),
                
                Infolists\Components\TextEntry::make('deskripsi')
                    ->label('Deskripsi')
                    ->columnSpanFull(),
                
                // Infolists\Components\TextEntry::make('creator.name')
                //     ->label('Dibuat Oleh'),
                
                Infolists\Components\TextEntry::make('created_at')
                    ->badge()
                    ->color('danger')
                    ->dateTime('d M Y')
                    ->label(''),
                
                PanZoomEntry::make('image_path')
                    ->imageUrl(function ($record) {
                        if (!$record || !$record->image_path) {
                            return null;
                        }
                        return asset('storage/' . $record->image_path);
                    })
                    ->label('Gambar Dokumen')
                    ->columnSpanFull()
                    ->doubleClickZoomLevel(1.0)
                    ->imageId(fn ($record) => 'dokumen-' . $record->id),
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
            'index' => Pages\ListDokumens::route('/'),
            'create' => Pages\CreateDokumen::route('/create'),
            'edit' => Pages\EditDokumen::route('/{record}/edit'),
            'view' => Pages\ViewDokumen::route('/{record}'),
        ];
    }
}
