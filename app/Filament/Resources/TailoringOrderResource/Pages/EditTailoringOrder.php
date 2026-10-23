<?php

namespace App\Filament\Resources\TailoringOrderResource\Pages;

use App\Filament\Resources\TailoringOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTailoringOrder extends EditRecord
{
    protected static string $resource = TailoringOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
