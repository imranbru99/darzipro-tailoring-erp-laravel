<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BranchResource\Pages;
use App\Models\Branch;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BranchResource extends Resource
{
    protected static ?string $model = Branch::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    protected static ?string $navigationGroup = 'সিস্টেম ও শাখা সেটিংস';

    protected static ?string $navigationLabel = 'শাখা তালিকা (Branches)';

    protected static ?string $modelLabel = 'শাখা';

    protected static ?string $pluralModelLabel = 'শাখাসমূহ';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('শাখার তথ্য')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('শাখার নাম (English)')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('bangla_name')
                            ->label('শাখার নাম (বাংলা)')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('code')
                            ->label('শাখা কোড (Code e.g. DHK, CTG, UTR)')
                            ->required()
                            ->maxLength(20)
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('phone')
                            ->label('মোবাইল / হেল্পলাইন')
                            ->tel(),
                        Forms\Components\TextInput::make('email')
                            ->label('ইমেইল')
                            ->email(),
                        Forms\Components\Toggle::make('is_active')
                            ->label('শাখাটি সক্রিয়')
                            ->default(true),
                        Forms\Components\Textarea::make('address')
                            ->label('শাখার বিস্তারিত ঠিকানা')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('শাখা')
                    ->description(fn ($record) => $record->bangla_name ?? '')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('code')
                    ->label('কোড')
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('phone')
                    ->label('ফোন')
                    ->searchable(),
                Tables\Columns\TextColumn::make('orders_count')
                    ->label('মোট অর্ডার')
                    ->counts('orders')
                    ->badge()
                    ->color('success'),
                Tables\Columns\TextColumn::make('users_count')
                    ->label('মোট স্টাফ / কারিগর')
                    ->counts('users')
                    ->badge()
                    ->color('primary'),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('সক্রিয়')
                    ->boolean(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index'  => Pages\ListBranches::route('/'),
            'create' => Pages\CreateBranch::route('/create'),
            'edit'   => Pages\EditBranch::route('/{record}/edit'),
        ];
    }
}
