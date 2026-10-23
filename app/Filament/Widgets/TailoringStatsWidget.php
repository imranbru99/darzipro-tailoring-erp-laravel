<?php

namespace App\Filament\Widgets;

use App\Models\KarigarJobSlip;
use App\Models\TailoringOrder;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TailoringStatsWidget extends BaseWidget
{
    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        $todayOrdersCount = TailoringOrder::whereDate('created_at', today())->count();
        $todayCollection = TailoringOrder::whereDate('created_at', today())->sum('advance_amount');
        $readyOrders = TailoringOrder::where('order_status', 'ready_for_delivery')->count();
        $pendingKarigarWages = KarigarJobSlip::whereNull('paid_at')->sum('rate');

        return [
            Stat::make('আজকের নতুন অর্ডার', $todayOrdersCount)
                ->description('আজ গৃহীত টেইলারিং বুকিং')
                ->descriptionIcon('heroicon-m-scissors')
                ->color('info'),

            Stat::make('আজকের মোট জমা / ক্যাশ', '৳' . number_format($todayCollection, 2))
                ->description('অগ্রিম ও আংশিক বিল কালেকশন')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('ডেলিভারি প্রস্তুত অর্ডার', $readyOrders)
                ->description('গ্রাহককে বুঝিয়ে দেওয়ার অপেক্ষায়')
                ->descriptionIcon('heroicon-m-sparkles')
                ->color('primary'),

            Stat::make('কারিগর বকেয়া মজুরি', '৳' . number_format($pendingKarigarWages, 2))
                ->description('পরিশোধযোগ্য কারিগর স্লিপ বিল')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('warning'),
        ];
    }
}
