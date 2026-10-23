<?php

namespace App\Filament\Resources\ModuleSettingResource\Pages;

use App\Filament\Resources\ModuleSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditModuleSetting extends EditRecord
{
    protected static string $resource = ModuleSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
