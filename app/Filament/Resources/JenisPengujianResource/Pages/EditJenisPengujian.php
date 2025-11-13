<?php

namespace App\Filament\Resources\JenisPengujianResource\Pages;

use App\Filament\Resources\JenisPengujianResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJenisPengujian extends EditRecord
{
    protected static string $resource = JenisPengujianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}