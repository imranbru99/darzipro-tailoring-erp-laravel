<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpenseResource\Pages;
use App\Models\Expense;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'হিসাব ও আর্থিক রিপোর্ট';

    protected static ?string $navigationLabel = 'দোকান ব্যয় ও খরচ (Expenses)';

    protected static ?string $modelLabel = 'খরচ / ব্যয়';

    protected static ?string $pluralModelLabel = 'খরচ তালিকা';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('খরচের বিবরণ')
                    ->schema([
                        Forms\Components\Select::make('branch_id')
                            ->label('শাখা (Branch)')
                            ->relationship('branch', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        Forms\Components\TextInput::make('title')
                            ->label('খরচের খাত / শিরোনাম')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('category')
                            ->label('খরচের ধরণ')
                            ->options([
                                'rent'             => 'দোকান ভাড়া (Shop Rent)',
                                'utility'          => 'বিদ্যুৎ / ইউটিলিটি বিল (Utility)',
                                'artisan_wage'     => 'কারিগর মজুরি প্রদান (Wage)',
                                'artisan_advance'  => 'কারিগর এডভান্স বা অগ্রিম (Advance)',
                                'haberdashery'     => 'সুতা, বক্রম, বোতাম ক্রয় (Materials)',
                                'tea_refreshment'  => 'চা ও আপ্যায়ন (Refreshment)',
                                'transport'        => 'যাতায়াত ও ডেলিভারি খরচ (Transport)',
                                'maintenance'      => 'মেশিন মেরামত ও সার্ভিসিং (Maintenance)',
                                'other'            => 'অন্যান্য খরচ (Other)',
                            ])
                            ->default('other')
                            ->required(),
                        Forms\Components\TextInput::make('amount')
                            ->label('টাকার পরিমাণ (৳ Amount)')
                            ->numeric()
                            ->prefix('৳')
                            ->required(),
                        Forms\Components\Select::make('payment_method')
                            ->label('পরিশোধের মাধ্যম')
                            ->options([
                                'cash'          => 'নগদ ক্যাশ (Cash)',
                                'bkash'         => 'বিকাশ (bKash)',
                                'nagad'         => 'নগদ (Nagad)',
                                'bank_transfer' => 'ব্যাংক ট্রান্সফার',
                            ])
                            ->default('cash')
                            ->required(),
                        Forms\Components\DatePicker::make('expense_date')
                            ->label('খরচের তারিখ')
                            ->default(now())
                            ->required(),
                        Forms\Components\Textarea::make('note')
                            ->label('অতিরিক্ত মন্তব্য')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('শিরোনাম')
                    ->searchable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('category')
                    ->label('খাত')
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'rent'             => 'দোকান ভাড়া',
                        'utility'          => 'বিদ্যুৎ বিল',
                        'artisan_wage'     => 'কারিগর মজুরি',
                        'artisan_advance'  => 'কারিগর এডভান্স',
                        'haberdashery'     => 'টেইলারিং মালামাল',
                        'tea_refreshment'  => 'চা ও আপ্যায়ন',
                        'transport'        => 'যাতায়াত',
                        'maintenance'      => 'মেশিন মেরামত',
                        default            => 'অন্যান্য',
                    }),
                Tables\Columns\TextColumn::make('branch.name')
                    ->label('শাখা')
                    ->badge(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('পরিমাণ')
                    ->money('BDT')
                    ->color('danger')
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('মাধ্যম')
                    ->badge(),
                Tables\Columns\TextColumn::make('expense_date')
                    ->label('তারিখ')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('branch_id')
                    ->label('শাখা')
                    ->relationship('branch', 'name'),
                Tables\Filters\SelectFilter::make('category')
                    ->label('খরচের খাত')
                    ->options([
                        'rent'            => 'দোকান ভাড়া',
                        'utility'         => 'বিদ্যুৎ বিল',
                        'artisan_advance' => 'কারিগর এডভান্স',
                        'haberdashery'    => 'মালামাল ক্রয়',
                    ]),
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
            'index'  => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpense::route('/create'),
            'edit'   => Pages\EditExpense::route('/{record}/edit'),
        ];
    }
}
