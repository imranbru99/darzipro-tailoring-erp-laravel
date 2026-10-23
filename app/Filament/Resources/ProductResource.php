<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static ?string $navigationGroup = 'ইনভেন্টরি ও গজ কাপড়';

    protected static ?string $navigationLabel = 'পণ্য ও গজ কাপড় (Products)';

    protected static ?string $modelLabel = 'পণ্য বা ফেব্রিক';

    protected static ?string $pluralModelLabel = 'পণ্য ও গজ কাপড় তালিকা';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('পণ্যের বিবরণ')
                    ->schema([
                        Forms\Components\Select::make('category_id')
                            ->label('ক্যাটেগরি (Category)')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->label('ক্যাটেগরি নাম (English)')
                                    ->required(),
                                Forms\Components\TextInput::make('bangla_name')
                                    ->label('ক্যাটেগরি নাম (বাংলা)'),
                            ]),
                        Forms\Components\Select::make('branch_id')
                            ->label('শাখা (Branch)')
                            ->relationship('branch', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        Forms\Components\TextInput::make('name')
                            ->label('পণ্যের নাম (English)')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('bangla_name')
                            ->label('পণ্যের নাম (বাংলা)')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('sku')
                            ->label('SKU বা বারকোড')
                            ->default(fn () => 'SKU-' . strtoupper(substr(uniqid(), -6)))
                            ->required()
                            ->unique(ignoreRecord: true),
                        Forms\Components\Select::make('product_type')
                            ->label('পণ্যের ধরন')
                            ->options([
                                'fabric'    => 'গজ কাপড় (Fabric per Yard)',
                                'readymade' => 'তৈরি পোশাক (Readymade Garment)',
                                'accessory' => 'এক্সেসরিজ (আতর, টুপি, কাফলিংক)',
                                'trimming'  => 'টেইলারিং ম্যাটেরিয়াল (বোতাম, বক্রম, সুতা)',
                            ])
                            ->default('fabric')
                            ->required(),
                        Forms\Components\Select::make('unit')
                            ->label('পরিমাপের একক (Unit)')
                            ->options([
                                'yard'  => 'গজ (Yard)',
                                'meter' => 'মিটার (Meter)',
                                'piece' => 'পিস (Piece)',
                                'roll'  => 'রোল (Roll)',
                            ])
                            ->default('yard')
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('মূল্য ও স্টক ব্যবস্থাপনা')
                    ->schema([
                        Forms\Components\TextInput::make('cost_price')
                            ->label('ক্রয়মূল্য (Cost Price)')
                            ->numeric()
                            ->prefix('৳')
                            ->default(0.00),
                        Forms\Components\TextInput::make('selling_price')
                            ->label('বিক্রয়মূল্য (Selling Price)')
                            ->numeric()
                            ->prefix('৳')
                            ->default(0.00)
                            ->required(),
                        Forms\Components\TextInput::make('stock_quantity')
                            ->label('বর্তমান স্টক (গজ বা পিস)')
                            ->numeric()
                            ->default(100.00)
                            ->required(),
                        Forms\Components\TextInput::make('low_stock_threshold')
                            ->label('লো-স্টক এলার্ট সীমা')
                            ->numeric()
                            ->default(10.00),
                        Forms\Components\TextInput::make('fabric_composition')
                            ->label('কাপড়ের উপাদান')
                            ->placeholder('যেমন: ১০০% মিশরীয় গিজা কটন, সিল্ক, লিনেন'),
                        Forms\Components\TextInput::make('color')
                            ->label('রং (Color)')
                            ->placeholder('যেমন: অফ-হোয়াইট, নেভি ব্লু'),
                        Forms\Components\Toggle::make('is_featured')
                            ->label('অনলাইন ক্যাটালগে ফিচার্ড করুন')
                            ->default(true),
                        Forms\Components\Toggle::make('is_active')
                            ->label('সক্রিয় (Active)')
                            ->default(true),
                        Forms\Components\Textarea::make('description')
                            ->label('বিবরণ')
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
                    ->description(fn ($record) => $record->bangla_name ?? '')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('product_type')
                    ->label('ধরন')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'fabric'    => 'primary',
                        'readymade' => 'success',
                        'accessory' => 'warning',
                        default     => 'gray',
                    }),
                Tables\Columns\TextColumn::make('selling_price')
                    ->label('বিক্রয়মূল্য')
                    ->money('BDT')
                    ->sortable(),
                Tables\Columns\TextColumn::make('stock_quantity')
                    ->label('মজুদ স্টক')
                    ->formatStateUsing(fn ($record) => "{$record->stock_quantity} {$record->unit}")
                    ->color(fn ($record) => $record->isLowStock() ? 'danger' : 'success')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('সক্রিয়')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('product_type')
                    ->label('ধরন')
                    ->options([
                        'fabric'    => 'গজ কাপড়',
                        'readymade' => 'তৈরি পোশাক',
                        'accessory' => 'এক্সেসরিজ',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('সক্রিয়তা'),
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
            'index'  => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit'   => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
