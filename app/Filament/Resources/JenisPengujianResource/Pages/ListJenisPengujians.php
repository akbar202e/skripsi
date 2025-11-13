<?php

namespace App\Filament\Resources\JenisPengujianResource\Pages;

use App\Filament\Resources\JenisPengujianResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJenisPengujians extends ListRecords
{
    protected static string $resource = JenisPengujianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}