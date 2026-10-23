<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'দর্জি ও অর্ডার ব্যবস্থাপনা';

    protected static ?string $navigationLabel = 'গ্রাহক তালিকা (Customers)';

    protected static ?string $modelLabel = 'গ্রাহক';

    protected static ?string $pluralModelLabel = 'গ্রাহকবৃন্দ';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('গ্রাহকের প্রাথমিক তথ্য')
                    ->schema([
                        Forms\Components\Select::make('branch_id')
                            ->label('শাখা (Branch)')
                            ->relationship('branch', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        Forms\Components\TextInput::make('name')
                            ->label('গ্রাহকের নাম (Name)')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->label('মোবাইল নম্বর (Phone)')
                            ->required()
                            ->tel()
                            ->maxLength(20),
                        Forms\Components\TextInput::make('email')
                            ->label('ইমেইল (Email)')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\Select::make('gender')
                            ->label('জেন্ডার (Gender)')
                            ->options([
                                'male'   => 'পুরুষ (Male)',
                                'female' => 'মহিলা (Female)',
                                'other'  => 'অন্যান্য (Other)',
                            ])
                            ->default('male')
                            ->required(),
                        Forms\Components\TextInput::make('loyalty_points')
                            ->label('লয়্যালটি পয়েন্ট (Points)')
                            ->numeric()
                            ->default(0),
                        Forms\Components\Textarea::make('address')
                            ->label('ঠিকানা (Address)')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('special_notes')
                            ->label('বিশেষ নোট / পছন্দ (Special Preferences)')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('নাম')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('phone')
                    ->label('ফোন')
                    ->searchable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('branch.name')
                    ->label('শাখা')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('orders_count')
                    ->label('মোট অর্ডার')
                    ->counts('orders')
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('measurement_profiles_count')
                    ->label('সংরক্ষিত মাপ')
                    ->counts('measurementProfiles')
                    ->badge()
                    ->color('success'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('নিবন্ধন তারিখ')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('branch_id')
                    ->label('শাখা')
                    ->relationship('branch', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit'   => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
