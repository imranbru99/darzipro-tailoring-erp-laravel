<?php

namespace App\Services;

class TailoringDomainService
{
    /**
     * Get list of supported garment types with English and Bengali labels.
     */
    public static function getGarmentTypes(): array
    {
        return [
            'panjabi'  => 'পাঞ্জাবি (Panjabi)',
            'pajama'   => 'পায়জামা (Pajama)',
            'shirt'    => 'শার্ট (Executive Shirt)',
            'pant'     => 'প্যান্ট (Formal / Casual Pant)',
            'sherwani' => 'শেরওয়ানি (Sherwani / Prince Coat)',
            'blazer'   => 'স্যুট / ব্লেজার (Blazer / Suit)',
            'kamiz'    => 'কামিজ / কুর্তি (Kamiz / Kurti)',
            'salwar'   => 'সালোয়ার / প্লাজো (Salwar / Palazzo)',
            'blouse'   => 'ব্লাউজ (Designer Blouse)',
            'burqa'    => 'বোরকা / আবায়া (Burqa / Abaya)',
        ];
    }

    /**
     * Get specific measurement schema for a garment type.
     */
    public static function getMeasurementSchema(string $garmentType): array
    {
        return match ($garmentType) {
            'panjabi' => [
                'length'   => ['label' => 'ঝুল (Length)', 'default' => 40, 'unit' => 'inch'],
                'chest'    => ['label' => 'বডি / বুক (Chest)', 'default' => 38, 'unit' => 'inch'],
                'waist'    => ['label' => 'পেট (Waist)', 'default' => 36, 'unit' => 'inch'],
                'hip'      => ['label' => 'কোমর / হিপ (Hip)', 'default' => 40, 'unit' => 'inch'],
                'shoulder' => ['label' => 'পুট / তিরা (Shoulder)', 'default' => 17.5, 'unit' => 'inch'],
                'sleeve'   => ['label' => 'হাতা (Sleeve)', 'default' => 24.5, 'unit' => 'inch'],
                'cuff'     => ['label' => 'মুহুরি (Cuff Opening)', 'default' => 10.5, 'unit' => 'inch'],
                'collar'   => ['label' => 'কলার (Collar Size)', 'default' => 15.5, 'unit' => 'inch'],
            ],
            'pajama' => [
                'length' => ['label' => 'ঝুল (Length)', 'default' => 39, 'unit' => 'inch'],
                'waist'  => ['label' => 'কোমর (Waist)', 'default' => 34, 'unit' => 'inch'],
                'thigh'  => ['label' => 'রান / হাই (Thigh)', 'default' => 26, 'unit' => 'inch'],
                'bottom' => ['label' => 'মুহুরি (Bottom Opening)', 'default' => 15, 'unit' => 'inch'],
                'asan'   => ['label' => 'আসান / কলি (Asan Depth)', 'default' => 15, 'unit' => 'inch'],
            ],
            'shirt' => [
                'length'   => ['label' => 'ঝুল (Length)', 'default' => 29, 'unit' => 'inch'],
                'chest'    => ['label' => 'বুক (Chest)', 'default' => 39, 'unit' => 'inch'],
                'waist'    => ['label' => 'পেট (Waist)', 'default' => 36, 'unit' => 'inch'],
                'hip'      => ['label' => 'হিপ (Hip)', 'default' => 39, 'unit' => 'inch'],
                'shoulder' => ['label' => 'পুট (Shoulder)', 'default' => 18, 'unit' => 'inch'],
                'sleeve'   => ['label' => 'হাতা (Sleeve)', 'default' => 24, 'unit' => 'inch'],
                'cuff'     => ['label' => 'কাফ (Cuff)', 'default' => 9.5, 'unit' => 'inch'],
                'collar'   => ['label' => 'কলার (Collar)', 'default' => 15.5, 'unit' => 'inch'],
            ],
            'pant' => [
                'length' => ['label' => 'ঝুল (Length)', 'default' => 38.5, 'unit' => 'inch'],
                'waist'  => ['label' => 'কোমর (Waist)', 'default' => 32, 'unit' => 'inch'],
                'hip'    => ['label' => 'হিপ (Hip)', 'default' => 38, 'unit' => 'inch'],
                'thigh'  => ['label' => 'রান (Thigh)', 'default' => 24, 'unit' => 'inch'],
                'knee'   => ['label' => 'হাঁটু (Knee)', 'default' => 17.5, 'unit' => 'inch'],
                'bottom' => ['label' => 'মুহুরি (Bottom / Hem)', 'default' => 14.5, 'unit' => 'inch'],
                'fly'    => ['label' => 'হাই (Rise / Fly)', 'default' => 10.5, 'unit' => 'inch'],
            ],
            'kamiz' => [
                'length'     => ['label' => 'ঝুল (Length)', 'default' => 42, 'unit' => 'inch'],
                'bust'       => ['label' => 'বডি / বাস্ট (Bust)', 'default' => 36, 'unit' => 'inch'],
                'waist'      => ['label' => 'পেট / কোমর (Waist)', 'default' => 32, 'unit' => 'inch'],
                'hip'        => ['label' => 'হিপ (Hip)', 'default' => 38, 'unit' => 'inch'],
                'shoulder'   => ['label' => 'পুট (Shoulder)', 'default' => 14, 'unit' => 'inch'],
                'armhole'    => ['label' => 'মহড়া (Armhole)', 'default' => 16, 'unit' => 'inch'],
                'sleeve'     => ['label' => 'হাতা (Sleeve)', 'default' => 18, 'unit' => 'inch'],
                'mohori'     => ['label' => 'মুহুরি (Sleeve Opening)', 'default' => 10, 'unit' => 'inch'],
                'neck_front' => ['label' => 'সামনের গলা (Front Neck)', 'default' => 6, 'unit' => 'inch'],
                'neck_back'  => ['label' => 'পিছনের গলা (Back Neck)', 'default' => 4.5, 'unit' => 'inch'],
                'slit'       => ['label' => 'সাইড ফাটা (Side Slit)', 'default' => 20, 'unit' => 'inch'],
            ],
            'salwar' => [
                'length' => ['label' => 'ঝুল (Length)', 'default' => 38, 'unit' => 'inch'],
                'waist'  => ['label' => 'কোমর (Waist)', 'default' => 40, 'unit' => 'inch'],
                'mohori' => ['label' => 'মুহুরি (Bottom Opening)', 'default' => 12, 'unit' => 'inch'],
                'asan'   => ['label' => 'হাই / আসান (Crotch Rise)', 'default' => 15, 'unit' => 'inch'],
            ],
            'blouse' => [
                'length'     => ['label' => 'ঝুল (Length)', 'default' => 14, 'unit' => 'inch'],
                'bust'       => ['label' => 'বাস্ট (Bust)', 'default' => 34, 'unit' => 'inch'],
                'under_bust' => ['label' => 'কোমর / তলা (Under-bust)', 'default' => 28, 'unit' => 'inch'],
                'shoulder'   => ['label' => 'পুট (Shoulder)', 'default' => 13.5, 'unit' => 'inch'],
                'sleeve'     => ['label' => 'হাতা (Sleeve)', 'default' => 7, 'unit' => 'inch'],
                'mohori'     => ['label' => 'মুহুরি (Arm Opening)', 'default' => 11, 'unit' => 'inch'],
                'neck_front' => ['label' => 'সামনের গলা (Front Neck)', 'default' => 6.5, 'unit' => 'inch'],
                'neck_back'  => ['label' => 'পিছনের গলা (Back Neck)', 'default' => 8, 'unit' => 'inch'],
            ],
            'burqa' => [
                'length'   => ['label' => 'ঝুল (Full Length)', 'default' => 54, 'unit' => 'inch'],
                'body'     => ['label' => 'বডি (Body / Chest)', 'default' => 42, 'unit' => 'inch'],
                'shoulder' => ['label' => 'পুট (Shoulder)', 'default' => 15.5, 'unit' => 'inch'],
                'sleeve'   => ['label' => 'হাতা (Sleeve)', 'default' => 23, 'unit' => 'inch'],
                'flare'    => ['label' => 'ঘের (Bottom Flare)', 'default' => 75, 'unit' => 'inch'],
            ],
            default => [
                'length' => ['label' => 'ঝুল (Length)', 'default' => 30, 'unit' => 'inch'],
                'body'   => ['label' => 'বডি (Body)', 'default' => 36, 'unit' => 'inch'],
            ],
        };
    }

    /**
     * Style choices per garment.
     */
    public static function getStyleOptions(string $garmentType): array
    {
        return match ($garmentType) {
            'panjabi' => [
                'collar_type' => ['ব্যান কলার (Mandarin / Bain)', 'চাইনিজ কলার', 'রেগুলার শার্ট কলার', 'কুর্তা কলার'],
                'placket_type' => ['লুকানো বোতাম পট্টি (Hidden Placket)', 'খোলা শো-বোতাম (Classic Placket)', 'জিপার পট্টি', 'অফ-সেন্টার সাইড ওপেন'],
                'pocket_type' => ['দুই সাইড পকেট', 'এক সাইড পকেট (ডান)', 'সামনে কাবলি পকেট + সাইড পকেট', 'পকেট ছাড়া'],
                'sleeve_type' => ['রেগুলার ঢিলে হাতা', 'শার্ট কাফ হাতা', 'কাবলি বাটন হাতা'],
                'bottom_cut'  => ['সোজা কাট (Straight Cut)', 'গোল কাট (Round Cut)'],
            ],
            'shirt' => [
                'collar_type' => ['রেগুলার পয়েন্ট কলার', 'বাটন ডাউন কলার', 'মান্দারিন ব্যান কলার', 'ওয়াইড স্প্রেড কলার'],
                'cuff_type'   => ['সিঙ্গেল বাটন কাফ', 'ডাবল বাটন কাফ', 'ফ্রেঞ্চ কাফ (French Cuff)'],
                'pocket_type' => ['১টি পকেট (বাম পাশে)', 'পকেট ছাড়া (Plain Front)', '২টি ফ্ল্যাপ পকেট'],
                'bottom_cut'  => ['রাউন্ড টেল কাট (Round Cut)', 'সোজা কাট (Straight Cut)'],
            ],
            'pant' => [
                'pleat_type'  => ['নো-প্লেট স্লিম ফিট', 'সিঙ্গেল প্লেট', 'ডাবল প্লেট ক্লাসিক'],
                'pocket_type' => ['ক্রস পকেট', 'সোজা সাইড পকেট'],
                'back_pocket' => ['২টি বোতাম পকেট', '১টি বোতাম পকেট', 'পকেট ছাড়া'],
                'belt_type'   => ['রেগুলার বেল্ট লুপ', 'এক্সটেন্ডেড ট্যাব (Gurkha Style)', 'সাইড এডজাস্টার'],
            ],
            default => [
                'pattern_cut' => ['স্ট্যান্ডার্ড ফিট', 'স্লিম ফিট', 'রিল্যাক্সড / লুজ ফিট'],
            ],
        };
    }

    /**
     * Calculate required fabric yardage (গজ) based on garment and body size.
     */
    public static function estimateFabricYards(string $garmentType, float $length, float $chest = 38): float
    {
        return match ($garmentType) {
            'panjabi' => $length > 42 || $chest > 42 ? 2.50 : 2.25,
            'pajama'  => 2.25,
            'shirt'   => $chest > 42 ? 2.00 : 1.75,
            'pant'    => 1.35, // 1.25 to 1.50 yards for single pant (58" or 60" width fabric)
            'kamiz'   => 2.50,
            'salwar'  => 2.25,
            'blouse'  => 0.85,
            'burqa'   => 4.00,
            default   => 2.00,
        };
    }
}
