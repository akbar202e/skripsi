<?php

namespace App\Filament\Resources\PermohonanResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class JenisPengujiansRelationManager extends RelationManager
{
    protected static string $relationship = 'jenisPengujians';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('id')
                    ->label('Jenis Pengujian')
                    ->options(\App\Models\JenisPengujian::pluck('nama_pengujian', 'id'))
                    ->required()
                    ->searchable()
                    ->distinct()
                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                    ->disabled(fn (string $operation) => $operation === 'edit'),
                Forms\Components\TextInput::make('jumlah_sampel')
                    ->label('Jumlah Sampel')
                    ->numeric()
                    ->required()
                    ->minValue(1)
                    ->default(1),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama_pengujian')
            ->columns([
                Tables\Columns\TextColumn::make('nama_pengujian')
                    ->label('Jenis Pengujian')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('biaya')
                    ->label('Biaya Per Sampel')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('pivot.jumlah_sampel')
                    ->label('Jumlah Sampel')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_harga')
                    ->label('Total Harga')
                    ->money('IDR')
                    ->state(function (Model $record) {
                        if ($record->pivot) {
                            return $record->biaya * $record->pivot->jumlah_sampel;
                        }
                        return 0;
                    }),
            ])
            ->filters([])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->after(function () {
                        $this->calculateTotalBiaya();
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->after(function () {
                        $this->calculateTotalBiaya();
                    }),
                Tables\Actions\DeleteAction::make()
                    ->after(function () {
                        $this->calculateTotalBiaya();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->after(function () {
                            $this->calculateTotalBiaya();
                        }),
                ]),
            ]);
    }

    protected function calculateTotalBiaya(): void
    {
        $total = 0;
        $this->getOwnerRecord()->refresh();
        foreach ($this->getOwnerRecord()->jenisPengujians as $jenis) {
            $total += $jenis->biaya * $jenis->pivot->jumlah_sampel;
        }
        $this->getOwnerRecord()->update(['total_biaya' => $total]);
    }
}
