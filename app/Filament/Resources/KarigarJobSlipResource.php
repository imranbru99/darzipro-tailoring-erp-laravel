<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KarigarJobSlipResource\Pages;
use App\Models\KarigarJobSlip;
use App\Models\TailoringOrderItem;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KarigarJobSlipResource extends Resource
{
    protected static ?string $model = KarigarJobSlip::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'কারিগর ও প্রোডাকশন';

    protected static ?string $navigationLabel = 'কারিগর কাজ ও মজুরি (Artisan Slips)';

    protected static ?string $modelLabel = 'কারিগর জব স্লিপ';

    protected static ?string $pluralModelLabel = 'কারিগর জব স্লিপসমূহ';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('কাজের বিবরণ ও কারিগর বরাদ্দ')
                    ->schema([
                        Forms\Components\Select::make('branch_id')
                            ->label('শাখা')
                            ->relationship('branch', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        Forms\Components\Select::make('karigar_id')
                            ->label('কারিগর / কাটিং মাস্টার')
                            ->options(User::whereIn('role', ['master_cutter', 'karigar'])->pluck('name', 'id'))
                            ->required()
                            ->searchable(),
                        Forms\Components\Select::make('tailoring_order_item_id')
                            ->label('অর্ডারের পোশাক নির্বাচন')
                            ->relationship('orderItem', 'id')
                            ->getOptionLabelFromRecordUsing(fn (TailoringOrderItem $record) => "অর্ডার #{$record->order->order_number} - " . ucfirst($record->garment_type) . " ({$record->order->customer->name})")
                            ->required()
                            ->searchable(),
                        Forms\Components\Select::make('task_type')
                            ->label('কাজের ধরন (Task Type)')
                            ->options([
                                'cutting'       => 'কাটিং (Master Cutting)',
                                'stitching'     => 'সেলাই (Tailor Stitching)',
                                'finishing'     => 'আয়রন ও ফিনিশিং (Finishing & Buttoning)',
                                'embroidery'    => 'কারুকাজ ও এমব্রয়ডারি (Embroidery)',
                            ])
                            ->default('stitching')
                            ->required(),
                        Forms\Components\TextInput::make('rate')
                            ->label('পিস প্রতি মজুরি (৳ Rate)')
                            ->numeric()
                            ->prefix('৳')
                            ->default(250.00)
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->label('কাজের অবস্থা')
                            ->options([
                                'assigned'    => 'বরাদ্দকৃত (Assigned)',
                                'in_progress' => 'চলমান (In Progress)',
                                'completed'   => 'সম্পন্ন (Completed)',
                                'inspected'   => 'যাচাইকৃত (Inspected & Approved)',
                                'rejected'    => 'ত্রুটিপূর্ণ (Rework / Rejected)',
                            ])
                            ->default('assigned')
                            ->required(),
                        Forms\Components\DateTimePicker::make('completed_at')
                            ->label('কাজ শেষ করার সময়')
                            ->native(false),
                        Forms\Components\DateTimePicker::make('paid_at')
                            ->label('মজুরি পরিশোধের সময়')
                            ->native(false),
                        Forms\Components\Textarea::make('notes')
                            ->label('বিশেষ নির্দেশনা বা কারিগরের মন্তব্য')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('orderItem.order.order_number')
                    ->label('অর্ডার নং')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('karigar.name')
                    ->label('কারিগর')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('orderItem.garment_type')
                    ->label('পোশাক')
                    ->badge()
                    ->formatStateUsing(fn ($state) => ucfirst($state)),
                Tables\Columns\TextColumn::make('task_type')
                    ->label('কাজের ধরন')
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'cutting'    => 'কাটিং',
                        'stitching'  => 'সেলাই',
                        'finishing'  => 'ফিনিশিং',
                        'embroidery' => 'কারুকাজ',
                        default      => $state,
                    }),
                Tables\Columns\TextColumn::make('rate')
                    ->label('মজুরি')
                    ->money('BDT')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('স্ট্যাটাস')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'assigned'    => 'gray',
                        'in_progress' => 'warning',
                        'completed'   => 'primary',
                        'inspected'   => 'success',
                        'rejected'    => 'danger',
                        default       => 'gray',
                    }),
                Tables\Columns\IconColumn::make('is_paid')
                    ->label('মজুরি পরিশোধ')
                    ->state(fn (KarigarJobSlip $record) => $record->isWagePaid())
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('karigar_id')
                    ->label('কারিগর')
                    ->options(User::whereIn('role', ['master_cutter', 'karigar'])->pluck('name', 'id')),
                Tables\Filters\SelectFilter::make('task_type')
                    ->label('কাজের ধরন')
                    ->options([
                        'cutting'   => 'কাটিং',
                        'stitching' => 'সেলাই',
                        'finishing' => 'ফিনিশিং',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->label('স্ট্যাটাস')
                    ->options([
                        'assigned'  => 'বরাদ্দকৃত',
                        'completed' => 'সম্পন্ন',
                        'inspected' => 'যাচাইকৃত',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('pay_wage')
                    ->label('মজুরি পরিশোধ')
                    ->icon('heroicon-o-banknotes')
                    ->color('success')
                    ->visible(fn (KarigarJobSlip $record) => !$record->isWagePaid())
                    ->requiresConfirmation()
                    ->action(function (KarigarJobSlip $record) {
                        $record->update(['paid_at' => now(), 'status' => 'inspected']);
                        Notification::make()
                            ->title('মজুরি সফলভাবে পরিশোধ হিসেবে সংরক্ষিত হয়েছে!')
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
            'index'  => Pages\ListKarigarJobSlips::route('/'),
            'create' => Pages\CreateKarigarJobSlip::route('/create'),
            'edit'   => Pages\EditKarigarJobSlip::route('/{record}/edit'),
        ];
    }
}
