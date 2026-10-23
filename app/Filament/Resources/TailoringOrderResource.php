<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TailoringOrderResource\Pages;
use App\Models\Customer;
use App\Models\Product;
use App\Models\TailoringOrder;
use App\Services\TailoringDomainService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TailoringOrderResource extends Resource
{
    protected static ?string $model = TailoringOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-scissors';

    protected static ?string $navigationGroup = 'দর্জি ও অর্ডার ব্যবস্থাপনা';

    protected static ?string $navigationLabel = 'টেইলারিং অর্ডার (All Orders)';

    protected static ?string $modelLabel = 'টেইলারিং অর্ডার';

    protected static ?string $pluralModelLabel = 'টেইলারিং অর্ডারসমূহ';

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('অর্ডারের প্রাথমিক তথ্য')
                            ->schema([
                                Forms\Components\Select::make('branch_id')
                                    ->label('শাখা (Branch)')
                                    ->relationship('branch', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload(),
                                Forms\Components\Select::make('customer_id')
                                    ->label('গ্রাহক (Customer)')
                                    ->relationship('customer', 'name')
                                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->name} ({$record->phone})")
                                    ->searchable(['name', 'phone'])
                                    ->required()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->label('গ্রাহকের নাম')
                                            ->required(),
                                        Forms\Components\TextInput::make('phone')
                                            ->label('মোবাইল নম্বর')
                                            ->required()
                                            ->tel(),
                                        Forms\Components\Textarea::make('address')
                                            ->label('ঠিকানা'),
                                    ]),
                                Forms\Components\DatePicker::make('trial_date')
                                    ->label('ট্রায়াল তারিখ (Trial Date)')
                                    ->native(false),
                                Forms\Components\DatePicker::make('delivery_date')
                                    ->label('ডেলিভারি তারিখ (Delivery Date)')
                                    ->native(false)
                                    ->required(),
                            ])->columns(2),

                        Forms\Components\Section::make('পোশাক ও পরিমাপ তালিকা (Garment Items)')
                            ->schema([
                                Forms\Components\Repeater::make('items')
                                    ->relationship()
                                    ->schema([
                                        Forms\Components\Grid::make(3)
                                            ->schema([
                                                Forms\Components\Select::make('garment_type')
                                                    ->label('পোশাকের ধরন')
                                                    ->options(TailoringDomainService::getGarmentTypes())
                                                    ->required()
                                                    ->live()
                                                    ->afterStateUpdated(function ($state, Set $set) {
                                                        $schema = TailoringDomainService::getMeasurementSchema($state ?? 'panjabi');
                                                        $defaults = [];
                                                        foreach ($schema as $k => $info) {
                                                            $defaults[$k] = $info['default'] ?? 0;
                                                        }
                                                        $set('custom_measurements', $defaults);
                                                    }),
                                                Forms\Components\Select::make('fabric_source')
                                                    ->label('কাপড়ের উৎস')
                                                    ->options([
                                                        'customer_provided' => 'গ্রাহকের নিজস্ব কাপড়',
                                                        'shop_inventory'    => 'দোকানের কাপড় (Stock)',
                                                    ])
                                                    ->default('customer_provided')
                                                    ->live(),
                                                Forms\Components\Select::make('fabric_product_id')
                                                    ->label('দোকানের কাপড় নির্বাচন করুন')
                                                    ->options(Product::where('product_type', 'fabric')->pluck('name', 'id'))
                                                    ->searchable()
                                                    ->visible(fn (Get $get) => $get('fabric_source') === 'shop_inventory')
                                                    ->live()
                                                    ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                                        if ($state) {
                                                            $product = Product::find($state);
                                                            $yards = (float)($get('fabric_yards_used') ?: 2.25);
                                                            $set('fabric_price', $product ? $product->selling_price * $yards : 0);
                                                            $set('subtotal', (float)$get('tailoring_price') + (float)($product ? $product->selling_price * $yards : 0));
                                                        }
                                                    }),
                                            ]),

                                        Forms\Components\Grid::make(4)
                                            ->schema([
                                                Forms\Components\TextInput::make('fabric_yards_used')
                                                    ->label('কাপড়ের পরিমাণ (গজ)')
                                                    ->numeric()
                                                    ->default(2.25)
                                                    ->visible(fn (Get $get) => $get('fabric_source') === 'shop_inventory')
                                                    ->live()
                                                    ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                                        $productId = $get('fabric_product_id');
                                                        if ($productId) {
                                                            $product = Product::find($productId);
                                                            $price = $product ? $product->selling_price * (float)$state : 0;
                                                            $set('fabric_price', $price);
                                                            $set('subtotal', (float)$get('tailoring_price') + $price);
                                                        }
                                                    }),
                                                Forms\Components\TextInput::make('tailoring_price')
                                                    ->label('মজুরি / বানানোর ফি (৳)')
                                                    ->numeric()
                                                    ->default(450.00)
                                                    ->required()
                                                    ->live()
                                                    ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                                        $set('subtotal', (float)$state + (float)$get('fabric_price'));
                                                    }),
                                                Forms\Components\TextInput::make('fabric_price')
                                                    ->label('কাপড়ের দাম (৳)')
                                                    ->numeric()
                                                    ->default(0.00)
                                                    ->readOnly(),
                                                Forms\Components\TextInput::make('subtotal')
                                                    ->label('আইটেম মোট (৳)')
                                                    ->numeric()
                                                    ->default(450.00)
                                                    ->readOnly(),
                                            ]),

                                        Forms\Components\KeyValue::make('custom_measurements')
                                            ->label('শরীরের মাপ (ইঞ্চিতে)')
                                            ->keyLabel('অঙ্গ / মাপের নাম (Length, Chest, Sleeve...)')
                                            ->valueLabel('মাপের মান (ইঞ্চি)')
                                            ->reorderable(),

                                        Forms\Components\KeyValue::make('style_attributes')
                                            ->label('ডিজাইন ও স্টাইল (Collar, Pocket, Cut...)')
                                            ->keyLabel('স্টাইল নাম')
                                            ->valueLabel('পছন্দ'),

                                        Forms\Components\TextInput::make('special_instructions')
                                            ->label('বিশেষ নির্দেশনা (Special Notes)')
                                            ->placeholder('যেমন: ডাবল সেলাই, ব্যান কলার, ২ পাশে পকেট')
                                            ->columnSpanFull(),
                                    ])
                                    ->collapsible()
                                    ->itemLabel(fn (array $state): ?string => isset($state['garment_type']) ? ucfirst($state['garment_type']) : 'আইটেম')
                                    ->defaultItems(1),
                            ]),
                    ])->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('পেমেন্ট ও বিলিং')
                            ->schema([
                                Forms\Components\TextInput::make('subtotal')
                                    ->label('সাবটোটাল (৳)')
                                    ->numeric()
                                    ->default(0.00),
                                Forms\Components\TextInput::make('discount_amount')
                                    ->label('ডিসকাউন্ট (৳)')
                                    ->numeric()
                                    ->default(0.00)
                                    ->live()
                                    ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                        $subtotal = (float)$get('subtotal');
                                        $total = max(0, $subtotal - (float)$state);
                                        $set('total_amount', $total);
                                        $set('due_amount', max(0, $total - (float)$get('advance_amount')));
                                    }),
                                Forms\Components\TextInput::make('total_amount')
                                    ->label('সর্বমোট বিল (৳)')
                                    ->numeric()
                                    ->default(0.00)
                                    ->required(),
                                Forms\Components\TextInput::make('advance_amount')
                                    ->label('জমা / অগ্রিম (৳)')
                                    ->numeric()
                                    ->default(0.00)
                                    ->live()
                                    ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                        $total = (float)$get('total_amount');
                                        $due = max(0, $total - (float)$state);
                                        $set('due_amount', $due);
                                        $set('payment_status', $due <= 0 && $total > 0 ? 'paid' : ((float)$state > 0 ? 'partial' : 'unpaid'));
                                    }),
                                Forms\Components\TextInput::make('due_amount')
                                    ->label('অবশিষ্ট বকেয়া (৳)')
                                    ->numeric()
                                    ->default(0.00)
                                    ->readOnly(),
                                Forms\Components\Select::make('payment_status')
                                    ->label('পেমেন্ট স্ট্যাটাস')
                                    ->options([
                                        'unpaid'  => 'বকেয়া (Unpaid)',
                                        'partial' => 'আংশিক জমা (Partial)',
                                        'paid'    => 'পরিশোধিত (Paid)',
                                    ])
                                    ->default('unpaid'),
                                Forms\Components\Select::make('payment_method')
                                    ->label('পেমেন্ট মাধ্যম')
                                    ->options([
                                        'cash'   => 'নগদ ক্যাশ (Cash)',
                                        'bkash'  => 'বিকাশ (bKash)',
                                        'nagad'  => 'নগদ (Nagad)',
                                        'rocket' => 'রকেট (Rocket)',
                                        'card'   => 'ব্যাংক কার্ড (Card)',
                                        'due'    => 'বাকিতে (Due Ledger)',
                                    ])
                                    ->default('cash'),
                                Forms\Components\TextInput::make('transaction_reference')
                                    ->label('MFS TrxID / রেফারেন্স')
                                    ->placeholder('e.g. 9J4K2L8'),
                            ]),

                        Forms\Components\Section::make('অর্ডার স্ট্যাটাস')
                            ->schema([
                                Forms\Components\Select::make('order_status')
                                    ->label('বর্তমান অবস্থা')
                                    ->options([
                                        'draft'              => 'খসড়া (Draft)',
                                        'confirmed'          => 'অর্ডার নিশ্চিত (Confirmed)',
                                        'in_cutting'         => 'কাটিং চলছে (In Cutting)',
                                        'in_sewing'          => 'সেলাই চলছে (In Sewing)',
                                        'finishing'          => 'আয়রন ও ফিনিশিং (Finishing)',
                                        'ready_for_trial'    => 'ট্রায়াল প্রস্তুত (Ready for Trial)',
                                        'ready_for_delivery' => 'ডেলিভারি প্রস্তুত (Ready for Delivery)',
                                        'delivered'          => 'ডেলিভার্ড (Delivered)',
                                        'altered'            => 'অল্টারেশন (Altered)',
                                        'cancelled'          => 'বাতিল (Cancelled)',
                                    ])
                                    ->default('confirmed')
                                    ->required(),
                                Forms\Components\Textarea::make('notes')
                                    ->label('অতিরিক্ত নোট'),
                            ]),
                    ])->columnSpan(['lg' => 1]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->label('অর্ডার নং')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable(),
                Tables\Columns\TextColumn::make('token_pin')
                    ->label('পিন')
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('গ্রাহক')
                    ->description(fn ($record) => $record->customer->phone ?? '')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('items_count')
                    ->label('পোশাক সংখ্যা')
                    ->counts('items')
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('total_amount')
                    ->label('সর্বমোট')
                    ->money('BDT')
                    ->sortable(),
                Tables\Columns\TextColumn::make('advance_amount')
                    ->label('জমা')
                    ->money('BDT')
                    ->color('success'),
                Tables\Columns\TextColumn::make('due_amount')
                    ->label('বকেয়া')
                    ->money('BDT')
                    ->color('danger')
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('order_status')
                    ->label('স্ট্যাটাস')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft'              => 'gray',
                        'confirmed'          => 'info',
                        'in_cutting'         => 'warning',
                        'in_sewing'          => 'warning',
                        'finishing'          => 'primary',
                        'ready_for_trial'    => 'indigo',
                        'ready_for_delivery' => 'success',
                        'delivered'          => 'success',
                        'altered'            => 'danger',
                        'cancelled'          => 'danger',
                        default              => 'gray',
                    }),
                Tables\Columns\TextColumn::make('delivery_date')
                    ->label('ডেলিভারি তারিখ')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('branch_id')
                    ->label('শাখা')
                    ->relationship('branch', 'name'),
                Tables\Filters\SelectFilter::make('order_status')
                    ->label('স্ট্যাটাস')
                    ->options([
                        'confirmed'          => 'নিশ্চিত',
                        'in_cutting'         => 'কাটিং চলছে',
                        'in_sewing'          => 'সেলাই চলছে',
                        'ready_for_delivery' => 'ডেলিভারি প্রস্তুত',
                        'delivered'          => 'ডেলিভার্ড',
                    ]),
                Tables\Filters\SelectFilter::make('payment_status')
                    ->label('পেমেন্ট')
                    ->options([
                        'unpaid'  => 'বকেয়া',
                        'partial' => 'আংশিক জমা',
                        'paid'    => 'পরিশোধিত',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('thermal_receipt')
                    ->label('রিসিট')
                    ->icon('heroicon-o-printer')
                    ->color('success')
                    ->url(fn (TailoringOrder $record): string => route('order.thermal-receipt', $record))
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('workshop_token')
                    ->label('কাটিং স্লিপ')
                    ->icon('heroicon-o-document-text')
                    ->color('warning')
                    ->url(fn (TailoringOrder $record): string => route('order.workshop-token', $record))
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('mark_ready')
                    ->label('প্রস্তুত মার্ক করুন')
                    ->icon('heroicon-o-check-circle')
                    ->color('indigo')
                    ->visible(fn (TailoringOrder $record) => in_array($record->order_status, ['confirmed', 'in_cutting', 'in_sewing', 'finishing']))
                    ->action(function (TailoringOrder $record) {
                        $record->update(['order_status' => 'ready_for_delivery']);
                        Notification::make()
                            ->title('অর্ডার ডেলিভারির জন্য প্রস্তুত মার্ক করা হয়েছে!')
                            ->success()
                            ->send();
                    }),
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
            'index'  => Pages\ListTailoringOrders::route('/'),
            'create' => Pages\CreateTailoringOrder::route('/create'),
            'edit'   => Pages\EditTailoringOrder::route('/{record}/edit'),
        ];
    }
}
