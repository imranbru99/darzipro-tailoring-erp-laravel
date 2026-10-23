<?php

namespace App\Filament\Resources\TailoringOrderResource\Pages;

use App\Filament\Resources\TailoringOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTailoringOrders extends ListRecords
{
    protected static string $resource = TailoringOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('নতুন অর্ডার গ্রহণ করুন'),
        ];
    }
}
