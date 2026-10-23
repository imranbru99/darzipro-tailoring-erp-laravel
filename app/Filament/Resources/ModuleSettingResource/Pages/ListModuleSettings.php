<?php

namespace App\Filament\Resources\ModuleSettingResource\Pages;

use App\Filament\Resources\ModuleSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListModuleSettings extends ListRecords
{
    protected static string $resource = ModuleSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('নতুন মডিউল যুক্ত করুন'),
        ];
    }
}
