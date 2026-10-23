<?php

namespace App\Filament\Resources\TailoringOrderResource\Pages;

use App\Filament\Resources\TailoringOrderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTailoringOrder extends CreateRecord
{
    protected static string $resource = TailoringOrderResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = auth()->id();
        return $data;
    }
}
