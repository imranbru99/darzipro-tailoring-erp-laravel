<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ModuleSettingResource\Pages;
use App\Models\ModuleSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ModuleSettingResource extends Resource
{
    protected static ?string $model = ModuleSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-puzzle-piece';

    protected static ?string $navigationGroup = 'সিস্টেম ও শাখা সেটিংস';

    protected static ?string $navigationLabel = 'মডিউল অন/অফ কন্ট্রোল (Module Control)';

    protected static ?string $modelLabel = 'মডিউল সেটিংস';

    protected static ?string $pluralModelLabel = 'মডিউল নিয়ন্ত্রণ';

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('মডিউল নিয়ন্ত্রণ')
                    ->description('আপনার ব্যবসার ধরণ অনুযায়ী যেকোনো ফিচার চালু বা বন্ধ রাখতে পারেন')
                    ->schema([
                        Forms\Components\Select::make('branch_id')
                            ->label('শাখা নির্বাচন (নির্দিষ্ট শাখার জন্য, খালি রাখলে সবার জন্য প্রযোজ্য)')
                            ->relationship('branch', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        Forms\Components\TextInput::make('module_key')
                            ->label('মডিউল আইডি (Module Key)')
                            ->required()
                            ->readOnly(fn ($record) => $record !== null),
                        Forms\Components\TextInput::make('name')
                            ->label('মডিউল নাম (English)')
                            ->required(),
                        Forms\Components\TextInput::make('bangla_name')
                            ->label('মডিউল নাম (বাংলা)'),
                        Forms\Components\Toggle::make('is_enabled')
                            ->label('মডিউলটি চালু রাখুন (Enable this module)')
                            ->default(true),
                        Forms\Components\Textarea::make('description')
                            ->label('মডিউলের সুবিধা ও বিবরণ')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('মডিউল')
                    ->description(fn ($record) => $record->bangla_name ?? '')
                    ->searchable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('module_key')
                    ->label('কী (Key)')
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('branch.name')
                    ->label('প্রযোজ্য শাখা')
                    ->placeholder('সকল শাখা (Global Default)'),
                Tables\Columns\ToggleColumn::make('is_enabled')
                    ->label('চালু / বন্ধ'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('সর্বশেষ পরিবর্তন')
                    ->dateTime('d M Y, h:i A')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListModuleSettings::route('/'),
            'create' => Pages\CreateModuleSetting::route('/create'),
            'edit'   => Pages\EditModuleSetting::route('/{record}/edit'),
        ];
    }
}
