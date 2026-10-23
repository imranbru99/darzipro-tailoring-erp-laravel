<?php

namespace App\Filament\Resources\KarigarJobSlipResource\Pages;

use App\Filament\Resources\KarigarJobSlipResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKarigarJobSlips extends ListRecords
{
    protected static string $resource = KarigarJobSlipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('কারিগরকে কাজ বরাদ্দ করুন'),
        ];
    }
}
